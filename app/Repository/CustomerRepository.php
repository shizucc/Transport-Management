<?php
namespace App\Repository;

use App\Models\Customer;
use App\Repository\BaseRepository;


class CustomerRepository extends BaseRepository {
    protected string $resourceName = "Customer";
    protected array $filterable = [
        'company_name' => 'like',
        'contact_person' => 'like',
    ];

    public function __construct(Customer $customer){
        parent::__construct($customer);
    }


}