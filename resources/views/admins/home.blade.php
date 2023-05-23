@extends('base.page_app')

@section('content')
    <div class="row justify-content-center">

        <div class="col-auto">
            @component('widgets.dashboard_item')
                @slot('icon') <i class="fas fa-user-md"></i> @endslot
                @slot('color') red @endslot
                @slot('text') @lang('pg_manage_regs.TITLE') @endslot
                @slot('onclick') window.location='{{ route('admin.registrations') }}'; @endslot
                @slot('badge_count') {{ $dashboard_data['registrations'] }} @endslot
            @endcomponent
        </div>

        <div class="col-auto">
            @component('widgets.dashboard_item')
                @slot('icon') <i class="fab fa-google"></i> @endslot
                @slot('color') red @endslot
                @slot('text') Google.com @endslot
                @slot('onclick') window.location='http://google.com'; @endslot
            @endcomponent
        </div>

    </div>
@endsection
