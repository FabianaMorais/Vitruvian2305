<div class="card vhover-card">
    <div class="card-body">
    <div class="row">
        <div class="col col-vcenter">
            <h5 class="h5 card-title">{{$team->name}}</h5>
        </div>
        <div class="col-auto">
            <a type="button" class="btn btn-sm vbtn-main" href="{{ route('teams.view', $team->key) }}">
                <i class="fas fa-eye my-0 py-0"></i> @lang('record_team.CARD_BTN')
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <p class="card-text font-weight-light">{{$team->pro_count}} @lang('record_team.PROFESSIONALS') <span class="font-weight-normal">&#183;</span> {{$team->patient_count}} @lang('record_team.PATIENTS')</p>
        </div>
    </div>
    </div>
    <div class="card-footer py-2">

        <div class="row">
            <div class="col-auto mr-0 pr-0 col-vcenter">
                <div class="w-100 overflow-hidden" style="height: 30px;">
                    {{-- We only print a total of 20 portraits, starting with the leaders --}}
                    @php( $avt_count = 0 )

                    @foreach($team->leaders as $leader)

                        @if($avt_count >= 20)
                            @break
                        @endif

                        <img class="rounded-circle" style="width: auto; height: 100%; object-fit: cover;" src="{{ asset('user_uploads/avatars/' . $leader->avatar ) }}" >
                        @php( $avt_count ++ )
                    @endforeach

                    @foreach($team->pros as $pro)

                        @if($avt_count >= 20)
                            @break
                        @endif

                        <img class="rounded-circle" style="width: auto; height: 100%; object-fit: cover;" src="{{ asset('user_uploads/avatars/' . $pro->avatar ) }}" >
                        @php( $avt_count ++ )
                    @endforeach

                    @if($avt_count == 0)
                        <p class="font-weight-light">@lang('record_team.CARD_EMPTY')</p>
                    @endif

                </div>
            </div>
        </div>

    </div>
</div>