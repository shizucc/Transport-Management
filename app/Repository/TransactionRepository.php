<?php
namespace App\Repository;
use App\Models\Transaction;
use App\Repository\BaseRepository;
use Exception;


class TransactionRepository extends BaseRepository {
    protected Transaction $transactionModel;
    protected string $resourceName = "Transaction";
    protected array $filterable = [
        'invoice_number' => 'exact',
        'invoice_date' => 'date',
        'pic_name' => 'like',
        'grand_total' => 'exact'
    ];

    public function __construct(Transaction $transaction){
        $this->transactionModel = $transaction;
        parent::__construct($transaction);
    }
    public function getByIdWithDetails(int|string $id): array
    {
        $header = $this->transactionModel->getTransactionWithCustomer($id);

        if (!$header) {
            throw new Exception("{$this->resourceName} with ID {$id} not found");
        }
        $details = $this->transactionModel->getDetails($id);
        return [
            'header'  => $header,
            'details' => $details
        ];
    }


}