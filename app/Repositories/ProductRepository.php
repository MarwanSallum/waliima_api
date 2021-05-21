<?php
namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\ApiGeneralTrait;
use Illuminate\Support\Facades\DB;

class ProductRepository extends AppRepository
{
    use ApiGeneralTrait;

    protected $model;

    public function __construct(Product $product)
    {
        $this->model = $product;
    }

    protected function setDataPayload(Request $request)
    {
        $fileName = $this->uploadImage('products', $request->file('image'));
        return [
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'image' => $fileName,
            'price' => $request->input('price'),
            'weight' => $request->input('weight'),
            'inStock' => $request->input('inStock'),
        ];
    }
}