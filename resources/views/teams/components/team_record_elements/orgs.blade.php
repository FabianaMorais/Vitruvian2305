{{-- Organizations --}}
<div class="row align-items-end mt-4">
    <div class="col">
        <h6 class="h6 text-uppercase font-weight-bold mb-0">@lang('record_team.ORGANIZATIONS')</h6>
    </div>

    @isset($editable) {{-- Appears only if user has edit permissions --}}
    <div class="col-auto">
        <button class="btn btn-sm vbtn-main vdisabled"><i class="fas fa-envelope"></i> @lang('record_team.EDIT_ORGANIZATIONS')</button>
    </div>
    @endif

    <div class="col-12">
        <hr class="mt-1">
    </div>
</div>
<div class="row mt-3">
    <div class="col-12 offset-0
                col-md-10 offset-md-1">
        <div class="row">

            @foreach($team->organizations as $uiOrg)
                <div class="col-12 mb-2
                            col-md-6 mb-md-4
                            col-xl-4">
                    {!! $uiOrg !!}
                </div>
            @endforeach

        </div>
    </div>



</div>
{{-- Organizations --}}