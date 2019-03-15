<a href="{{ $url ?? '#' }}"
   @isset($customClass)
   class="{{ $customClass }}"
   @else
   class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill d-md-inline-block"
   @endisset
   title="{{ $title ?? '' }}">@isset($iconClass) <i class="{{ $iconClass }}"></i> @endisset
</a>