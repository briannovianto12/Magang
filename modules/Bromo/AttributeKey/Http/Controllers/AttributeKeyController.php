<?php

namespace Bromo\AttributeKey\Http\Controllers;

use Bromo\AttributeKey\DataTables\AttributeKeyDataTable;
use Bromo\Product\Models\ProductAttributeKey;
use Bromo\Product\Models\ProductAttributeValueType;
use Illuminate\Http\Request;
use Nbs\BaseResource\Http\Controllers\BaseResourceController;

class AttributeKeyController extends BaseResourceController
{
    public function __construct(ProductAttributeKey $model, AttributeKeyDataTable $dataTable)
    {
        $this->module = 'attribute-key';
        $this->page = 'Attribute Key';
        $this->title = 'Attribute Key';
        $this->model = $model;
        $this->dataTable = $dataTable;
        $this->validateStoreRules = [
            'key' => 'required',
            'value_type' => 'required'
        ];
        $this->validateUpdateRules = [
            'key' => 'required',
            'value_type' => 'required'
        ];
        $this->requiredData = [
            'value_type' => ProductAttributeValueType::query()->get()
        ];

        parent::__construct();
    }

    protected function performAfterStore(Request $request, $data)
    {
        if ($request->input('value_type') == ProductAttributeValueType::OPTIONS) {
            $this->validate($request, [
                'value_options.*.value' => 'required|max:64',
                'value_options.*.sku_part' => 'required|max:4'
            ]);

            foreach ($request->input('value_options') as $row) {
                $data->options()->create($row);
            }
        }
    }

    protected function performAfterUpdate(Request $request, $data)
    {
        if ($request->input('value_type') == ProductAttributeValueType::OPTIONS) {
            $this->validate($request, [
                'value_options.*.value' => 'required|max:64',
                'value_options.*.sku_part' => 'required|max:4'
            ], [], [
                'value_options.*.value' => 'Options Value',
                'value_options.*.sku_part' => 'Options SKU Part'
            ]);

            foreach ($request->input('value_options') as $row) {
                $data->options()->find($row['id'])->update($row);
            }
        }
    }


}
