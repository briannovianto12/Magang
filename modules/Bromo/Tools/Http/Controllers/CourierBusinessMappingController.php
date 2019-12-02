<?php

namespace Bromo\Tools\Http\Controllers;

use Bromo\Buyer\Models\Business;
use Bromo\Seller\Models\Shop;
use Bromo\Tools\DataTables\CourierBusinessMappingDataTable;
use Bromo\Tools\DataTables\CourierBusinessMappingBuyerDataTable;
use Bromo\Tools\DataTables\CourierBusinessMappingSellerDataTable;
use Bromo\Tools\Models\CourierBusinessMapping;
use Bromo\Transaction\Models\ShippingCourier;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class CourierBusinessMappingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('tools::courier-business-mapping');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('tools::courier-business-mapping-form');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $seller_id = $request->all()['seller_id'];
        $buyer_id = $request->all()['buyer_id'];
        $courier_id = $request->all()['courier_id'];

        if($this->checkUnique($seller_id, $buyer_id, $courier_id)){
            $mapping = new CourierBusinessMapping();
            $mapping->seller_business_id = $seller_id;
            $mapping->buyer_business_id = $buyer_id;
            $mapping->courier_id = $courier_id;
            $mapping->save();
        }else{
            return response()->json(['error' => 'Data already exists!'], 404);
        }

        
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('tools::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('tools::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function getTable(CourierBusinessMappingDataTable $datatable){
        return $datatable->ajax();
    }

    public function getFilteredTable($courier_id, CourierBusinessMappingDataTable $datatable){
        return $datatable->with([
            'courier_id' => $courier_id,
        ])->ajax();
    }

    public function getExpeditionCourierList(){
        $expedition_couriers = ShippingCourier::where('provider_id', '=', ShippingCourier::SHIPPING_PROVIDER_KURIR_EKSPEDISI)
                                                ->orderBy('name')->get();
        
        return response()->json([
            'expedition_couriers' => $expedition_couriers
        ]);
    }

    public function searchSeller($keyword, Business $model, CourierBusinessMappingSellerDataTable $datatable){
        return $datatable->with([
            'model' => $model,
            'keyword' => $keyword
        ])->ajax();
    }

    public function searchBuyer($keyword, Business $model, CourierBusinessMappingBuyerDataTable $datatable){
        return $datatable->with([
            'model' => $model,
            'keyword' => $keyword
        ])->ajax();
    }

    private function checkUnique($seller_id, $buyer_id, $courier_id){

        $obj = CourierBusinessMapping::where('seller_business_id', $seller_id)
                                ->where('buyer_business_id', $buyer_id)
                                ->where('courier_id', $courier_id)
                                ->first();
        if($obj == null){
            return true;
        }

        return false;
    }
}
