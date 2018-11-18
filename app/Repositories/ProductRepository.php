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

    public function getProductsByCategory($id)
    {
        return $this->model
            ->where('category_id', $id)
            ->paginate(12);
    }
}
