<?php

namespace Bromo\Transaction\DataTables;

use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder;

abstract class OrderDatatable extends DataTable
{
    public function ajax()
    {
        $keyword=$this->request()->input('search.value');
        return datatables($this->query())
            ->filterColumn('is_cod', function ($query) use ($keyword) {
                if ($keyword == 'COD') {
                    $query->whereHas('is_cod', function ($query) use ($keyword) {
                        $query->where('is_cod', '=', true);
                    });
                }
            })
            ->addColumn('order_no', function ($data) {
                return '<a href="' . route('order.show', $data->id) .'">'.$data->order_no.'</a>';
            })
            ->editColumn('payment_amount_formatted', function ($data) {
                return '<div style="text-align:right">'.number_format($data->payment_amount, 0, 0, '.').'</div>';
            })
            ->editColumn('created_at', function ($data) {
                return $data->created_at_formatted;
            })
            ->editColumn('updated_at', function ($data) {
                return $data->updated_at_formatted;
            })
            ->editColumn('payment_details_formatted', function ($data) {
                $gross = (int)$data->payment_details['total_gross'];
                return '<div style="text-align:right">'. number_format($gross, 0, 0, '.') .'</div>';
            })
            ->editColumn('is_picked_up', function ($data) {
                if($data->is_picked_up == true){
                    return '<div class="fas fa-check-circle" style="color: green"></div>';
                }else if($data->is_picked_up == false){
                    return '<div class="fas fa-times-circle" style="color: red"></div>';
                }
            })
            ->editColumn('status_name', function ($data) {
                if($data->orderStatus->id == 1){
                    return '<span class="badge badge-placed">'.$data->orderStatus->name.'</span>';
                }else if($data->orderStatus->id == 2){
                    return '<span class="badge badge-accepted">'.$data->orderStatus->name.'</span>';
                }else if($data->orderStatus->id == 4){
                    return '<span class="badge badge-payment-pending">'.$data->orderStatus->name.'</span>';
                }else if($data->orderStatus->id == 5){
                    return '<span class="badge badge-payment-ok">'.$data->orderStatus->name.'</span>';
                }else if($data->orderStatus->id == 6){
                    return '<span class="badge badge-packaging">'.$data->orderStatus->name.'</span>';
                }else if($data->orderStatus->id == 7){
                    return '<span class="badge badge-packaged">'.$data->orderStatus->name.'</span>';
                }else if($data->orderStatus->id == 8){
                    return '<span class="badge badge-shipped">'.$data->orderStatus->name.'</span>';
                }else if($data->orderStatus->id == 9){
                    return '<span class="badge badge-delivered">'.$data->orderStatus->name.'</span>';
                }else if($data->orderStatus->id == 10){
                    return '<span class="badge badge-success">'.$data->orderStatus->name.'</span>';
                }else if($data->orderStatus->id == 20){
                    return '<span class="badge badge-complained">'.$data->orderStatus->name.'</span>';
                }else if($data->orderStatus->id == 21){
                    return '<span class="badge badge-complained-resolved">'.$data->orderStatus->name.'</span>';
                }else if($data->orderStatus->id == 30){
                    return '<span class="badge badge-canceled">'.$data->orderStatus->name.'</span>';
                }else if($data->orderStatus->id == 31){
                    return '<span class="badge badge-rejected">'.$data->orderStatus->name.'</span>';
                }
            })
            ->editColumn('airwaybill', function ($data) {
                if($data->airwaybill == '' || $data->airwaybill == null){
                    return '<span>-</span>';
                }else{
                    return '<span>'.$data->airwaybill.'</span><button name="awb-cpy-btn" class="btn btn-sm" style="background-color: white"><i class="fa fa-clone"></i></button></span>';
                }
            })
            ->editColumn('special_id', function ($data) {
                if($data->special_id == '' || $data->special_id == null){
                    return '<span>-</span>';
                }else{
                    return '<span>'.$data->special_id.'</span><button name="pickup-cpy-btn" class="btn btn-sm" style="background-color: white"><i class="fa fa-clone"></i></button></span>';
                }
            })
            ->addColumn('seller_name', function ($data) {
                return $data->seller_name;
            })
            ->addColumn('buyer_name', function ($data) {
                return $data->buyer_name;
            })
            ->addColumn('status_name', function ($data) {
                return $data->orderStatus->name ?? '';
            })
            ->addColumn('action', function ($data) {
                $action = [
                    'internal_notes' => $data->id
                ];
                return view('theme::layouts.includes.actions', $action);
            })
            ->filterColumn('order_no', function($query, $keyword) {
                $sql = "CONCAT(order_trx.order_no)  like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('buyer_name', function($query, $keyword) {
                $sql = "CONCAT(order_trx.buyer_snapshot->>'full_name')  ilike ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('seller_name', function($query, $keyword) {
                $sql = "CONCAT(order_trx.shop_snapshot->>'name')  ilike ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->rawColumns(['order_no', 'payment_amount_formatted', 'payment_details_formatted', 'action', 'is_picked_up', 'status_name', 'airwaybill', 'special_id'])
            ->make(true);
    }

    public function query()
    {
        $query = $this->model
            ->select($this->getColumns())
            ->with('orderStatus:id,name');

        return $this->applyScopes($query);
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return $this->module . "_" . time();
    }

    protected function getColumns()
    {
        return [
            'id',
            'order_no',
            'status',
            'payment_amount',
            'buyer_snapshot',
            'shop_snapshot',
            'payment_details',
            'notes',
            'is_picked_up',
            'is_cod',
            'created_at',
            'updated_at',
        ];
    }
}
