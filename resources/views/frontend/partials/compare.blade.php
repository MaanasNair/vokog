<a href="{{ route('compare') }}" class="nav-box-link">
    <i class="la la-refresh d-inline-block nav-box-icon"></i>
    <span class="nav-box-text d-none d-lg-inline-block">{{__('Compare')}}</span>
    @if(Session::has('compare'))
        <span class="nav-box-number">{{ count(Session::get('compare'))}}</span>
    @else
        <span class="nav-box-number">0</span>
    @endif
</a>
