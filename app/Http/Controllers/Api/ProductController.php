<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiGeneralTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiGeneralTrait;

    public function __construct()
    {
     $this->middleware('auth:api')->except(['index']);
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
    public function store(ProductRequest $request)
    {
        if(auth() ->user()-> hasRole('super_admin')){

            $imagePath = $this ->uploadImage('products',$request ->image);

            try{
                $new_product = Product::create([
                    'user_id' => $this ->getAuthenticatedUser(),
                    'category_id' => $request ->category_id,
                    'name' => $request ->name,
                    'image' => $imagePath,
                    'description' => $request ->description,
                    'price' =>$request->price,
                    'weight' =>$request->weight,
                ]);
                $new_product ->save();
                return new ProductResource($new_product);

            }catch(\ReflectionException $ex){
                return $this ->returnError(404,'يوجد خطأ ما برجاء المحاولة لاحقا');
            }
        }
        return $this -> returnError(401, 'أنت غير مصرح لك بإضافة منتج جديد  ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
