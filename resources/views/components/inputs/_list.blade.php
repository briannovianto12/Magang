<div @isset($id) id="{{ $id }}" @endisset class="{{ $visible ? '' : 'm--hide' }}">
    <div class="form-group m-form__group row">
        <label class="col-3 col-form-label text-right">{{ $label ?? '' }}:</label>
        <div data-repeater-list="{{ isset($id) ? $id : '' }}" class="col-6">
            @if(isset($values) && count($values) > 0)
                @foreach($values as $item)
                    <div data-repeater-item class="row m--margin-bottom-10">
                        @foreach($fields as $key => $row)
                            <div class="col-lg-5">
                                <div class="input-group">
                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                    <input type="text" name="{{ $row['name'] }}" class="form-control form-control-danger"
                                           placeholder="{{ $row['placeholder'] }}" value="{{ $item->{$row['name']} }}">
                                </div>
                            </div>
                        @endforeach
                        <div class="col-lg-2">
                            <a href="#" data-repeater-delete="" class="btn btn-danger m-btn m-btn--icon m-btn--icon-only">
                                <i class="la la-remove"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <div data-repeater-item class="row m--margin-bottom-10">
                    @foreach($fields as $key => $row)
                        <div class="col-lg-5">
                            <div class="input-group">
                                <input type="text" name="{{ $row['name'] }}" class="form-control form-control-danger"
                                       placeholder="{{ $row['placeholder'] }}">
                            </div>
                        </div>
                    @endforeach
                    <div class="col-lg-2">
                        <a href="#" data-repeater-delete="" class="btn btn-danger m-btn m-btn--icon m-btn--icon-only">
                            <i class="la la-remove"></i>
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>
    <div class="row">
        <div class="col-3"></div>
        <div class="col">
            <div data-repeater-create="" class="btn btn-primary m-btn btn-sm m-btn--icon">
                <span>
                    <i class="la la-plus"></i>
                    <span>Add</span>
                </span>
            </div>
        </div>
    </div>
</div>