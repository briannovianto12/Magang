<?php

namespace Bromo\Buyer\Http\Controllers;

use Bromo\Buyer\DataTables\BuyerDataTable;
use Bromo\Buyer\Models\Buyer;
use Nbs\BaseResource\Http\Controllers\BaseResourceController;
use Bromo\Buyer\Models\Business;
use Bromo\Buyer\Models\BusinessAddress;
use Bromo\Buyer\Models\BusinessBankAccount;
use Bromo\Transaction\Models\Order;
use Bromo\Buyer\Entities\FraudBlackListUser;
use Bromo\Buyer\Entities\UserProfile;
use Illuminate\Support\Facades\DB;
use Bromo\Buyer\Entities\UserStatus as Status;
use Bromo\Tools\Entities\PhoneNumberBlacklist;

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
        $fraud_blacklist_user = FraudBlackListUser::where('user_id',$id)->count();

        if($fraud_blacklist_user > 0 || $this->pageData['data']->status == Status::BLOCKED) {
            $data['blacklist_status'] = true;
        }else{
            $data['blacklist_status'] = false;
        }
        
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


    public function blacklistUser($id){
        $admin = \Auth::user()->id;
        DB::beginTransaction();     
        try{   
            $fraud_blacklist_user = new FraudBlacklistUser;
            $fraud_blacklist_user->user_id = $id;
            $fraud_blacklist_user->fraud_status = 1;
            $fraud_blacklist_user->remark = 'blacklist by user id = '. \Auth::user()->id;
            $fraud_blacklist_user->save();

            $user = UserProfile::find($id);
            $user->status = Status::BLOCKED;
            $user->save();

            DB::commit();

            nbs_helper()->flashSuccess('Success Blacklisted User');
        }catch(\Illuminate\Database\QueryException $ex){ 
            DB::rollBack();
            nbs_helper()->flashMessage('error');
        }
        return redirect()->back();     
    }
}
