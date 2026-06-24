<?php

namespace App\Models;

use CodeIgniter\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = [
        'invoice_number',
        'invoice_date',
        'customer_id',
        'pic_name',
        'grand_total'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];
    public function getTransactionWithCustomer($id = null)
    {
        $builder = $this->select('transactions.*, customers.company_name, customers.contact_person, customers.address')
            ->join('customers', 'customers.id = transactions.customer_id')
            ->where('customers.deleted_at', null);

        if ($id === null) {
            return $builder->orderBy('transactions.invoice_date', 'DESC')->findAll();
        }

        return $builder->where('transactions.id', $id)->first();
    }
    public function getDetails($transactionId)
    {
        return $this->db->table('transaction_details')
            ->select('transaction_details.*, products.product_code, products.product_name, products.unit')
            ->join('products', 'products.id = transaction_details.product_id')
            ->where('transaction_details.transaction_id', $transactionId)
            ->where('transaction_details.deleted_at', null) 
            ->get()->getResult();
    }
}
