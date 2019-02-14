<?php

namespace Bromo\Product\DataTables;

use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
{
    public function ajax()
    {
//        $keyword = $this->request()->has('search.value');
        return datatables($this->query())
            ->addIndexColumn()
            ->editColumn('updated_at', function ($data) {
                return $data->updated_at_formatted;
            })
            ->editColumn('created_at', function ($data) {
                return $data->created_at_formatted;
            })
//            ->addColumn('action', function ($data) {
//                $action = [
//                    'edit_url' => route("{$this->module}.edit", $data->id),
//                    'delete_url' => route("{$this->module}.destroy", $data->id),
//                    'id' => $data->id
//                ];
//
//                return view('layouts.includes.actions', $action);
//            })
//            ->rawColumns(['action'])
            ->make(true);
    }

    public function query()
    {
        $query = $this->model
            ->orderByDesc('created_at');

        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
//            ->addAction(['width' => '150px', 'footer' => 'Action', 'exportable' => false, 'printable' => false])
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
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => '#', 'searchable' => false, 'width' => '1'],
            ['data' => 'id', 'name' => 'id', 'title' => 'ID'],
            ['data' => 'ext_id', 'name' => 'ext_id', 'title' => 'SKU'],
            ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
            ['data' => 'seller', 'name' => '', 'title' => 'Seller'],
            ['data' => 'price', 'name' => '', 'title' => 'Price'],
            ['data' => 'qty', 'name' => '', 'title' => 'QTY'],
            ['data' => 'type', 'name' => '', 'title' => 'Type'],
            ['data' => 'created_at', 'name' => '', 'created_at' => 'Submit Date'],
            ['data' => 'status', 'name' => '', 'title' => 'Status'],
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
