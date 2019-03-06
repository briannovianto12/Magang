@extends('theme::layouts.master')

@section('scripts')
    @include('attribute-key::js', [
        'data' => $data ?? null,
        'repeater' => 'value_options'
    ])
@endsection

@section('content')

    @component('components._portlet',[
          'portlet_head' => true,
          'portlet_title' => isset($data) ? __('Ubah')." $title" : __('Tambah') . " $title"])
        @slot('body')

            @component('components._form', [
                'isUpload' => false,
                'action' => isset($data) ? route($module . '.update' , $data->id) : route($module . '.store'),
                'method' => isset($data) ? 'PUT' : ''
            ])
                @slot('forms')

                    @component('components.inputs._text', [
                        'id' => 'key',
                        'name' => 'key',
                        'label' => 'Key',
                        'value' => $data->key ?? null
                    ])
                    @endcomponent

                    @component('components.inputs._select', [
                        'id' => 'value_type',
                        'name' => 'value_type',
                        'label' => 'Value Type',
                        'value' => $data->value_type ?? null,
                        'options' => $value_type ?? []
                    ])
                    @endcomponent

                    @component('components.inputs._list', [
                        'module' => $module, // define module
                        'id' => 'value_options', // id for js
                        'label' => 'Value Options', // label
                        'visible' => isset($data) ? true : false, // define visible or not
                        'fields' => [ // define fields
                            ['name' => 'value', 'placeholder' => 'Value'],
                            ['name' => 'sku_part', 'placeholder' => 'SKU Part']
                        ],
                        'values' => $data->options ?? [], // get values when data is exists
                        'dataId' => $data->id ?? null,
                    ])
                    @endcomponent

                @endslot

                @slot('buttons')
                    <button type="submit" class="btn btn-accent">
                        {{ isset($data) ? __('Update') : __('Submit') }}
                    </button>
                    <button type="button" class="btn btn-secondary"
                            onclick="window.location.href='{{ route($module) }}'">
                        {{ __('Cancel') }}
                    </button>
                @endslot

            @endcomponent
        @endslot

    @endcomponent
@endsection