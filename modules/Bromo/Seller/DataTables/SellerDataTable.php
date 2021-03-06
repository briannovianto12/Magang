<?php

namespace Bromo\Seller\DataTables;

use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;

class SellerDataTable extends DataTable
{
    public function ajax()
    {
        $keyword = $this->request()->has('search.value');
        return datatables($this->query())
            ->addIndexColumn()
            ->filterColumn('business_name', function ($query) use ($keyword) {
                if ($keyword ) {
                    $keyword = $this->request()->input('search.value');
                    $query->whereHas('business', function ($query) use ($keyword) {
                        $query->where('name', 'ilike', "%{$keyword}%");
                    });
                }
            })
            ->filterColumn('tax_type', function ($query) use ($keyword) {
                if ($keyword) {
                    $keyword = $this->request()->input('search.value');
                    $query->whereHas('taxType', function ($query) use ($keyword) {
                        $query->where('name', 'like', "%{$keyword}%");
                    });
                }
            })
            ->filterColumn('status', function ($query) use ($keyword) {
                if ($keyword) {
                    $keyword = $this->request()->input('search.value');
                    $query->whereHas('status', function ($query) use ($keyword) {
                        $query->where('name', 'like', "%{$keyword}%");
                    });
                }
            })
            ->editColumn('shop_status_name', function ($data) {
                if($data->status == 5) {
                    return '<span class="badge badge-danger">'.'Suspended'.'</span>';
                } elseif($data->is_temporary_closed == true && $data->status != 5) {
                    return '<span class="badge badge-warning">'.'Temporary Closed'.'</span>';
                } else {
                    return $data->shop_status_name;
                }
            })
            ->editColumn('updated_at', function ($data) {
                return $data->updated_at_formatted;
            })
            ->editColumn('created_at', function ($data) {
                return $data->created_at_formatted;
            })
            ->addColumn('action', function ($data) {
                $action = [
                    'id' => $data->id,
                    'show_url' => route("{$this->module}.show", $data->id),
    //                    'edit_url' => route("{$this->module}.edit", $data->id),
    //                    'delete_url' => route("{$this->module}.destroy", $data->id),
                ];

                return view('theme::layouts.includes.actions', $action);
            })
            ->rawColumns(['action', 'shop_status_name'])
            ->make(true);
    }

    public function query()
    {
        $query = $this->model->selectRaw(\DB::raw(
            'shop.id, ' .
            'business.name as business, ' .
            'shop.name, ' .
            'string_agg(product_category.name, \', \' ORDER BY product_category.name) as product_category, ' .
            'taxpayer_type.name as tax_type, ' .
            'shop_status.id as status, ' .
            'shop_status.name as shop_status_name, ' .
            'shop.created_at, ' .
            'shop.updated_at,' .
            'shop.is_temporary_closed, ' .
            'user_profile.msisdn as msisdn'
        ))
        ->join('business', 'business.id', '=', 'shop.business_id')
        ->join('product_category', 'product_category.id', '=', 'shop.product_category_id')
        ->join('shop_status', 'shop_status.id', '=', 'shop.status')
        ->join('taxpayer_type', 'taxpayer_type.id', '=', 'shop.taxpayer_type')
        ->join('business_member', 'business_member.business_id', '=', 'shop.business_id')
        ->join(\DB::raw('user_profile'), \DB::raw('user_profile.id'), '=', \DB::raw('business_member.user_id'))
        ->groupBy(\DB::raw('shop.id, business.name, shop.name, taxpayer_type.name, shop_status.id, shop_status.name, shop.created_at, shop.updated_at, user_profile.msisdn'));

        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters([
                'order' => [
                    [9, 'desc']
                ],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            ['data' => 'action', 'title' => 'Action','width' => '50px', 'footer' => 'Action', 'exportable' => false, 'printable' => false, 'orderable' => false],
            ['data' => 'DT_RowIndex', 'name' => 'id', 'title' => '#', 'searchable' => false, 'width' => '1', 'orderable' => false],
            ['data' => 'business', 'name' => 'business_name', 'title' => 'Business Name', 'orderable' => false],
            ['data' => 'name', 'name' => 'name', 'title' => 'Shop Name', 'orderable' => false],
            ['data' => 'product_category', 'name' => 'product_category', 'title' => 'Category'],
            ['data' => 'tax_type', 'name' => 'tax_type', 'title' => 'Tax Payer Type'],
            ['data' => 'shop_status_name', 'name' => 'status', 'title' => 'Status'],
            ['data' => 'msisdn', 'name' => 'user_profile.msisdn', 'title' => 'Phone Number'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created'],
            ['data' => 'updated_at', 'name' => 'updated_at', 'title' => 'Updated']
        ];
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
