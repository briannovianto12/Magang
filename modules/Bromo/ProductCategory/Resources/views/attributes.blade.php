@extends('theme::layouts.master')

@section('scripts')
    @include('product-category::js')
@endsection

@section('content')

    @component('components._portlet',[
          'portlet_head' => true,
          'portlet_title' => 'Product Category Attribute Key'])
        @slot('body')

            @component('components._form', [
                'isUpload' => false,
                'action' => isset($data) ? route($module . '.update' , $data->id) : route($module . '.store'),
                'method' => isset($data) ? 'PUT' : ''
            ])
                @slot('forms')

                    @component('components.inputs._static', [
                        'label' => 'Parent Category',
                        'value' => $data->parent->name ?? null
                    ])
                    @endcomponent

                    @component('components.inputs._static', [
                        'label' => 'SKU',
                        'value' => $data->sku ?? null
                    ])
                    @endcomponent

                    @component('components.inputs._static', [
                        'label' => 'Name',
                        'value' => $data->name ?? null
                    ])
                    @endcomponent

                    @component('components.inputs._static', [
                        'label' => 'SKU Part',
                        'value' => $data->sku_part ?? null
                    ])
                    @endcomponent

                    @component('components.inputs._static', [
                        'label' => 'Level',
                        'value' => $data->categoryLevel->name,
                    ])
                    @endcomponent
                    @can('add_product_category_attribute')
                        <hr>
                        <div class="form-group m-form__group row">
                            <label for="" class="col-3 col-form-label text-right">Attributes</label>
                            <div class="col-6">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Key</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($attributeKeys as $attribute)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $attribute->key }}</td>
                                            <td>
                                                @if($data->attributeKeys()->find($attribute->id))
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                            onclick="detachAttribute('{{ route($module . '.attributes.detach', [$data->id, $attribute->id])  }}')">
                                                        <i class="la la-minus-circle"></i>
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-success btn-sm"
                                                            onclick="attachAttribute('{{ route($module . '.attributes.attach', [$data->id, $attribute->id])  }}')">
                                                        <i class="la la-plus-circle"></i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endcan
                @endslot

                @slot('buttons')
                    <button type="button" class="btn btn-secondary"
                            onclick="window.location.href='{{ route("{$module}") }}'">
                        {{ __('Cancel') }}
                    </button>
                @endslot

            @endcomponent
        @endslot

    @endcomponent
@endsection