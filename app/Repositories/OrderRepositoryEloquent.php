<?php

namespace CodeFlix\Repositories;

use CodeFlix\Models\Order;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;


/**
 * Class OrderRepositoryEloquent
 * @package namespace CodeFlix\Repositories;
 */
class OrderRepositoryEloquent extends BaseRepository implements OrderRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Order::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
