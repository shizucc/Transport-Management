<?php
namespace App\Services;

use App\Repository\CustomerRepository;

class CustomerService extends BaseService
{
    public function __construct(CustomerRepository $repository)
    {
        parent::__construct($repository);
    }
}