<div class="form-group m-form__group {{ $errors->has($name) ? 'has-danger' : '' }} row pt-0 pb-2">
    <label @isset($id) for="{{ $id }}" @endisset class="col-3 col-form-label text-right">{{$label ?? ''}}</label>
    <div class="col-6">
        <textarea class="form-control m-input m-input--air{{ $errors->has($name) ? ' form-control-danger' : '' }}"
                  type="{{ $type ?? 'text' }}" name="{{ $name }}"
                  @isset($placeholder) placeholder="{{ $placeholder }}" @endisset
                  @isset($cols) cols="{{ $cols }}" @endisset
                  @isset($rows) rows="{{ $rows }}" @endisset
                  @isset($id) id="{{ $id }}" @endisset
                  @isset($required) required="required" @endisset
        >{{ isset($value) ? $value : old($name) }}</textarea>
        @if ($errors->has($name))
            <div class="form-control-feedback">{{ $errors->first($name) }}</div>
        @endif
        <span class="m-form__help pt-0 pb-1" id="{{$name}}_help">@isset($help) {{ $help }} @endisset</span>
    </div>
</div>