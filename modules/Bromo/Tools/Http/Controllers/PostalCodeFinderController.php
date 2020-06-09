<?php

namespace Bromo\Tools\Http\Controllers;

use Bromo\Tools\Models\City;
use Bromo\Tools\Models\District;
use Bromo\Tools\Models\Province;
use Bromo\Tools\Models\Subdistrict;
use Bromo\Tools\Models\SubdistrictShipping;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Bromo\Tools\DataTables\PostalCodeFinderDataTable;
use Illuminate\Http\JsonResponse;
use Exception;
use DB;

class PostalCodeFinderController extends Controller
{
    const PAGE_SIZE = 30;

    public function __construct(Province $model)
    {
        $this->model = $model;
        $this->module = 'tools';
        $this->title = 'Postal Code Finder';
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $provinces = Province::where('id', 'like', '200%')->orderBy('name', 'asc')->get();

        return view('tools::postal-code-finder', [
            "provinces" => $provinces,
            "model" => $this->model,
            "module" => $this->module,
            "title" => $this->title
        ]);
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

        $cities = City::where('province_id', $province_id)->where('id', 'like', '200%')->orderBy('name', 'asc')->get();
        
        return response()->json([
            "cities" => $cities,
        ]);
    }

    public function getDistricts($city_id){

        $districts = District::where('city_id', $city_id)->where('id', 'like', '200%')->orderBy('name', 'asc')->get();

        return response()->json([
            "districts" => $districts,
        ]);
    }

    public function getSubdistricts($district_id){

        $subdistricts = Subdistrict::where('district_id', $district_id)->where('id', 'like', '200%')->orderBy('name', 'asc')->get();
        
        return response()->json([
            "subdistricts" => $subdistricts,
        ]);
    }

    public function getPostalCode($subdistrict_id){
        
        $postal_code = Subdistrict::whereRaw("id = '$subdistrict_id'")->first()->postal_code;
        
        return response()->json([
            "postal_code" => $postal_code,
        ]);
    }


    /**
     * Get Postal Code data.
     * @param PostalCodeFinderDataTable $datatable
     * @return JsonResponse
     */
    public function getByPostalCode(PostalCodeFinderDataTable $datatable)
    {
        return $datatable->with([
            'model' => $this->model,
            'module' => $this->module
        ])->ajax();
    }

    public function editPostalCode(Request $request){
        $district_id = $request->get('district_id');
        $postal_code = $request->get('postal_code');
        $subdistrict_id = $request->get('subdistrict_id',null);

        DB::beginTransaction();
        DB::connection('pgsql_shipping')->beginTransaction();
        try{
            if($subdistrict_id){
                $query_main = Subdistrict::find($subdistrict_id);
                $query_main->postal_code = $postal_code;
                $query_main->save();
                $query_shipping = SubdistrictShipping::find($subdistrict_id);
                $query_shipping->postal_code = $postal_code;
                $query_shipping->save();
            } else {
                $query_main = Subdistrict::where('district_id','=',$district_id)
                    ->update(['postal_code'=>$postal_code]);
                $query_shipping = SubdistrictShipping::where('district_id','=',$district_id)
                    ->update(['postal_code'=>$postal_code]);
            }
            DB::commit();
            DB::connection('pgsql_shipping')->commit();
        } catch (Exception $exception){
            DB::rollback();
            DB::connection('pgsql_shipping')->rollback();
            return response()->json([
                "status" => "Fail",
            ]);            
        }
        
        return response()->json([
            "status" => "Success",
        ]);
    }
}
