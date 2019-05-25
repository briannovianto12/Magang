<?php

namespace Bromo\Product\Http\Controllers;

use Bromo\Product\Models\UnitType;
use Illuminate\Support\Facades\DB;
use Nbs\BaseResource\Http\Controllers\BaseResourceController;

class UnitTypeController extends BaseResourceController
{
    public function __construct(UnitType $model)
    {
        $this->module = 'unit-type';
        $this->page = 'Unit Type';
        $this->title = 'Unit Type';
        $this->model = $model;
        $this->validateStoreRules = [
            'name' => 'required'
        ];
        $this->validateUpdateRules = $this->validateStoreRules;

        parent::__construct();
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        $model = $this->model->find($id);
        if ($model->products()->count() > 0 && $model->buyingOptions()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => __('Unit type can\'t be deleted because related with ' . $model->products()->count() . ' Products, and ' . $model->buyingOptions()->count() . ' buying options')
            ]);
        }
        try {
            $model->delete();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => __('Look like something wen\'t wrong')], 500);

        }
        return response()->json(['success' => true]);
    }


}
