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
                if ($keyword) {
                    $keyword = $this->request()->input('search.value');
                    $query->whereHas('business', function ($query) use ($keyword) {
                        $query->where('name', 'like', "%{$keyword}%");
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
            ->editColumn('business', function ($data) {
                return $data->business->name;
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
            ->rawColumns(['action'])
            ->make(true);
    }

    public function query()
    {
        $query = $this->model
            ->with(['status:id,name', 'taxType:id,name']);

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
            ->addAction(['width' => '150px', 'footer' => 'Action', 'exportable' => false, 'printable' => false])
            ->minifiedAjax()
            ->parameters([
                'order' => [
                    [6, 'desc']
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
            ['data' => 'DT_RowIndex', 'name' => 'id', 'title' => '#', 'searchable' => false, 'width' => '1', 'orderable' => false],
            ['data' => 'business', 'name' => 'business_name', 'title' => 'Business Name', 'orderable' => false],
            ['data' => 'name', 'name' => 'name', 'title' => 'Shop Name', 'orderable' => false],
            ['data' => 'product_category', 'name' => 'product_category', 'title' => 'Category'],
            ['data' => 'tax_type.name', 'name' => 'tax_type', 'title' => 'Tax Payer Type'],
            ['data' => 'status.name', 'name' => 'status', 'title' => 'Status'],
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
