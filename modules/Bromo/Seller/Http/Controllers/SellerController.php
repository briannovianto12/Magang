<?php

namespace Bromo\Seller\Http\Controllers;

use Bromo\Seller\DataTables\SellerDataTable;
use Bromo\Seller\Models\Shop;
use Bromo\Seller\Models\ShopStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nbs\BaseResource\Http\Controllers\BaseResourceController;

class SellerController extends BaseResourceController
{
    public function __construct(Shop $model, SellerDataTable $dataTable)
    {
        $this->module = 'store';
        $this->page = 'Store';
        $this->title = 'Store';
        $this->model = $model;
        $this->dataTable = $dataTable;
        $this->validateStoreRules = [
            'name' => [
                'required'
            ],
            'description' => [
                'required'
            ]
        ];
        $this->validateUpdateRules = [
            'name' => [
                'required'
            ],
            'description' => [
                'required'
            ]
        ];

        parent::__construct();
    }

    public function verify($id)
    {
        DB::beginTransaction();

        try {
            $shop = $this->approval($id, ShopStatus::VERIFIED);
            nbs_helper()->flashSuccess('Shop has been Verified');
            DB::commit();

            // Send notification
            $owner = $shop->business->getOwner();
            if ($owner) { // check owner is exist
                $token = $owner->getNotificationToken();
                if (count($token) > 0) { // check token is exists
                    firebase()
                        ->createDataPayload([
                            'id' => snowflake_id(),
                            'user_id' => (string)$owner->id,
                            'shop_id' => (string)$id,
                            'title' => 'Shop Approved',
                            'type' => 'shop_approved',
                            'body' => 'Congratulation! Your Shop has been Approved',
                        ])
                        ->setTokens($token)
                        ->sendToDevice();
                }
            }

        } catch (\Exception $exception) {
            nbs_helper()->flashError('Something wen\'t wrong. Please contact Administrator');
            DB::rollBack();
        }

        return redirect()->back();

    }

    public function reject(Request $request, $id)
    {
        $this->validate($request, [
            'notes' => 'required|max:256'
        ]);

        DB::beginTransaction();
        try {
            $this->approval($id, ShopStatus::REJECTED, $request->input('notes'));
            nbs_helper()->flashSuccess('Shop has been Rejected');
            DB::commit();

        } catch (\Exception $exception) {
            nbs_helper()->flashError('Something wen\'t wrong. Please contact Administrator');
            DB::rollBack();
        }

        return redirect()->back();

    }

    public function approval($id, $status, $notes = null)
    {
        $data = $this->model->findOrFail($id);
        $data->status = $status;
        $data->save();

        if (!is_null($notes)) {
            $data->statusNotes()->create([
                'shop_snapshot' => $data->getOriginal(),
                'status' => $status,
                'notes' => $notes
            ]);
        }
        $data->refresh();

        return $data;
    }

}
