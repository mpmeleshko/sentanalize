<?php

namespace App\Repositories\Interfaces;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ProductRepositoryInterface.
 *
 * @package namespace App\Repositories;
 */
interface ProductRepositoryInterface extends RepositoryInterface
{
    public function getProductsByCategory($id);

    public function getProductsBySearch($categoryId, $search);
}
