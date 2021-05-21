<?php

namespace App\Http\Controllers\UserApi;

use App\Models\Product;
use App\Helpers\ApiGeneralTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Repositories\ProductRepository;
use Exception;
use Illuminate\Support\Facades\Request;

class ProductController extends Controller
{
    use ApiGeneralTrait;

    protected $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->repository->paginate();
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
        try{
            $product = $this->repository->show($id);
            return new ProductResource($product);
        }catch(Exception $e){
            return $this->returnError(404, 'هذا المنتج غير موجود بالسجل');
        }
    }

}
