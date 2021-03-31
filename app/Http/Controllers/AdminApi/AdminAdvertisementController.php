<?php

namespace App\Http\Controllers\AdminApi;

use App\Helpers\ApiGeneralTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdvertisementRequest;
use App\Http\Resources\AdvertisementResource;
use App\Models\Advertisement;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminAdvertisementController extends Controller
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
        $advertisement = Advertisement::paginate(5);
        return AdvertisementResource::collection($advertisement);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdvertisementRequest $request)
    {
        try{
            DB::beginTransaction();
            $advertisementImage = $this->uploadImage('advertisements', $request->image);
            $addNewAdvertisement = Advertisement::create([
                'title' => $request->title,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'amount' => $request->amount,
                'advertis_from' => $request->advertis_from,
                'advertis_to' => $request->advertis_to,
                'image' => $advertisementImage,
            ]);
            $addNewAdvertisement->save();
            DB::commit();
            return $this->returnSuccessMessage('تم إضافة الإعلان بنجاح');
        }catch (\Exception $ex) {
            DB::rollback();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $advertisement = Advertisement::find($id);
        if(!$advertisement){
            return $this->returnError(404, 'هذا الإعلان غير موجود بالسجل');
        }
        return new AdvertisementResource($advertisement);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            DB::beginTransaction();
            $advertisement = Advertisement::where('id', $id)->first();
            $updateAdvertisementImage = '';
            if(!$advertisement){
                return $this->returnError(404, 'هذا الإعلان غير موجود بالسجل');
            }
            if($request->has('image')){
                $storgedImage = Str::after($advertisement->image, 'advertisements/');
                $oldImage = public_path('images\\advertisements\\'.$storgedImage);
                unlink($oldImage);
                $updateAdvertisementImage = $this->uploadImage('advertisements', $request->image);
            }

            $advertisement->update([
                'title' => $request->has('title') ? $request->title : $advertisement->title,
                'email' => $request->has('email') ? $request->email : $advertisement->email,
                'mobile' => $request->has('mobile') ? $request->mobile : $advertisement->mobile,
                'amount' => $request->has('amount') ? $request->amount : $advertisement->amount,
                'advertis_from' => $request->has('advertis_from') ? $request->advertis_from : $advertisement->advertis_from,
                'advertis_to' => $request->has('advertis_to') ? $request->advertis_to : $advertisement->advertis_to,
                'image' => $updateAdvertisementImage,
            ]);

            $advertisement->save();
            Db::commit();
            return $this->returnSuccessMessage('تم تحديث الإعلان بنجاح');
        }catch (\Exception $ex) {
            DB::rollback();
            return $this->returnError(404, 'لم تتم العملية - يوجد خطأ ما');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $advertisement = Advertisement::find($id);
            if(!$advertisement){
                return $this->returnError(404, 'هذا الإعلان غير موجود');  
            }
            $advertisement->delete();
            return $this->returnSuccessMessage('تم حذف الإعلان بنجاح');

        } catch (\Exception $ex) {
            return $this->returnError(404, 'لم تتم العملية - يوجد خطأ ما');
        }
    }
}
