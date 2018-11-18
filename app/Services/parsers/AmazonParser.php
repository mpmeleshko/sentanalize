<?php

namespace App\Services\parsers;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use Illuminate\Support\Facades\Log;
use simplehtmldom_1_5\simple_html_dom;
use Sunra\PhpSimple\HtmlDomParser;

class AmazonParser
{
    const MAIN_PAGE = 'http://rozetka.com.ua/';

    /**
     * @var HTMLDomParser
     */
    private $HTMLDomParser;
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var ReviewRepositoryInterface
     */
    private $reviewRepository;


    /**
     * AmazonParser constructor.
     * @param HtmlDomParser $HTMLDomParser
     * @param ProductRepositoryInterface $productRepository
     * @param ReviewRepositoryInterface $reviewRepository
     */
    public function __construct(
        HtmlDomParser $HTMLDomParser,
        ProductRepositoryInterface $productRepository,
        ReviewRepositoryInterface $reviewRepository
    )
    {
        $this->HTMLDomParser = $HTMLDomParser;
        $this->productRepository = $productRepository;
        $this->reviewRepository = $reviewRepository;
    }

    private function getDomPage($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_REFERER, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $str = curl_exec($curl);
        curl_close($curl);

        $dom = new simple_html_dom();
        $html = $dom->load($str);

        return $html;
    }

    public function parseProducts()
    {
        $url = self::MAIN_PAGE . '/notebooks/c80004/filter/';

        $html = $this->getDomPage($url);
        if (!$html) {
            return 'Can\'t connect to page' . $url;
        }

        $countPages = (int) $html->find('li[class="paginator-catalog-l-i pos-fix"]')[3]->find('span[class="paginator-catalog-l-i-active"]')[0]->plaintext;
        for ($i = 1; $i <= $countPages; $i++) {
            $page = $this->getDomPage($url . 'page='. (string) $i);
            if (!$page) {
                return 'Can\'t connect to page' . $url . 'page='. (string) $i;
            }

            $list = $page->find('div[class="g-i-tile g-i-tile-catalog"]');
            if (!$list) {
                return 'Can\'t find products page' . $url . 'page='. (string) $i;
            }

            foreach ($list as $product) {
                $productUrl = $product->find('div[class="g-i-tile-i-title"]')[0]->find('a')[0]->href;
                $name = $product->find('div[class="g-i-tile-i-title"]')[0]->find('a')[0]->plaintext;
                $description = $product->find('div[class="short-description"]')[0]->plaintext ?? '';

                $product = $this->productRepository->firstOrCreate([
                    'name' => $name,
                    'description' => $description,
                    'url' => $productUrl
                ]);
                Log::info($product);
            }
        }

        return 'true';
    }

    public function getDetails()
    {
        $products = $this->productRepository->findWhere(['image' => null, 'price' => null]);

        foreach ($products as $product) {
            $page = $this->getDomPage($product->url);
            if (!$page) {
                return 'Can\'t connect to page' . $product->url;
            }

            $image = $page->find('div[id="detail_image_container"]')[0]->find('a')[0]->href ?? 0;
            $price = $page->find('meta[itemprop="price"]')[0]->content ?? 0;

            $product->image = $image;
            $product->price = $price;
            $product->save();

            Log::info($product);
        }
    }

    public function getReviews()
    {
        $products = $this->productRepository->all();

        foreach ($products as $product) {
            $page = $this->getDomPage($product->url . '#tab=comments');

            if (!$page) {
                return 'Can\'t connect to page' . $product->url;
            }

            $list = $page->find('article[class="pp-review-i"]');

            if (!empty($list)) {
                foreach ($list as $review) {
                    $author = trim($review->find('span[class="pp-review-author-name"]')[0]->plaintext);
                    $bigReview = $review->find('div[class="pp-review-text-i"]');
                    $reviewText = trim($bigReview[0]->plaintext);
                    $quality = count($bigReview) > 1 ? trim($bigReview[1]->plaintext) : null;
                    $defect = count($bigReview) > 2 ? trim($bigReview[2]->plaintext) : null;
                    $date = $review->find('meta[itemprop="datePublished"]')[0]->content;

                    $reviewData = $this->reviewRepository->firstOrCreate([
                        'product_id' => $product->id,
                        'author' => $author,
                        'review' => $reviewText,
                        'quality' => $quality,
                        'defect' => $defect,
                        'date' => $date ?? null
                    ]);

                    Log::info($reviewData);
                }
            }
        }
    }
}