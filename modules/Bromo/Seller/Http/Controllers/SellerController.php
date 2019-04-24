<?php

namespace Bromo\Seller\Http\Controllers;

use Bromo\Seller\DataTables\SellerDataTable;
use Bromo\Seller\Models\Shop;
use Bromo\Seller\Models\ShopStatus;
use Exception;
use Illuminate\Database\Eloquent\Model;
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

            // Send notification
            $owner = $shop->business->getOwner();
            if (!is_null($owner)) { // check owner is exist
                $token = $owner->getNotificationTokens();
                if (count($token) > 0) { // check token is exists
                    firebase()
                        ->toAndroid($owner->id, 'BSM002', [
                            "title" => "Approved",
                            "message" => "Your Shop has been Approved"
                        ])
                        ->setTokens($token)
                        ->sendToDevice();
                }
            }
            DB::commit();

        } catch (Exception $exception) {
            report($exception);
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
            $shop = $this->model->findOrFail($id);
            $owner = $shop->business->getOwner();
            if (!is_null($owner)) { // check owner is exist
                $token = $owner->getNotificationTokens();
                if (count($token) > 0) { // check token is exists
                    // Send notification
                    firebase()
                        ->toAndroid($owner->id, 'BSM002', [
                            "title" => "Rejected",
                            "message" => "Your Shop has been Rejected"
                        ])
                        ->setTokens($token)
                        ->sendToDevice();
                }
            }
            $shop->statusNotes()->create([
                'shop_snapshot' => $shop->getOriginal(),
                'status' => ShopStatus::REJECTED,
                'notes' => $request->input('notes')
            ]);
            $shop->index()->delete();
            $shop->delete();
            DB::commit();
            nbs_helper()->flashSuccess('Shop has been Rejected');

        } catch (Exception $exception) {
            report($exception);
            DB::rollBack();
            nbs_helper()->flashError('Something wen\'t wrong. Please contact Administrator');
        }

        return redirect("{$this->module}");
    }

    /**
     * @param $id
     * @param int $status
     * @return Model
     */
    public function approval($id, int $status)
    {
        $data = $this->model->find($id);
        $data->update([
            'status' => $status
        ]);

        return $data;
    }

}
