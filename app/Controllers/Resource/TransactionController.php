<?php

namespace App\Controllers\Resource;

use App\Controllers\BaseController;
use App\Services\TransactionService;
use App\Repository\TransactionRepository;
use App\Models\Transaction;

use App\Services\CustomerService;
use App\Repository\CustomerRepository;
use App\Models\Customer;

use App\Services\ProductService;
use App\Repository\ProductRepository;
use App\Models\Product;

class TransactionController extends BaseController
{
    protected TransactionService $transactionService;
    protected CustomerService $customerService;
    protected ProductService $productService;

    public function __construct()
    {
        $this->transactionService = new TransactionService(new TransactionRepository(new Transaction()));
        $this->customerService = new CustomerService(new CustomerRepository(new Customer()));
        $this->productService = new ProductService(new ProductRepository(new Product()));
    }

    public function index()
    {
        $filters = [
            'invoice_number' => $this->request->getGet('search_invoice_number'),
            'pic_name'       => $this->request->getGet('search_pic_name')
        ];

        $limit = (int) ($this->request->getGet('limit') ?? 10);
        $result = $this->transactionService->getPaginated($filters, $limit);

        return view('transactions/index', [
            'title'   => 'Transaction Records',
            'data'    => $result['data'],
            'pager'   => $result['pager'],
            'filters' => $filters,
            'limit'   => $limit
        ]);
    }

    public function create()
    {
        $customers = $this->customerService->getPaginated([], 1000)['data'];
        $products  = $this->productService->getPaginated([], 1000)['data'];

        return view('transactions/create', [
            'title'     => 'Create New Invoice',
            'customers' => $customers,
            'products'  => $products
        ]);
    }

    public function store()
    {
        if (!$this->validate('transactionRules')) {
            dd($error = $this->validator->getErrors());
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->request->getPost();
        $this->transactionService->create($data);

        return redirect()->to('/transactions')->with('success', 'Transaction has been successfully saved.');
    }

    public function show($id)
    {
        $transaction = $this->transactionService->getByIdWithDetails($id);

        return view('transactions/show', [
            'title'       => 'Invoice Detail',
            'transaction' => $transaction
        ]);
    }

    public function delete($id)
    {
        $this->transactionService->delete($id);
        return redirect()->to('/transactions')->with('success', 'Transaction has been successfully deleted.');
    }
}