<?php
namespace App\Repository;

use App\Models\TransactionDetail;



class TransactionDetailRepository extends BaseRepository{
    protected string $resourceName = "Transaction Detail";
    protected array $filterable = [];

    public function __construct(TransactionDetail $transactionDetail){
        parent::__construct($transactionDetail);
    }


}