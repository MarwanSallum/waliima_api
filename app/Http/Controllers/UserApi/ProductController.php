<?php

namespace App\Http\Controllers\UserApi;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\ApiGeneralTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Database\Eloquent\Model;

class ProductController extends Controller
{
    use ApiGeneralTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(5);
        return ProductResource::collection($products);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return $this->returnError(404, 'هذا المنتج غير موجود بالسجل');
        }
        return new ProductResource($product);
    }

}
