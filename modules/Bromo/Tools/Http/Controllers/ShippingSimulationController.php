<?php

namespace Bromo\Tools\Http\Controllers;

use Bromo\Tools\Models\City;
use Bromo\Tools\Models\District;
use Bromo\Tools\Models\Province;
use Bromo\Tools\Models\Subdistrict;
use Bromo\Tools\Services\ShipperShippingApiService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class ShippingSimulationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data['provinces'] = Province::where('id', 'like', '200%')->get();
        
        return view('tools::shipping-simulation', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('tools::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
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

    public function getCities($province_id){

        $cities = City::where('province_id', $province_id)->where('id', 'like', '200%')->get();

        return response()->json([
            "cities" => $cities,
        ]);
    }

    public function getDistricts($city_id){

        $districts = District::where('city_id', $city_id)->where('id', 'like', '200%')->get();

        return response()->json([
            "districts" => $districts,
        ]);
    }

    public function getSubdistricts($district_id){

        $subdistricts = Subdistrict::where('district_id', $district_id)->where('id', 'like', '200%')->get();

        return response()->json([
            "subdistricts" => $subdistricts,
        ]);
    }

    public function getPostalCode($subdistrict_id){

        $postal_code = Subdistrict::whereRaw("id, $subdistrict_id")->first()->postal_code;

        return response()->json([
            "postal_code" => $postal_code,
        ]);
    }

    public function simulateShipping(Request $request){

        $service = new ShipperShippingApiService;
        $response = json_decode($service->simulateShipping($request->all()));
        $shipping_methods = $response->data->logistic;
        foreach($shipping_methods as $shipping_method){
            if($shipping_method->name == "regular"){
                $regular_shippers[] = $shipping_method;
            }
            else if($shipping_method->name == "express"){
                $express_shippers[] = $shipping_method;
            }
            else if($shipping_method->name == "trucking"){
                $trucking_shippers[] = $shipping_method;
            }
        }
        
        $data['regular_shippers'] = $regular_shippers;
        $data['express_shippers'] = $express_shippers;
        $data['trucking_shippers'] = $trucking_shippers;

        return response()->json([
            "shippers" => $data,
        ]);;
    }
}
