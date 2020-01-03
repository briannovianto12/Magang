<?php

namespace Bromo\Tools\DataTables;

use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;
use Bromo\Transaction\Models\ShippingCourier;
use DB;

class CourierBusinessMappingDataTable extends DataTable
{
    public function ajax()
    {
        $keyword = $this->request()->has('search.value');
        return datatables($this->query())
            ->filterColumn('seller_name', function($query, $keyword) {
                if ($keyword) {
                    $keyword = $this->request()->input('search.value');
                    $query->where(DB::raw('B.name'), 'ILIKE', "%{$keyword}%");
                }
            })
            ->filterColumn('buyer_name', function($query, $keyword) {
                if ($keyword) {
                    $keyword = $this->request()->input('search.value');
                    $query->where(DB::raw('C.name'), 'ILIKE', "%{$keyword}%");
                }
            })
            ->filterColumn('buyer_phone_number', function($query, $keyword) {
                if ($keyword) {
                    $keyword = $this->request()->input('search.value');
                    $query->where(DB::raw('F.msisdn'), 'ILIKE', "%{$keyword}%");
                }
            })
            ->make(true);
    }

    public function query()
    {
        $query = DB::table(DB::raw('courier_business_mapping A'))
        ->select(DB::raw('A.id, B.name as seller_name, C.name as buyer_name, F.msisdn as buyer_phone_number, D.name as courier_name, A.remark'))
        ->join(DB::raw('business B'), DB::raw('B.id'), '=', DB::raw('A.seller_business_id'))
        ->join(DB::raw('business C'), DB::raw('C.id'), '=', DB::raw('A.buyer_business_id'))
        ->join(DB::raw('shipping_courier D'), function ($join) {
            $join->on(DB::raw('D.id'), '=', DB::raw('A.courier_id'))
                 ->where(DB::raw('D.provider_id'), '=', ShippingCourier::SHIPPING_PROVIDER_KURIR_EKSPEDISI);
        })
        ->join(DB::raw('business_member E'), function ($join) {
            $join->on(DB::raw('C.id'), '=', DB::raw('E.business_id'))
                 ->where(DB::raw('E.role'), '=', 1);
        })
        ->join(DB::raw('user_profile F'), DB::raw('E.user_id'), '=', DB::raw('F.id'));

        $finalQuery = $query;

        if($this->courier_id != null){
            $finalQuery = $query->where(DB::raw('D.id'), '=', $this->courier_id);
        }

        return $this->applyScopes($finalQuery);
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
}
