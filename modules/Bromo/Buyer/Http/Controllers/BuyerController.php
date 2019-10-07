<?php

namespace Bromo\Buyer\Http\Controllers;

use Bromo\Buyer\DataTables\BuyerDataTable;
use Bromo\Buyer\Models\Buyer;
use Nbs\BaseResource\Http\Controllers\BaseResourceController;
use Bromo\Buyer\Models\Business;
use Bromo\Buyer\Models\BusinessAddress;
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
        $business = Business::findOrFail($owner->pivot->business_id)->id;
        $businessAddress = BusinessAddress::select()
                            ->where('business_id', $business)
                            ->where('address_purpose_id', 1)
                            ->first();
        $totalSpending = Order::select()
                            ->where('buyer_id', $id)
                            ->where('status', 10)
                            ->sum('payment_amount');
        $lastTenOrders = Order::select()
                            ->where('buyer_id', $id)
                            ->where('status', 5)
                            ->latest()
                            ->limit(10)
                            ->get();
        $this->requiredData = [
            'owner' => $owner,
            'business' => $business,
            'business_address' => $businessAddress,
            'total_spending' => $totalSpending,
            'last_ten_orders' => $lastTenOrders
        ];
        $data = array_merge($this->pageData, $this->requiredData);
        return view($this->getDetailView(), $data);
    }
}
