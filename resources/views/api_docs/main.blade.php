@extends('base.page_app')

@section('content')
<div class="row" style="height:3vh;"></div>
<div class="row">
    <div class="col-12">
        <h1 class="h1 vpg-title">Vitruvian Shield <span>Research API</span></h1>
    </div>
</div>

<div class="row mt-3">

    <div class="col-12 order-2 pr-1 pl-3
                px-md-3
                col-lg-8 order-lg-1
                col-xl-9">
        <div id="container-docs" class="position-relative text-justify pr-3 font-api-docs" data-spy="scroll" data-target="#nav-docs" data-offset="0" style="height: 80vh; overflow-y: auto">
            @include('api_docs.section_overview')
            @include('api_docs.section_patients')
            @include('api_docs.section_pros')
            @include('api_docs.section_teams')
            @include('api_docs.section_data')
        </div>
    </div>

    <div class="col-12 order-1 px-0
                col-lg-4 order-lg-2
                col-xl-3">

        <nav id="nav-docs" class="navbar navbar-light bg-light navbar-expand-lg">

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-api-index" aria-controls="navbar-api-index" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <nav id="navbar-api-index" class="nav nav-pills collapse navbar-collapse position-lg-relative bg-light" style="max-height: 78vh; overflow-y: auto; position:absolute; left: 0px; top: 100%;">
                <a class="nav-link w-100" onclick="return scrollDocs(this)" href="#i-overview">Overview</a>
                <nav class="nav nav-pills w-100">
                    <a class="nav-link ml-3 my-1 w-100" onclick="return scrollDocs(this)" href="#i-access">API Access</a>
                    <a class="nav-link ml-3 my-1 w-100" onclick="return scrollDocs(this)" href="#i-anonymization">Patient Data</a>
                    <a class="nav-link ml-3 my-1 w-100" onclick="return scrollDocs(this)" href="#i-example">Usage Example</a>
                </nav>
                <a class="nav-link w-100" onclick="return scrollDocs(this)" href="#i-get-patients">Patients</a>
                <nav class="nav nav-pills w-100">
                    <a class="nav-link ml-3 my-1 w-100" onclick="return scrollDocs(this)" href="#i-get-my-patients">Your Patients</a>
                    <a class="nav-link ml-3 my-1 w-100" onclick="return scrollDocs(this)" href="#i-get-all-patients">All Patients</a>
                    <a class="nav-link ml-3 my-1 w-100" onclick="return scrollDocs(this)" href="#i-get-team-patients">Team Patients</a>
                </nav>
                <a class="nav-link w-100" onclick="return scrollDocs(this)" href="#i-pros">Professionals</a>
                <nav class="nav nav-pills w-100">
                    <a class="nav-link ml-3 my-1 w-100" onclick="return scrollDocs(this)" href="#i-pros-teams">Team Members</a>
                </nav>
                <a class="nav-link w-100" onclick="return scrollDocs(this)" href="#i-teams">Team Projects</a>
                <nav class="nav nav-pills w-100">
                    <a class="nav-link ml-3 my-1 w-100" onclick="return scrollDocs(this)" href="#i-get-my-teams">Your Teams Projects</a>
                    <a class="nav-link ml-3 my-1 w-100" onclick="return scrollDocs(this)" href="#i-get-org-teams">Organization's Team Projects</a>
                </nav>
                <a class="nav-link w-100" onclick="return scrollDocs(this)" href="#i-data">Patient Data</a>
                <nav class="nav nav-pills w-100">
                    <a class="nav-link ml-3 my-1 w-100" onclick="return scrollDocs(this)" href="#i-get-profile">Health Profile</a>
                    <a class="nav-link ml-3 my-1 w-100" onclick="return scrollDocs(this)" href="#i-get-sensorbundle">Sensor Bundle</a>
                    <!-- medication -->
                    <a class="nav-link ml-3 my-1 w-100" onclick="return scrollDocs(this)" href="#i-add-medication">Add Medication</a>
                    <a class="nav-link ml-3 my-1 w-100" onclick="return scrollDocs(this)" href="#i-get-medication-for-day">Get Medication for a day</a>
                    <a class="nav-link ml-3 my-1 w-100" onclick="return scrollDocs(this)" href="#i-end-treatment">End Treatment</a>
                    <a class="nav-link ml-3 my-1 w-100" onclick="return scrollDocs(this)" href="#i-add-medication-intake">Add Medication Intake</a>
                    <a class="nav-link ml-3 my-1 w-100" onclick="return scrollDocs(this)" href="#i-remove-medication-intake">Remove Medication Intake</a>
                    <!-- crisis events -->
                    <a class="nav-link ml-3 my-1 w-100" onclick="return scrollDocs(this)" href="#i-add-crisis-event">Add Crisis Event</a>
                    <a class="nav-link ml-3 my-1 w-100" onclick="return scrollDocs(this)" href="#i-get-crisis-event-list">Get Crisis Event List</a>
                </nav>
            </nav>

        </nav>
    </div>

</div>
@endsection


@section('js')
    @parent
    <script type="text/javascript" src="{{ asset('js/pg_api_docs.js') }}"></script>
@endsection