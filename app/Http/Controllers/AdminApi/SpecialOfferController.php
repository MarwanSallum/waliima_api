<?php

namespace App\Http\Controllers\AdminApi;

use App\Models\SpecialOffer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiGeneralTrait;
use App\Http\Resources\SpecialOfferResource;
use App\Repositories\SpecialOfferRepository;


class SpecialOfferController extends Controller
{
    use ApiGeneralTrait;

    protected $repository;

    public function __construct(SpecialOfferRepository $repository)
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
        $specialOffers = $this->repository->paginate();
        return SpecialOfferResource::collection($specialOffers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $specialOffer = $this->repository->store($request);
            return new SpecialOfferResource($specialOffer);
        }catch(\Exception $ex){
            return $this->returnError(404, $ex);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SpecialOffer  $specialOffer
     * @return \Illuminate\Http\Response
     */
    public function show(SpecialOffer $specialOffer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SpecialOffer  $specialOffer
     * @return \Illuminate\Http\Response
     */
    public function edit(SpecialOffer $specialOffer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SpecialOffer  $specialOffer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SpecialOffer $specialOffer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SpecialOffer  $specialOffer
     * @return \Illuminate\Http\Response
     */
    public function destroy(SpecialOffer $specialOffer)
    {
        //
    }
}
