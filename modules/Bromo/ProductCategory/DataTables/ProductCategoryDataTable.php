<?php

namespace Bromo\ProductCategory\DataTables;

use Yajra\DataTables\Services\DataTable;

class ProductCategoryDataTable extends DataTable
{
    public function ajax()
    {
        return datatables($this->query())
            ->addIndexColumn()
            ->editColumn('created_at', function ($data) {
                return $data->created_at_formatted;
            })
            ->editColumn('updated_at', function ($data) {
                return $data->updated_at_formatted;
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
            ->orderBy('level');

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
            ['data' => 'ext_id', 'name' => 'ext_id', 'title' => 'Code'],
            ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
            ['data' => 'level', 'name' => 'level', 'title' => 'Level'],
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
