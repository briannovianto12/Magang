<?php

namespace Bromo\Tools\DataTables;

use Bromo\Buyer\Models\BusinessMemberRole;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;
use DB;

class CourierBusinessMappingSellerDataTable extends DataTable
{
    public function ajax()
    {
        return datatables($this->query())
            ->addColumn('shop_id', function ($data) {
                return (string) $data->shop_id;
            })
            ->addColumn('shop_name', function ($data) {
                return $data->shop_name;
            })
            ->addColumn('shop_status', function ($data) {
                return $data->shop_status;
            })
            ->addColumn('contact_person', function ($data) {
                return $data->contact_person;
            })
            ->addColumn('action', function ($data) {

                $action = "<button class='btn btn-sm btn-dark btn-add-seller' data-id='".$data->id."'><i class='fa fa-plus mr-1'></i></button>";

                return $action;
            })
            ->rawColumns(['shop_id', 'shop_name', 'shop_status', 'contact_person', 'action'])
            ->make(true);
    }

    public function query()
    {
        $query = $this->model->select('business.id', 'shop.id as shop_id', 'shop.name as shop_name', 'shop_status.name as shop_status', 'business_address.contact_person as contact_person')
                            ->join('business_address', function ($join) {
                                $join->on('business_address.business_id', '=', 'business.id')
                                    ->whereNotNull('contact_person');
                            })
                            ->join('shop', 'shop.business_id', '=', 'business.id')
                            ->join('shop_status', 'shop.status', '=', 'shop_status.id')
                            ->orderBy('shop.name');

        $finalQuery = $query;

        if($this->keyword != null){
            $finalQuery = $query->where('shop.name', 'ilike', '%'.$this->keyword.'%');
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
