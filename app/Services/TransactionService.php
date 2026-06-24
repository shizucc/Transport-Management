<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Product;
use App\Repository\ProductRepository;
use App\Repository\TransactionRepository;
use App\Models\TransactionDetail;
use CodeIgniter\Database\Exceptions\DatabaseException;
use Exception;

class TransactionService extends BaseService
{
    protected TransactionDetail $detailModel;
    protected Product $productModel;
    protected TransactionRepository $transactionRepository;

    public function __construct(TransactionRepository $repository)
    {
        parent::__construct($repository);
        $this->transactionRepository = $repository;
        $this->productModel = new Product();
        $this->detailModel = new TransactionDetail(); 
    }

    public function getByIdWithDetails($id)
    {
        return $this->transactionRepository->getByIdWithDetails($id);
    }
    public function create(array $data)
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $headerData = [
                'invoice_number' => $data['invoice_number'],
                'invoice_date'   => $data['invoice_date'],
                'customer_id'    => $data['customer_id'],
                'pic_name'       => $data['pic_name'],
                'grand_total'    => 0 
            ];

            $transactionId = $this->repository->create($headerData);
            $grandTotal = 0;
            $detailsData = [];

            $items = $data['items'] ?? [];
            foreach ($items as $item) {
                $productId = $item['product_id'] ?? null;
                if (empty($productId)) {
                    continue;
                    }
                 $product = $this->productModel->find($productId);

                $qty = (int) ($item['qty'] ?? 0);
                $price = (float) ($product->price ?? 0);
                $subtotal = $qty * $price;

                $grandTotal += $subtotal;

                $detailsData[] = [
                    'transaction_id' => $transactionId,
                    'product_id'     => $productId,
                    'qty'            => $qty,
                    'price'          => $price,
                    'subtotal'       => $subtotal
                ];
            }

            if (!empty($detailsData)) {
                $this->detailModel->insertBatch($detailsData);
            }

            $this->repository->update($transactionId, ['grand_total' => $grandTotal]);
            if ($db->transStatus() === false) {
                throw new DatabaseException('Transaction failed.');
            }
            
            $db->transCommit();
            return $transactionId;

        } catch (Exception $e) {
            $db->transRollback();
            throw new Exception("Failed to save transaction: " . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $this->detailModel->where("transaction_id", $id)->delete();
            $this->repository->delete($id);
            $db->transCommit();
            return $id;
        } catch (Exception $e){
            $db->transRollback();
            throw new Exception("Failed to delete: " . $e->getMessage());
        }
    }
}