<?php

namespace App\Http\Controllers\AdminApi;

use App\Helpers\ApiGeneralTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddNewProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminProductController extends Controller
{
    use ApiGeneralTrait;

    public function __construct()
    {
        $this->middleware('auth:admin-api');
    }
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddNewProductRequest $request)
    {
        try {
            DB::beginTransaction();
            $fileName = $this->uploadImage('products', $request->image);
            $addNewProduct = Product::create([
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'weight' => $request->weight,
                'inStock' => $request->inStock,
                'image' => $fileName,
            ]);
            $addNewProduct->save();
            DB::commit();
            return $this->returnSuccessMessage('تم إضافة المنتج بنجاح');
        } catch (\Exception $ex) {
            DB::rollback();
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
        $product = Product::find($id);
        if (!$product) {
            return $this->returnError(404, 'هذا المنتج غير موجود بالسجل');
        }
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        try {
            DB::beginTransaction();
            $product = Product::where('id', $id)->first();
            $addNewFile = '';
            if (!$product) {
                return $this->returnError(404, 'هذا المنتج غير موجود بالسجل');
            }
            if ($request->has('image')) {
                $storgedImage = Str::after($product->image, 'products/');
                $oldImage = public_path("images\\products\\" . $storgedImage);
                unlink($oldImage);
                $addNewFile = $this->uploadImage('products', $request->image);
            }

            $product->update([
                'title' => $request->has('title') ?  $request->title : $product->title,
                'description' => $request->has('description') ? $request->description : $product->description,
                'price' => $request->has('price') ?  $request->price : $product->price,
                'weight' => $request->has('weight') ? $request->weight : $product->weight,
                'inStock' => $request->has('inStock') ? $request->inStock : $product->inStock,
                'image' => $request->has('image') ? $addNewFile : $product->image,
            ]);

            $product->save();
            DB::commit();
            return $this->returnSuccessMessage('تم تحديث المنتج بنجاح');
        } catch (\Exception $ex) {
            DB::rollback();
            return $this->returnError(404, $ex);
            // return $this->returnError(404, 'لم تتم العملية - يوجد خطأ ما');

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
            $product = Product::find($id);
            if (!$product)
                return $this->returnError(404, 'هذا المنتج غير موجود');
            $product->delete();
            return $this->returnSuccessMessage('تم حذف المنتج بنجاح');
        } catch (\Exception $ex) {
            return $this->returnError(404, 'لم تتم العملية - يوجد خطأ ما');
        }
    }
}
