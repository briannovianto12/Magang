<?php

namespace Bromo\Tools\DataTables;

use Bromo\Refund\Entities\ShippingCourier;
use Exception;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;

class CourierDataTable extends DataTable
{
    /**
     * Configure ajax response
     *
     * @return JsonResponse|mixed
     * @throws Exception
     */
    public function ajax()
    {
        return datatables($this->query())
            ->editColumn('enabled', function ($data) {
                $action = [
                    'enable_disable_courier' => $data->id,
                    'enable_disable_courier_status' => $data->enabled
                ];

                return view('theme::layouts.includes.actions', $action);
            })
            ->editColumn('updated_at', function ($data) {
                return $data->updated_at;
            })
            ->addColumn('action', function ($data) {
                    $action = [
                        'change_ekspedisi' => $data->id
                    ];
                
                    return view('theme::layouts.includes.actions', $action);         
                })
            ->rawColumns(['enabled','action'])
            ->make(true);

    }

    /**
     * Query of process datatable.
     *
     * @return mixed
     */
    public function query()
    {
        $query = $this->model
            ->select('id','provider_key', 'name', 'enabled', 'updated_at');
        
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
}