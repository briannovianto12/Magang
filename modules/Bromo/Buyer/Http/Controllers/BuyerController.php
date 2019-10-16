<?php

namespace Bromo\Buyer\Http\Controllers;

use Bromo\Buyer\DataTables\BuyerDataTable;
use Bromo\Buyer\Models\Buyer;
use Nbs\BaseResource\Http\Controllers\BaseResourceController;
use Bromo\Buyer\Models\Business;
use Bromo\Buyer\Models\BusinessAddress;
use Bromo\Buyer\Models\BusinessBankAccount;
use Bromo\Transaction\Models\Order;

class BuyerController extends BaseResourceController
{
    public function __construct(Buyer $model, BuyerDataTable $dataTable)
    {
        $this->module = 'buyer';
        $this->page = 'Buyer';
        $this->title = 'Buyer';
        $this->model = $model;
        $this->dataTable = $dataTable;
        $this->validateStoreRules = [];
        $this->validateUpdateRules = [];

        parent::__construct();
    }

    protected function modelDestroy($id)
    {
        $data = $this->model->findOrFail($id);
        $data->sessions()->delete();
        $data->businesses()->detach();
        $data->interests()->detach();
        $data->delete();

        return $data;
    }

    public function show($id)
    {
        $this->pageData['data'] = $this->model->findOrFail($id);
        $owner = $this->pageData['data']->business->getOwner();
        $business = Business::findOrFail($owner->pivot->business_id);
        $businessAddresses = $this->getBusinessAddresses($business->id);
        $businessBankAccounts = $this->getBusinessBankAccounts($business->id);
        $totalSpending = $this->getBusinessTotalSpending($business->id);
        $lastTenOrders = $this->getBusinessLastTenOrders($business->id);
        $this->requiredData = [
            'owner' => $owner,
            'business' => $business,
            'business_bank_accounts' => $businessBankAccounts,
            'business_addresses' => $businessAddresses,
            'total_spending' => $totalSpending,
            'last_ten_orders' => $lastTenOrders
        ];
        $data = array_merge($this->pageData, $this->requiredData);
        //dd($data);
        return view($this->getDetailView(), $data);
    }

    private function getBusinessAddresses($businessId){
        $businessAddresses = BusinessAddress::where('business_id', $businessId)
                                            ->get();
        return $businessAddresses;
    }

    private function getBusinessBankAccounts($businessId){
        $businessBankAccounts = BusinessBankAccount::where('business_id', $businessId)
                                                ->get();
        return $businessBankAccounts;
    }

    private function getBusinessLastTenOrders($businessId){
        $lastTenOrders = Order::select()
                            ->where('buyer_id', $businessId)
                            ->where('status', 5)
                            ->latest()
                            ->limit(10)
                            ->get();
        return $lastTenOrders;
    }

    private function getBusinessTotalSpending($businessId){
        $totalSpending = Order::select()
                            ->where('buyer_id', $businessId)
                            ->where('status', 10)
                            ->sum('payment_amount');
        return $totalSpending;
    }
}
