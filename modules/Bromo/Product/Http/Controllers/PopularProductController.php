<?php

namespace Bromo\Product\Http\Controllers;

use Bromo\Product\DataTables\PopularProductDatatable;
use Bromo\Product\DataTables\RegularProductDatatable;
use Bromo\Product\Models\PopularProduct;
use Bromo\Product\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use DB;

class PopularProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('product::popular-product');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('product::create');
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
        return view('product::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('product::edit');
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
     * @param int $product_id
     * @return Response
     */
    public function destroy($product_id)
    {
        PopularProduct::where('product_id', '=', $product_id)->delete();
    }

    public function getPopularProducts(PopularProduct $model, PopularProductDatatable $datatable)
    {
        return $datatable->with([
            'model' => $model
        ])->ajax();
    }

    public function getRegularProduct($product_name, Product $model, RegularProductDatatable $datatable)
    {
        return $datatable->with([
            'model' => $model,
            'keyword' => $product_name
        ])->ajax();
    }

    public function updatePopularProductIndex(){
        DB::statement("REFRESH MATERIALIZED VIEW vw_popular_product");
    }

    public function addToPopularProduct(Request $request)
    {
        $product_id = $request->all()['product_id'];
        $new_popular_product = new PopularProduct();
        $new_popular_product->product_id = $product_id;
        $new_popular_product->save();
    }
}
