<?php

namespace Bromo\AttributeKey\DataTables;

use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;

class AttributeKeyDataTable extends DataTable
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
            ->addColumn('action', function ($data) {
                $action = [
                    'edit_url' => route("{$this->module}.edit", $data->id),
                    'delete_url' => route("{$this->module}.destroy", $data->id),
                    'id' => $data->id
                ];
                if(auth()->user()->can('edit_attribute_key'))
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
            ['data' => 'key', 'name' => 'key', 'title' => 'Key'],
            ['data' => 'value_type', 'name' => 'value_type', 'title' => 'Value Type'],
            ['data' => 'updated_at', 'name' => 'updated_at', 'title' => 'Updated'],
            ['data' => 'version', 'name' => 'version', 'title' => 'Version']
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
