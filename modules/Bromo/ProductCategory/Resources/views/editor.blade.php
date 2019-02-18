@extends('theme::layouts.master')

@section('scripts')
    @include('product-category::js')
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

                    @component('components.inputs._select', [
                        'id' => 'parent_id',
                        'name' => 'parent_id',
                        'label' => 'Parent Category',
                        'value' => $data->parent_id ?? null,
                        'options' => $categories ?? [],
                        'help' => 'If this is Parent Category leave blank this field.'
                    ])
                    @endcomponent

                    @component('components.inputs._text', [
                        'id' => 'ext_id',
                        'name' => 'ext_id',
                        'label' => 'Ext ID',
                        'value' => $data->ext_id ?? null
                    ])
                    @endcomponent

                    @component('components.inputs._text', [
                        'id' => 'name',
                        'name' => 'name',
                        'label' => 'Name',
                        'value' => $data->name ?? null
                    ])
                    @endcomponent

                    @component('components.inputs._text', [
                        'id' => 'sku_code',
                        'name' => 'sku_code',
                        'label' => 'SKU Code',
                        'value' => $data->sku_code ?? null
                    ])
                    @endcomponent

                    @component('components.inputs._select', [
                        'id' => 'level',
                        'name' => 'level',
                        'label' => 'Level',
                        'value' => $data->level ?? null,
                        'options' => $level ?? []
                    ])
                    @endcomponent


                @endslot

                @slot('buttons')
                    <button type="submit" class="btn btn-accent">
                        {{ isset($data) ? __('Update') : __('Submit') }}
                    </button>
                    <button type="button" class="btn btn-secondary"
                            onclick="window.location.href='{{ route("{$module}") }}'">
                        {{ __('Cancel') }}
                    </button>
                @endslot

            @endcomponent
        @endslot

    @endcomponent
@endsection