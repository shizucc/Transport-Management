<?php
namespace App\Services;

use App\Repository\ProductRepository;

class ProductService extends BaseService
{
    public function __construct(ProductRepository $repository)
    {
        parent::__construct($repository);

    }

}