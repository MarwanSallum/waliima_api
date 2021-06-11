<?php
namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\ApiGeneralTrait;
use App\Models\SpecialOffer;
use Illuminate\Support\Facades\DB;

class SpecialOfferRepository extends AppRepository
{
    use ApiGeneralTrait;

    protected $model;

    public function __construct(SpecialOffer $specialOffer)
    {
        $this->model = $specialOffer;
    }

    protected function setDataPayload(Request $request)
    {
        $fileName = $this->uploadImage('special_offers', $request->file('image'));
        return [
            'title' => $request->input('title'),
            'price' => $request->input('price'),
            'image' => $fileName,
            'offer_begin' => $request->input('offer_begin'),
            'offer_end' => $request->input('offer_end'),
        ];
    } 

    public function updateProduct(Request $request, $id)
    {
            $specialOffer = SpecialOffer::where('id', $id)->first();
            $addNewFile = '';
            if (!$specialOffer) {
                return $this->returnError(404, 'هذا المنتج غير موجود بالسجل');
            }
            if ($request->has('image')) {
                $storgedImage = Str::after($specialOffer->image, 'special_offers/');
                $oldImage = public_path("images\\special_offers\\" . $storgedImage);
                unlink($oldImage);
                $addNewFile = $this->uploadImage('special_offers', $request->image);
            }

            $specialOffer->update([
                'title' => $request->has('title') ?  $request->title : $specialOffer->title,
                'description' => $request->has('description') ? $request->description : $specialOffer->description,
                'price' => $request->has('price') ?  $request->price : $specialOffer->price,
                'weight' => $request->has('weight') ? $request->weight : $specialOffer->weight,
                'inStock' => $request->has('inStock') ? $request->inStock : $specialOffer->inStock,
                'image' => $request->has('image') ? $addNewFile : $specialOffer->image,
            ]);
            
            $specialOffer->save();
    }
}