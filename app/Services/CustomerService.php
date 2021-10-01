<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection as Collection;
use App\Http\Resources\BaseResource;
use App\Repositories\CustomerRepository;

class CustomerService extends BaseService
{
    public function __construct(CustomerRepository $repo)
    {
        parent::__construct($repo);
    }
}
