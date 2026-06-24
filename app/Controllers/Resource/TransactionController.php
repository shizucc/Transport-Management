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
use Dompdf\Dompdf;
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

    public function edit($id)
    {
        $transaction = $this->transactionService->getByIdWithDetails($id);
        $customers = $this->customerService->getPaginated([], 1000)['data'];
        $products  = $this->productService->getPaginated([], 1000)['data'];

        return view('transactions/create', [
            'title'       => 'Edit Invoice',
            'transaction' => $transaction,
            'customers'   => $customers,
            'products'    => $products
        ]);
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        $data['id'] = $id;

        if (!$this->validateData($data, 'transactionRules')) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->transactionService->update($id, $data);

        return redirect()->to('/transactions')->with('success', 'Transaction has been successfully updated.');
    }

    public function download($id)
    {
        $transaction = $this->transactionService->getByIdWithDetails($id);
        $html = view('transactions/pdf', [
            'transaction' => $transaction
        ]);

        $invoiceNumber = preg_replace('/[^A-Za-z0-9]+/', '_', trim($transaction['header']->invoice_number ?? 'invoice'));
        $companyName = preg_replace('/[^A-Za-z0-9]+/', '_', trim($transaction['header']->company_name ?? 'company'));
        $filename = sprintf('%s_%s.pdf', $invoiceNumber, $companyName);

        $dompdf = new Dompdf;
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $this->response
            ->setBody($dompdf->output())
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function delete($id)
    {
        $this->transactionService->delete($id);
        return redirect()->to('/transactions')->with('success', 'Transaction has been successfully deleted.');
    }
}