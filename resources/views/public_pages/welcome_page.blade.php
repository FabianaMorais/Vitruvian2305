@extends('base.base_canvas')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('css/components/frozen_panel.css') }}">
@endsection

@section('page')

    @include('public_pages.welcome.welcome_panel')

    <div class="row py-5 shadow">
        <div class="col-12">
            @include('public_pages.welcome.target_audience')
        </div>
    </div>

    @include('public_pages.welcome.why_vs')

    @include('public_pages.welcome.vs_tools')

    <hr>

    @include('public_pages.welcome.partners_line')
    @include('public_pages.welcome.become_partner_panel')
    @include('public_pages.welcome.roadmap')

</div>

@endsection