<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list' => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------
    public $customerRules = [
        'company_name' => [
            'rules' => 'required|min_length[3]|max_length[150]',
            'errors' => [
                'required' => 'Company name is required.',
                'min_length' => 'Company name must be at least 3 characters long.',
                'max_length' => 'Company name cannot exceed 150 characters.'
            ]
        ],
        'contact_person' => [
            'rules' => 'required|min_length[3]|max_length[100]',
            'errors' => [
                'required' => 'Contact Person is required.',
                'min_length' => 'Contact Person must be at least 3 characters long.',
                'max_length' => 'Contact Person cannot exceed 100 characters.'
            ]
        ],
        'address' => [
            'rules' => 'required|min_length[5]|max_length[255]',
            'errors' => [
                'required' => 'Address is required.',
                'min_length' => 'Address must be at least 5 characters long.',
                'max_length' => 'Address cannot exceed 255 characters.'
            ]
        ]
    ];
    public $productRules = [
        'id'=> [
            'rules' => 'required'
        ],
        'product_code' => [
            'rules' => 'required|max_length[20]|is_unique[products.product_code,id,{id}]',
            'errors' => [
                'required' => 'Product Code is required.',
                'max_length' => 'Product Code cannot exceed 20 characters.',
                'is_unique' => 'This Product Code is already in use.'
            ]
        ],
        'product_name' => [
            'rules' => 'required|min_length[3]|max_length[150]',
            'errors' => [
                'required' => 'Product Name is required.',
                'min_length' => 'Product Name must be at least 3 characters long.',
                'max_length' => 'Product Name cannot exceed 150 characters.'
            ]
        ],
        'unit' => [
            'rules' => 'required|max_length[50]',
            'errors' => [
                'required' => 'Unit is required.',
                'max_length' => 'Unit cannot exceed 50 characters.'
            ]
        ],
        'price' => [
            'rules' => 'required|numeric|greater_than_equal_to[0]',
            'errors' => [
                'required' => 'Price is required.',
                'numeric' => 'Price must be a valid number.',
                'greater_than_equal_to' => 'Price cannot be negative.'
            ]
        ]
    ];
    public $transactionRules = [
        'id'=> [
            'rules' => 'required'
        ],
        'invoice_number' => [
            'rules' => 'required|max_length[50]|is_unique[transactions.invoice_number,id,{id}]',
            'errors' => [
                'required' => 'Invoice Number is required.',
                'max_length' => 'Invoice Number cannot exceed 50 characters.',
                'is_unique' => 'This Invoice Number already exists.'
            ]
        ],
        'invoice_date' => [
            'rules' => 'required|valid_date[Y-m-d]',
            'errors' => [
                'required' => 'Invoice Date is required.',
                'valid_date' => 'Invoice Date must be a valid date format (YYYY-MM-DD).'
            ]
        ],
        'customer_id' => [
            'rules' => 'required|numeric|is_not_unique[customers.id]',
            'errors' => [
                'required' => 'Customer selection is required.',
                'numeric' => 'Invalid customer format.',
                'is_not_unique' => 'Selected customer does not exist in the database.'
            ]
        ],
        'pic_name' => [
            'rules' => 'required|min_length[3]|max_length[100]',
            'errors' => [
                'required' => 'PIC Name is required.',
                'min_length' => 'PIC Name must be at least 3 characters long.',
                'max_length' => 'PIC Name cannot exceed 100 characters.'
            ]
        ],
        'items.*.product_id' => [
            'rules' => 'required|numeric|is_not_unique[products.id]',
            'errors' => [
                'required' => 'Each item must include a product selection.',
                'numeric' => 'Each item product must be a valid product id.',
                'is_not_unique' => 'One or more selected products do not exist.'
            ]
        ],
        'items.*.qty' => [
            'rules' => 'required|integer|greater_than_equal_to[1]',
            'errors' => [
                'required' => 'Quantity is required for each item.',
                'integer' => 'Quantity must be a whole number.',
                'greater_than_equal_to' => 'Quantity must be at least 1.'
            ]
        ],
    ];
}
