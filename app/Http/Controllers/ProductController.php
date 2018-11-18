<?php

namespace App\Http\Controllers;


use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
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

    public function __construct(ProductRepositoryInterface $productRepository, CategoryRepositoryInterface $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index(Request $request)
    {
        $categories = $this->categoryRepository->all();
        $categoryId = $request->get('category_id') ?? $categories->first()->id;
        $products = $this->productRepository->getProductsByCategory($categoryId);

        return view('product.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = $this->productRepository->find($id);

        return view('product.show', compact('product'));
    }
}