<?php

namespace Bromo\Report\DataTables;

use Bromo\Report\Entities\ProductPublished;
use Yajra\DataTables\Services\DataTable;

class ReportProductPublishedDatatable extends DataTable
{
    public function ajax()
    {
        return datatables($this->query())
            ->addIndexColumn()
            ->make(true);
    }

    public function query()
    {
        $query = $this->model->select([
            'vw_store_with_published_product_less_than_ten.shop_name',
            'vw_store_with_published_product_less_than_ten.full_name',
            'vw_store_with_published_product_less_than_ten.msisdn',
            'vw_store_with_published_product_less_than_ten.address_line',
            'vw_store_with_published_product_less_than_ten.count',
        ]);

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