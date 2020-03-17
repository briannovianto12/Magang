<?php

namespace Bromo\ShippingMapping\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Bromo\ShippingMapping\Entities\Logistic;
use Bromo\ShippingMapping\Entities\LocationCity;
use Bromo\ShippingMapping\Entities\LocationBuilding;
use Bromo\ShippingMapping\Entities\ShippingCourierCity;
use Bromo\ShippingMapping\Entities\ShippingCourierBuilding;
use DB;
use Exception;

class ShippingMappingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function shippingmappingCity()
    {
        $data = DB::table('shipping_courier_city')
            ->join('location_city','shipping_courier_city.city_id','=','location_city.id')
            ->join('shipping_courier','shipping_courier_city.courier_id','=','shipping_courier.id')
            ->select(
                "location_city.name as city_name",
                "shipping_courier.name as courier_name",
                "shipping_courier_city.courier_id",
                "shipping_courier_city.city_id",
                "shipping_courier_city.created_at as created_at",
                "shipping_courier_city.updated_at as updated_at")
            ->get();

        return view('shippingmapping::shipping-courier-city-list', ['data' => $data]);
    }

    public function shippingmappingCityCreate()
    {
        return view('shippingmapping::shipping-courier-city-form');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function shippingmappingBuilding()
    {
        $data = DB::table('shipping_courier_building')
            ->join('building','shipping_courier_building.building_id','=','building.id')
            ->join('shipping_courier','shipping_courier_building.courier_id','=','shipping_courier.id')
            ->select(
                "building.long_name as building_name",
                "shipping_courier.name as courier_name",
                "shipping_courier_building.courier_id",
                "shipping_courier_building.building_id",
                "shipping_courier_building.created_at as created_at",
                "shipping_courier_building.updated_at as updated_at")
            ->get();

        return view('shippingmapping::shipping-courier-building-list', ['data' => $data]);
    }

    public function shippingmappingBuildingCreate()
    {
        return view('shippingmapping::shipping-courier-building-form');

    }

    public function searchLogisticCity(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $posts = Logistic::search($term)->limit(10)->get();

        $formatted_posts = [];

        foreach ($posts as $post) {
            $formatted_posts[] = ['id' => $post->id, 'text' => $post->name   . ' (' . $post->provider_key . ') ' ];
        }

        return \Response::json($formatted_posts);
    }

    public function searchLogisticBuilding(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $posts = Logistic::search($term)->limit(10)->get();

        $formatted_posts = [];

        foreach ($posts as $post) {
            $formatted_posts[] = ['id' => $post->id, 'text' => $post->name   . ' (' . $post->provider_key . ') ' ];
        }

        return \Response::json($formatted_posts);
    }

    public function searchCity(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $posts = LocationCity::search($term)->limit(10)->get();

        $formatted_posts = [];

        foreach ($posts as $post) {
            $formatted_posts[] = ['id' => $post->id, 'text' => $post->name ];
        }

        return \Response::json($formatted_posts);
    }

    public function searchBuilding(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $posts = LocationBuilding::search($term)->limit(10)->get();

        $formatted_posts = [];

        foreach ($posts as $post) {
            $formatted_posts[] = ['id' => $post->id, 'text' => $post->long_name . ', ' . $post->short_name ];
        }

        return \Response::json($formatted_posts);
    }

    public function postShippingmappingCity(Request $request){
        try{
            $shipping_courier_city = New ShippingCourierCity;
            $shipping_courier_city->courier_id = $request->input('logistic_provider_city');
            $shipping_courier_city->city_id = $request->input('city');
            
            $shipping_courier_city->save();

            return redirect('/shippingmapping/city')->with(['success' => 'Success']);
        }catch(Exception $exception){
            report($exception);
            \Log::error($exception->getMessage());

            return redirect('/shippingmapping/city')->with(['error' => 'Failed']);
        }
    }

    public function postShippingmappingBuilding(Request $request){
        try{
            $shipping_courier_building = New ShippingCourierBuilding;
            $shipping_courier_building->courier_id = $request->input('logistic_provider_building');
            $shipping_courier_building->building_id = $request->input('building');
            
            $shipping_courier_building->save();

            return redirect('/shippingmapping/building')->with(['success' => 'Success']);
        }catch(Exception $exception) {
            report($exception);  
            \Log::error($exception->getMessage());          
            return redirect('/shippingmapping/building')->with(['error' => 'Failed']);
        }
    }
}
