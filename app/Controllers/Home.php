<?php

namespace App\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Transaction;
use App\Repository\CustomerRepository;
use App\Repository\ProductRepository;
use App\Repository\TransactionRepository;
use App\Services\CustomerService;
use App\Services\ProductService;
use App\Services\TransactionService;



class Home extends BaseController
{
    protected CustomerService $customerService;
    protected ProductService $productService;
    protected TransactionService $transactionService;

    public function __construct()
    {
        $this->customerService = new CustomerService(new CustomerRepository(new Customer()));
        $this->productService = new ProductService(new ProductRepository(new Product()));
        $this->transactionService = new TransactionService(new TransactionRepository(new Transaction()));
    }
    public function index(): string
    {
        $countCustomer = $this->customerService->count();
        $countProduct = $this->productService->count();
        $countTransaction = $this->transactionService->count();
        return view('home', [
            'title' => 'Dashboard',
            'countCustomer' => $countCustomer,
            'countProduct' => $countProduct,
            'countTransaction' => $countTransaction
        ]);
    }
}
