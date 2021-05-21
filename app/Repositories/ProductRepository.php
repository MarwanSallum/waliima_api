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

    public function updateProduct(Request $request, $id)
    {
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
    }
}