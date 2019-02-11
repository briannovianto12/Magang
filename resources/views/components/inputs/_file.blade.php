<div class="form-group m-form__group {{ $errors->has($name) ? 'has-danger' : '' }} row pt-0 pb-2">
    <label @isset($id) for="{{ $id }}" @endisset class="col-3 col-form-label text-right">{{$label ?? ''}}</label>
    <div class="col-6 fileinput fileinput-new" data-provides="fileinput">
        <div class="fileinput-new thumbnail img-raised {{str_replace('_', '-', $name)}}"></div>
        <div class="fileinput-preview fileinput-exists thumbnail img-raised {{str_replace('_', '-', $name)}}"
             name="{{$name}}">
            @isset($value)
                <img name="img-raised" src="{{ $value }}" alt="" style="width: 200px">
            @else
                <img name="img-raised" src="https://via.placeholder.com/480x480?text=No+Image" alt=""
                     style="width: 200px">
            @endisset
        </div>
        <div>
            <span class="btn btn-raised btn-round btn-default btn-file">
                <span class="fileinput-new">Select image</span>
                <span class="fileinput-exists">Change</span>
                <input type="file" name="{{ $name }}"
                       @isset($required) required="required" @endisset
                       @isset($multiple) multiple="multiple" @endisset />
            </span>
            @isset($multiple)
                <button type="button" class="btn btn-danger btn-round remove-image" name="{{ $name }}">
                    <i class="fa fa-trash-alt"></i> Preview
                </button>
            @endisset
        </div>

        @if ($errors->has($name))
            <div class="form-control-feedback">{{ $errors->first($name) }}</div>
        @endif
        <span class="m-form__help pt-0 pb-1" id="{{$name}}_help">@isset($help) {{ $help }} @endisset</span>
    </div>
</div>