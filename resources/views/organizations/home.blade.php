@extends('base.page_app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in as organization!

                    <div class="row">
                        <div class="col-12">
                            <form action="/logout" method="POST">
                                @csrf

                                <button type="submit" class="btn vbtn-main">
                                    Logout
                                </button>

                            </form>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
