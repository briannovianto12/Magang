<?php

namespace Bromo\ProductBrand\DataTables;

use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;

class ProductBrandDataTable extends DataTable
{
    public function ajax()
    {
        return datatables($this->query())
            ->addIndexColumn()
            ->editColumn('updated_at', function ($data) {
                return $data->updated_at_formatted;
            })
            ->addColumn('action', function ($data) {
                $action = [
                    'edit_url' => route("{$this->module}.edit", $data->id),
                    'delete_url' => route("{$this->module}.destroy", $data->id),
                    'id' => $data->id
                ];
                if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                    return view('theme::layouts.includes.actions', $action);
                
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function query()
    {
        $query = $this->model
            ->orderBy('updated_at');

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
                'order' => [],
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
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => '#', 'orderable' => false, 'searchable' => false, 'width' => '1'],
            ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
            ['data' => 'sku_part', 'name' => 'sku_part', 'title' => 'SKU Part'],
            ['data' => 'version', 'name' => 'version', 'title' => 'Version'],
            ['data' => 'updated_at', 'name' => 'updated_at', 'title' => 'Updated At']
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
