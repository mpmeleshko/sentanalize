<?php

namespace App\Http\Controllers;


use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Services\ReviewsChart;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;
    /**
     * @var ReviewsChart
     */
    private $reviewsChart;

    public function __construct(ProductRepositoryInterface $productRepository, CategoryRepositoryInterface $categoryRepository, ReviewsChart $reviewsChart)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->reviewsChart = $reviewsChart;
    }

    public function index(Request $request)
    {
        $categories = $this->categoryRepository->all();
        $categoryId = $request->get('category_id') ?? $categories->first()->id;
        $search = $request->get('search');
        $products = $this->productRepository->getProductsByCategory($categoryId);
        if ($search) {
            $products = $this->productRepository->getProductsBySearch($categoryId, $search);
        }

        return view('product.index', compact('products', 'categories', 'search'));
    }

    public function show($id)
    {
        $product = $this->productRepository->find($id);
        $chartDonut = $this->reviewsChart->makeDonutChart($product->reviews);

        return view('product.show', compact('product', 'chartDonut'));
    }
}