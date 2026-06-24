<?php
namespace App\Repository;
use App\Models\Product;
use App\Repository\BaseRepository;

class ProductRepository extends BaseRepository {
    protected string $resourceName = "Product";
    protected array $filterable = [
        'product_code' => 'like',
        'product_name' => 'like',
        'price' => 'exact'
    ];

    public function __construct(Product $product){
        parent::__construct($product);
    }


}