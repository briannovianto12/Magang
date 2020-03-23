<?php

namespace Bromo\Disbursement\DataTables;

use Yajra\DataTables\Services\DataTable;
use Bromo\Disbursement\Entities\DisbursementStatus;

class DisbursementItemDataTable extends DataTable
{
    public function ajax()
    {
        return datatables($this->query())
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
            ->rawColumns(['amount_formatted', 'status'])
            ->make(true);
    }

    public function query()
    {
        $query = $this->model->select([
            'process_disbursement_item.disbursement_header_id',
            'process_disbursement_item.amount',
            'process_disbursement_item.bank_code',
            'process_disbursement_item.bank_account_name',
            'process_disbursement_item.bank_account_number',
            'process_disbursement_item.description',
            'process_disbursement_item.email',
            'process_disbursement_item.email_cc',
            'process_disbursement_item.email_bcc',
            'process_disbursement_item.external_id',
            'process_disbursement_item.shop_name',
            'process_disbursement_item.status',
            'process_disbursement_header.disbursement_header_no',
            'process_disbursement_status.name as status_name' 
        ])
        ->join('process_disbursement_header', 'process_disbursement_header.id', '=', 'process_disbursement_item.disbursement_header_id')
        ->join('process_disbursement_status', 'process_disbursement_status.id', '=', 'process_disbursement_item.status')
        ->where('process_disbursement_item.disbursement_header_id', '=', $this->header_id);

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