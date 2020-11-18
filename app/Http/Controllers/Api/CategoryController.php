<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\ApiGeneralTrait;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    use ApiGeneralTrait;

    public function __construct()
    {
     $this->middleware('auth:api')->except(['index']);
    }
 /**
  * Undocumented function
  *
  * @return void
  */ 
    public function index()
    {
                $categories = Category::paginate(5);
                return CategoryResource::collection($categories);
    }


    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function store(CategoryRequest $request)
    {
        if(auth() ->user()-> hasRole('super_admin')){

            $imagePath = $this ->uploadImage('categories', $request ->image);

            try{
                $category = Category::find($request -> name);
                if(!$category){

                    $new_category = Category::create([
                        'user_id' => $this -> getAuthenticatedUser(),
                        'name' => $request -> name,
                        'image' => $imagePath,
                    ]);
        
                    $new_category -> save();
                
                    return new CategoryResource($new_category);
                }
                return $this -> returnError(226,'هذا القسم موجود بالفعل' );
            }catch(\ReflectionException $ex){
                return $this -> returnError(404,'يجد خطأ ما برجاء المحاولة لاحقا');

            }
        }
        return $this -> returnError(401, 'أنت غير مخول لعرض هذا المحتوى');
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
        
            if(auth() ->user()-> hasRole('super_admin')){
                $category = Category::find($id);
                if(! $category){
                    return $this -> returnError(404,'هذا القسم غير موجود');
                }

                $storgedImage = Str::after($category->image,'images/');
                $image = public_path('images/'. $storgedImage);
                unlink($image); // delete image from public folder

                $category ->delete();

                return response()->json([
                    'message' => 'تم حذف القسم بنجاح',
                ]);
            }
            return $this -> returnError(401,'أنت غير مخول لعرض هذا المحتوى');


        }catch(\ReflectionException $ex){
            return $this -> returnError(404,'غير موجود');
        }

        
     
    }
}
