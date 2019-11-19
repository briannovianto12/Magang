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
        $data['provinces'] = Province::where('id', 'like', '200%')->orderBy('name', 'asc')->get();
        
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

    public function simulateShipping(Request $request){

        $service = new ShipperShippingApiService;
        $response = json_decode($service->simulateShipping($request->all()));
        $shipping_methods = $response->data->logistic;
        $data = null;
        
        if(!empty($shipping_methods)){
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
            
            if(!empty($regular_shippers)){
                $data['regular_shippers'] = $regular_shippers;
            }
            if(!empty($express_shippers)){
                $data['express_shippers'] = $express_shippers;
            }
            if(!empty($trucking_shippers)){
                $data['trucking_shippers'] = $trucking_shippers;
            }
        }

        return response()->json([
            "shippers" => $data,
        ]);
    }
}
