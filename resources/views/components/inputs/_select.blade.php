<div class="form-group m-form__group {{ $errors->has($name) ? 'has-danger' : '' }} row pt-0 pb-2">
    <label @isset($id) for="{{ $id }}" @endisset class="col-3 col-form-label text-right">{{$label ?? ''}}</label>
    <div class="col-6">
        <select class="form-control m-input m-input--air{{ $errors->has($name) ? ' form-control-danger' : '' }}"
                name="{{ $name }}"
                @isset($id) id="{{ $id }}" @endisset
                @isset($required) required="required" @endisset
                @isset($disabled) disabled="disabled" @endisset
                @isset($multiple) multiple @endisset>
            @isset ($options)
                <option value=""></option>
                @if(isset($custom) && $custom == 'product_category')
                {!! printTree($options, $value) !!}
                @else
                    @foreach($options as $option)
                        @if(isset($multiple) && $multiple != null)
                            @if(!is_null($value))
                                @foreach($value as $item)
                                    @if($item->id == $option->id)
                                        {{ $id = $item->id }}
                                    @endif
                                @endforeach
                            @endif
                            <option @if($id == $option->id ) selected @endif
                            value="{{$option->id}}">{{$option->name ?? $option->title}}</option>
                        @else
                            <option @if($value == $option->id ) selected @endif
                            value="{{$option->id}}">{{$option->name ?? $option->title}}</option>
                        @endif
                    @endforeach
                @endif
            @endisset
        </select>
        @if ($errors->has($name))
            <div class="form-control-feedback">{{ $errors->first($name) }}</div>
        @endif
        <span class="m-form__help" id="{{$name}}_help">@isset($help) {{ $help }} @endisset</span>
    </div>
</div>