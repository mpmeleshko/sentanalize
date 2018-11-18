<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ReviewRepositoryInterface;
use App\Review;
use Prettus\Repository\Eloquent\BaseRepository;

class ReviewRepository extends BaseRepository implements ReviewRepositoryInterface
{
    /**
     * @return string
     */
    public function model()
    {
        return Review::class;
    }
}