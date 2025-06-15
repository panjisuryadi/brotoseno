
@if(!request()->routeIs('app.pos.*'))

<footer class="c-footer">
    <div>{!! settings()->footer_text !!}</div>

    <div class="mfs-auto d-md-down-none">&nbsp;<a href="https://official-gtds.com/" target="_blank">&nbsp;</a>
    </div>



    <div class="footer-right">{{-- v{{ \App\Libraries\MyString::version(config('site.version')) }} --}}
        <div class="form-inline mb-2"><div class="col-xs-3 mr-1"> <span class="mb-2" style="font-weight: 400"> Powered by <span class="font-semibold"> | HOKKIE <br>  </span></span>
    </div>
    <div class="col-xs-3">
        <img src="{{ asset('images/gtds.svg') }}" class="img" style="width: 40px !important;">
    </div>
</div>
</div>
</footer>
@endif



