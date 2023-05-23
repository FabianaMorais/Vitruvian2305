<div class="col-12 col-vcenter text-center" style="min-height:40vh;">
    <i class="fas fa-exclamation-triangle" style="color: var(--color-text-dark);font-size:4em;"></i>
    <br/>
    @isset($error_msg) {!! $error_msg !!} @else @lang('generic.STANDARD_ERROR_MSG') @endif
</div>