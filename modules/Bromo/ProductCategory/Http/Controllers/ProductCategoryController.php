<?php

namespace Bromo\ProductCategory\Http\Controllers;

use Bromo\Product\Models\ProductAttributeKey;
use Bromo\ProductBrand\Models\ProductBrand;
use Bromo\ProductCategory\DataTables\ProductCategoryDataTable;
use Bromo\ProductCategory\Models\ProductCategory;
use Bromo\ProductCategory\Models\ProductCategoryLevel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nbs\BaseResource\Http\Controllers\BaseResourceController;

class ProductCategoryController extends BaseResourceController
{
    public function __construct(ProductCategory $model, ProductCategoryDataTable $dataTable)
    {
        $this->module = 'product-category';
        $this->page = 'Product Category';
        $this->title = 'Product Category';
        $this->model = $model;
        $this->dataTable = $dataTable;
        $this->validateStoreRules = [
            'sku' => 'required',
            'name' => 'required',
            'parent_id' => 'nullable',
            'level' => 'required',
            'sku_part' => 'nullable'
        ];

        $this->validateUpdateRules = [
            'sku' => 'required',
            'name' => 'required',
            'parent_id' => 'nullable',
            'level' => 'required',
            'sku_part' => 'nullable'
        ];

        $this->requiredData = [
            'categories' => ProductCategory::query()->get(),
            'level' => ProductCategoryLevel::query()->get(),
        ];

        parent::__construct();
    }

    protected function modifyWhenStore(array $inputData, Request $request): array
    {
        $parent = ProductCategory::find($inputData['parent_id']);

        if ($parent) {
            $inputData['sku'] = $parent->sku . '-' . $request->sku;
        }

        return parent::modifyWhenStore($inputData, $request);
    }

    public function attributes($id)
    {
        $data['module'] = $this->module;
        $data['data'] = $this->model->findOrFail($id);
        $data['attributeKeys'] = ProductAttributeKey::all();

        return view("{$this->module}::attributes", $data);
    }

    public function brands($id)
    {
        $data['module'] = $this->module;
        $data['data'] = $this->model->findOrFail($id);
        $data['productBrands'] = ProductBrand::all();

        return view("{$this->module}::brands", $data);

    }

    public function attachAttribute($category, $id)
    {
        DB::beginTransaction();
        try {
            $this->model->find($category)->attributeKeys()->attach($id, ['sort' => 1]);
            DB::commit();

        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            throw $exception;
        }

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function detachAttribute($category, $id)
    {
        DB::beginTransaction();
        try {
            $this->model->find($category)->attributeKeys()->detach($id);
            DB::commit();

        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            throw $exception;
        }

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function attachBrand($category, $id)
    {
        DB::beginTransaction();
        try {
            $this->model->find($category)->brands()->attach($id, [
                'id' => snowflake_id(),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:sO')
            ]);
            DB::commit();

        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            throw $exception;

        }

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function detachBrand($category, $id)
    {
        DB::beginTransaction();
        try {
            $this->model->find($category)->brands()->detach($id);
            DB::commit();

        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            throw $exception;
        }

        return response()->json([
            'status' => 'success'
        ]);
    }
}
