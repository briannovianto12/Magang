<?php

namespace Bromo\Tools\DataTables;

use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder;

class PostalCodeFinderDataTable extends DataTable
{
    public function ajax()
    {
        return datatables($this->query())
            ->editColumn('province_name', function ($data) {
                return $data->province_name;
            })
            ->editColumn('city_name', function ($data) {
                return $data->city_name;
            })
            ->editColumn('district_name', function ($data) {
                return $data->district_name;
            })
            ->editColumn('subdistrict_name', function ($data) {
                return $data->subdistrict_name;
            })
            ->editColumn('postal_code', function ($data) {
                return $data->postal_code;
            })
            ->rawColumns(['location_province.name', 'location_city.name', 'location_district.name', 'location_subdistrict.name', 'location_subdistrict.postal_code'])
            ->make(true);
    }

    public function query()
    {
        $query = $this->model
            ->join('location_city','location_city.province_id','=','location_province.id')
            ->join('location_district','location_district.city_id','=','location_city.id')
            ->join('location_subdistrict','location_subdistrict.district_id','=','location_district.id')
            ->selectRaw($this->getColumns());
        
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

    protected function getColumns()
    {
        return 'location_province.name AS province_name,
            location_city.name AS city_name,
            location_district.name AS district_name,
            location_subdistrict.name AS subdistrict_name,
            location_subdistrict.postal_code AS postal_code';
    }
}
