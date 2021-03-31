<?php

namespace App\Http\Controllers\UserApi;

use App\Helpers\ApiGeneralTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdvertisementResource;
use App\Models\Advertisement;

class AdvertisementController extends Controller
{
    use ApiGeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $advertisement = Advertisement::active()->paginate(5);
        return AdvertisementResource::collection($advertisement);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $advertisement = Advertisement::active()->find($id);
        if(!$advertisement){
            return $this->returnError(404, 'هذا الإعلان غير موجود بالسجل أو غير مفعل');
        }
        return new AdvertisementResource($advertisement);
    }
}
