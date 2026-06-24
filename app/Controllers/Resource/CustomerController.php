<?php

namespace App\Controllers\Resource;

use App\Controllers\BaseController;
use App\Services\CustomerService;
use App\Repository\CustomerRepository;
use App\Models\Customer;

class CustomerController extends BaseController
{
    protected CustomerService $customerService;

    public function __construct()
    {
        $this->customerService = new CustomerService(new CustomerRepository(new Customer()));
    }

    public function index()
    {
        $filters = [
            'company_name' => $this->request->getGet('search_company_name'),
            'contact_person' => $this->request->getGet('search_contact_person')
        ];

        $limit = (int) ($this->request->getGet('limit') ?? 10);
        $result = $this->customerService->getPaginated($filters, $limit);

        return view('customers/index', [
            'title' => 'Customer Management',
            'data' => $result['data'],
            'pager' => $result['pager'],
            'filters' => $filters,
            'limit' => $limit
        ]);
    }

    public function create()
    {
        return view('customers/create', ['title' => 'Add New Customer']);
    }

    public function store()
    {
        if (!$this->validate('customerRules')) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->request->getPost();
        $this->customerService->create($data);

        return redirect()->to('/customers')->with('success', 'Customer has been successfully created.');
    }

    public function edit($id)
    {
        $customer = $this->customerService->getById($id);
        return view('customers/edit', [
            'title' => 'Edit Customer',
            'customer' => $customer
        ]);
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        $data['id'] = $id;

        if (!$this->validateData($data, 'customerRules')) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->customerService->update($id, $data);

        return redirect()->to('/customers')->with('success', 'Customer has been successfully updated.');
    }

    public function delete($id)
    {
        $this->customerService->delete($id);
        return redirect()->to('/customers')->with('success', 'Customer has been successfully deleted.');
    }
}