<?php

namespace Bromo\Tools\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Bromo\Tools\Entities\ShippingCourier;
use Bromo\Tools\DataTables\CourierDataTable;

class CourierController extends Controller
{
    public function __construct(ShippingCourier $model)
    {
        $this->model = $model;
        $this->module = 'tools';
        $this->title = 'Master Courier';
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data['module'] = $this->module;
        $data['title'] = $this->title;
        
        // return view("{$this->module}::browse", $data);
        return view('tools::browse-courier', $data);
    }

    /**
     * Get New Order data.
     * @param RefundDatatable $datatable
     * @return JsonResponse
     */
    public function courierData(CourierDataTable $datatable)
    {
        return $datatable->with([
            'model' => $this->model,
            'module' => $this->module
        ])->ajax();
    }

    public function getCourierInfo($id) 
    {
        $shipping_courier = $this->model->findOrFail($id);
        return response()->json([
            "data" => $shipping_courier,
        ]);
    }

    public function editCourierInfo(Request $request, $id) 
    {
        $new_provider_key = $request->newProviderKey;
        $new_name = $request->newName;

        try{
            $shipping_courier = $this->model->findOrFail($id);
            $shipping_courier->provider_key = $new_provider_key;
            $shipping_courier->name = $new_name;
            $shipping_courier->save();
            
            return response()->json([
                'status' => 'OK',
            ]);
        } catch (\Exception $exception) {
            report($exception);
            return response()->json([
                'status' => 'Failed',
            ]);
        }        
    }
}
