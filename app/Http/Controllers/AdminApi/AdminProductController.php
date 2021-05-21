<?php

namespace App\Http\Controllers\AdminApi;

use App\Helpers\ApiGeneralTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddNewProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminProductController extends Controller
{
    use ApiGeneralTrait;

    protected $repository;
    
    public function __construct(ProductRepository $repository)
    {
        $this->middleware('auth:admin-api');
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
   * Undocumented function
   *
   * @param AddNewProductRequest $request
   * @return void
   */
    public function store(AddNewProductRequest $request)
    {
        try {
            $product = $this->repository->store($request);
            return new ProductResource($product);
        } catch (\Exception $ex) {
            return $this->returnError(404, 'حدث خطأ ما - لم تتم الإضافة');
        }
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
        } catch(Exception $e){
            return $this->returnError(404, 'هذا المنتج غير موجود بالسجل');
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $this->repository->updateProduct($request, $id);
            return $this->returnSuccessMessage('تم تحديث المنتج بنجاح');
        }catch(Exception $e){
            return $this->returnError(404, 'حدث خطأ ما - لم يتم التحديث');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->repository->delete($id);
            return $this->returnSuccessMessage('تم حذف المنتج بنجاح');
        } catch (\Exception $ex) {
            return $this->returnError(404, 'لم تتم العملية - يوجد خطأ ما');
        }
    }
}
