<?php
namespace App\Repository;
use App\Models\Transaction;
use App\Repository\BaseRepository;
use CodeIgniter\Model;
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

    public function paginate(int $perPage = 10, array $filters = [], string $group = 'default'): array
    {
        $model = clone $this->model;
        $model->select('transactions.*, customers.company_name AS customer_company_name');
        $model->join('customers', 'customers.id = transactions.customer_id', 'left');

        if (!empty($filters)) {
            $model = $this->applyFiltersToModel($model, $filters);
        }

        return [
            'data'  => $model->paginate($perPage, $group),
            'pager' => $model->pager,
        ];
    }

    private function applyFiltersToModel(Model $model, array $filters): Model
    {
        foreach ($filters as $field => $value) {
            if (!array_key_exists($field, $this->filterable) || $value === null || $value === '') {
                continue;
            }

            $type = $this->filterable[$field];

            switch ($type) {
                case 'like':
                    $model->like($field, $value);
                    break;
                case 'date':
                    $model->where("DATE({$field})", $value);
                    break;
                default:
                    $model->where($field, $value);
                    break;
            }
        }

        return $model;
    }

    public function getByIdWithDetails(int|string $id): array
    {
        $header = $this->transactionModel->getTransactionWithCustomer($id);

        if (!$header) {
            throw new Exception("{$this->resourceName} with ID {$id} not found");
        }
        $details = $this->transactionModel->getDetails($id);
        $totalUnitPrice = 0;
        $totalQuantity = 0;

        foreach ($details as $detail) {
            $totalUnitPrice += $detail->price;
            $totalQuantity += $detail->qty;
        }
        return [
            'header'  => $header,
            'details' => $details,
            'totalUnitPrice' => $totalUnitPrice,
            'totalQuantity' => $totalQuantity
        ];
    }


}