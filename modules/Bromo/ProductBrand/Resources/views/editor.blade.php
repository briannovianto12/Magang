@extends('theme::layouts.master')

@section('scripts')
    @include("{$module}::js")
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
                        'id' => 'name',
                        'name' => 'name',
                        'label' => 'Name',
                        'value' => $data->name ?? null
                    ])
                    @endcomponent

                    @component('components.inputs._text', [
                       'id' => 'sku_part',
                       'name' => 'sku_part',
                       'label' => 'SKU Part',
                       'value' => $data->sku_part ?? null
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