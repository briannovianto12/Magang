<?php

namespace Bromo\Disbursement\DataTables;

use Yajra\DataTables\Services\DataTable;
use Bromo\Disbursement\Entities\DisbursementStatus;

class DisbursementHeaderDataTable extends DataTable
{
    public function ajax()
    {
        return datatables($this->query())
            ->addColumn('header_no', function ($data) {
                return '<a href="' . route('disbursement.index-item', $data->id) .'">'.$data->disbursement_header_no.'</a>';
            })
            ->editColumn('created_at', function ($data) {
                return date_format($data->created_at, 'd-M-Y H:i:s');
            })
            ->editColumn('amount_formatted', function ($data) {
                $amount = $data->amount;
                return '<div style="text-align:right">'. number_format($amount, 0, 0, '.') .'</div>';
            })
            ->editColumn('status', function ($data) {
                if($data->status == DisbursementStatus::WAITING_TO_BE_PROCESSED){
                    return '<span class="badge badge-secondary">'.DisbursementStatus::STR_WAITING_TO_BE_PROCESSED.'</span>';
                }else if($data->status == DisbursementStatus::WAITING_FOR_APPROVAL){
                    return '<span class="badge badge-primary">'.DisbursementStatus::STR_WAITING_FOR_APPROVAL.'</span>';
                }else if($data->status == DisbursementStatus::COMPLETED){
                    return '<span class="badge badge-success">'.DisbursementStatus::STR_COMPLETED.'</span>';
                }else if($data->status == DisbursementStatus::CHECK){
                    return '<span class="badge badge-warning">'.DisbursementStatus::STR_CHECK.'</span>';
                }else if($data->status == DisbursementStatus::DELETED || $data->status == DisbursementStatus::FAILED){
                    return '<span class="badge badge-danger">'.$data->status_name.'</span>';
                }
            })
            ->rawColumns(['header_no', 'amount_formatted', 'status'])
            ->make(true);
    }

    public function query()
    {
        $query = $this->model->select([
            'process_disbursement_header.id',
            'process_disbursement_header.disbursement_header_no',
            'process_disbursement_header.amount',
            'process_disbursement_header.total_item',
            'process_disbursement_header.remark',
            'process_disbursement_header.created_by',
            'admin.name',
            'process_disbursement_header.created_at',
            'process_disbursement_header.updated_at',
            'process_disbursement_header.status',
            'process_disbursement_header.processed_flag',
            'process_disbursement_status.name as status_name'            
            ])
        ->join('admin', 'admin.id', '=', 'process_disbursement_header.created_by')
        ->join('process_disbursement_status', 'process_disbursement_status.id', '=', 'process_disbursement_header.status');

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