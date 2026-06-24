<?php

namespace App\Controllers\Resource;

use App\Controllers\BaseController;
use App\Services\ProductService;
use App\Repository\ProductRepository;
use App\Models\Product;

class ProductController extends BaseController
{
    protected ProductService $productService;

    public function __construct()
    {
        $this->productService = new ProductService(new ProductRepository(new Product()));
    }

    public function index()
    {
        $filters = [
            'product_code' => $this->request->getGet('search_product_code'),
            'product_name' => $this->request->getGet('search_product_name')
        ];

        $limit = (int) ($this->request->getGet('limit') ?? 10);
        $result = $this->productService->getPaginated($filters, $limit);

        return view('products/index', [
            'title'   => 'Product Management',
            'data'    => $result['data'],
            'pager'   => $result['pager'],
            'filters' => $filters,
            'limit'   => $limit
        ]);
    }

    public function create()
    {
        return view('products/create', ['title' => 'Add New Product']);
    }

    public function store()
    {
        if (!$this->validate('productRules')) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->request->getPost();
        $this->productService->create($data);

        return redirect()->to('/products')->with('success', 'Product has been successfully created.');
    }

    public function edit($id)
    {
        $product = $this->productService->getById($id);
        return view('products/edit', [
            'title'   => 'Edit Product',
            'product' => $product
        ]);
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        $data['id'] = $id;

        if (!$this->validateData($data, 'productRules')) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->productService->update($id, $data);

        return redirect()->to('/products')->with('success', 'Product has been successfully updated.');
    }

    public function delete($id)
    {
        $this->productService->delete($id);
        return redirect()->to('/products')->with('success', 'Product has been successfully deleted.');
    }
}