@extends('base.base_canvas')

@section('page')
    <div class="row vstyle-background-app" style="min-height: 100vh"> {{-- min 100vh so footer appears under the page --}}
        <div class="col-12">

            <div class="container py-5 my-5 rounded vstyle-light shadow position-relative">
                @hasSection('content')
                    @yield('content')
                @endif
            </div>

        </div>
    </div>
@endsection