<?php

namespace App\Repositories;

use App\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class ProductRepositoryRepositoryInterfaceEloquent.
 *
 * @package namespace App\Repositories;
 */
class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Product::class;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getProductsByCategory($id)
    {
        return $this->model
            ->where('category_id', $id)
            ->paginate(12);
    }

    /**
     * @param $categoryId
     * @param $search
     * @return mixed
     */
    public function getProductsBySearch($categoryId, $search)
    {
        return $this->model
            ->where('category_id', $categoryId)
            ->where('name', 'like', '%'.$search.'%')
            ->orWhere('description', 'like', '%'.$search.'%')
            ->paginate(12);
    }
}
