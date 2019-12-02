<?php

namespace Bromo\Tools\DataTables;

use Bromo\Buyer\Models\BusinessMemberRole;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;
use DB;

class CourierBusinessMappingBuyerDataTable extends DataTable
{
    public function ajax()
    {
        return datatables($this->query())
            ->addColumn('buyer_name', function ($data) {
                return $data->buyer_name;
            })
            ->addColumn('owner_name', function ($data) {
                return $data->owner_name;
            })
            ->addColumn('owner_phone_number', function ($data) {
                return $data->owner_phone_number;
            })
            ->addColumn('action', function ($data) {

                $action = "<button class='btn btn-sm btn-dark btn-add-buyer' data-id='".$data->id."'><i class='fa fa-plus mr-1'></i></button>";

                return $action;
            })
            ->rawColumns(['buyer_name', 'owner_name', 'owner_phone_number', 'action'])
            ->make(true);
    }

    public function query()
    {
        $query = $this->model->select('business.id', 'business.name as buyer_name', 'user_profile.full_name as owner_name', 'user_profile.msisdn as owner_phone_number')
                            ->join('business_member', function ($join) {
                                $join->on('business_member.business_id', '=', 'business.id')
                                    ->where('business_member.role', '=', BusinessMemberRole::OWNER);
                            })
                            ->join('user_profile', 'business_member.user_id', '=', 'user_profile.id')
                            ->orderBy('business.name');
                            
        $finalQuery = $query;

        if($this->keyword != null){
            $finalQuery = $query->where('business.name', 'ilike', '%'.$this->keyword.'%')
                                ->orWhere('user_profile.full_name', 'ilike', '%'.$this->keyword.'%')
                                ->orWhere('user_profile.msisdn', 'ilike', '%'.$this->keyword.'%');
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
