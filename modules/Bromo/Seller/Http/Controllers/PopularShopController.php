<?php

namespace Bromo\Seller\Http\Controllers;

use Bromo\Seller\DataTables\PopularShopDataTable;
use Bromo\Seller\DataTables\RegularShopDataTable;
use Bromo\Seller\Models\PopularShop;
use Bromo\Seller\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use DB;

class PopularShopController extends Controller
{

    public function __construct(PopularShop $model)
    {
        $this->model = $model;
        //$this->module = 'transaction';
        $this->title = 'Popular Shop';
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('store::popular-shop');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('store::create');
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
        return view('store::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('store::edit');
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

    public function getRegularShop($shop_name, Shop $model, RegularShopDataTable $datatable)
    {
        return $datatable->with([
            'model' => $model,
            'keyword' => $shop_name
        ])->ajax();
    }
    
    public function getPopularShop(PopularShop $model, PopularShopDataTable $datatable)
    {
        return $datatable->with([
            'model' => $model
        ])->ajax();
    }

    public function addToPopularShop(Request $request)
    {
        $shop_id = $request->all()['shop_id'];
        $shop = Shop::where('id', '=', $shop_id)->first();
        $new_popular_shop = new PopularShop();
        $new_popular_shop->shop_id = $shop_id;
        $response = $new_popular_shop->save();
    }

    public function removeFromPopularShop($shop_id)
    {
        $removed_shop = PopularShop::where('shop_id', '=', $shop_id)->delete();
    }

    public function updatePopularShopIndex(){
        DB::statement("REFRESH MATERIALIZED VIEW vw_popular_shop_category_mapping");
    }

}
