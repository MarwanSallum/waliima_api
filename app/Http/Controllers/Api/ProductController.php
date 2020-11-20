<?php

namespace App\Http\Controllers\Api;

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

    public function __construct()
    {
     $this->middleware('auth:api')->except(['index','show']);
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
        if(auth() ->user()-> hasRole('super_admin')){

            try{
                
                if(Product::where('id', $id)->exists()){
                    $product = Product::find($id);

                    if($request ->hasFile('image')){
                        $storgedImage = Str::after($product->image,'images/');
                    $image = public_path('images/'. $storgedImage);
                    unlink($image);
                    }

                    $product ->category_id = is_null($request->category_id)
                        ? $product->category_id 
                        : $request->category_id;

                    $product ->name = is_null($request->name)
                        ? $product->name 
                        : $request->name;

                    $product ->description = is_null($request->description)
                        ? $product->description 
                        : $request->description;

                    $product ->price = is_null($request->price)
                        ? $product->price 
                        : $request->price;

                    $product ->weight = is_null($request->weight)
                        ? $product->weight 
                        : $request->weight;

                    $product ->image = is_null($request ->image)
                        ? $product->image
                        : $this->uploadImage('products',$request->image);

                    $product ->save();
                }

                
                return new ProductResource($product);

            }catch(\ReflectionException $ex){
                return $this ->returnError(404,'يوجد خطأ ما برجاء المحاولة لاحقا');
            }
        }
        return $this -> returnError(401, 'أنت غير مصرح لك بالتعديل على هذا المنتج');


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
