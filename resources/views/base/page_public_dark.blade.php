@extends('base.base_canvas')

@section('page')
    <div class="row vstyle-background-dark" style="padding-top: 12vh; min-height: 100vh"> {{-- min 100vh so footer appears under the page --}}
        <div class="col-12">
            @hasSection('content')
                @yield('content')
            @endif
        </div>
    </div>
@endsection