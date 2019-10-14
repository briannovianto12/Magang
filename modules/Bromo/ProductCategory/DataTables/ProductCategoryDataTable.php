<?php

namespace Bromo\ProductCategory\DataTables;

use Yajra\DataTables\Html\Builder;
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
            ->addColumn('action', function ($data) {
                $action = [
                    'edit_url' => route("{$this->module}.edit", $data->id),
                    'attribute_url' => view('components.buttons._button-url', [
                        'url' => route("{$this->module}.attributes", $data->id),
                        'title' => 'Attribute',
                        'iconClass' => 'la la-tags'
                    ]),
                    'brand_url' => view('components.buttons._button-url', [
                        'url' => route("{$this->module}.brands", $data->id),
                        'title' => 'Brand',
                        'iconClass' => 'la la-diamond'
                    ]),
//                    'delete_url' => route("{$this->module}.destroy", $data->id),
                    'id' => $data->id
                ];
                if(auth()->user()->can('edit_product_category'))
                    return view('theme::layouts.includes.actions', $action);
            })
            ->rawColumns(['action'])
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
            ['data' => 'sku', 'name' => 'sku', 'title' => 'SKU'],
            ['data' => 'sku_part', 'name' => 'sku_part', 'title' => 'SKU part'],
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
