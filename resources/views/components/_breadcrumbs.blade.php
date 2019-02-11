<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">{{$breadcrumbs_title}}</h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="{{ route('dashboard') }}" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                @isset($breadcrumbs)
                    @foreach($breadcrumbs as $data)
                        <li class="m-nav__separator">-</li>
                        <li class="m-nav__item">
                            <a href="{{$data['url']}}" class="m-nav__link">
                                <span class="m-nav__link-text">{{$data['name']}}</span>
                            </a>
                        </li>
                    @endforeach
                @endisset
            </ul>
        </div>
    </div>
</div>