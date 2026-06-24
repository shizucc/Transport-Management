<?php
namespace App\Services;

use App\Repository\TransactionDetailRepository;

class TransactionDetailService extends BaseService
{
    public function __construct(TransactionDetailRepository $repository)
    {
        parent::__construct($repository);

    }

}