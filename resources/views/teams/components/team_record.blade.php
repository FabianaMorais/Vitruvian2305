
@if (isset($editable) )
    <input id="team_key" type="hidden" value="{{ $team->key }}">
@endif

@include('teams.components.team_record_elements.header')
@include('teams.components.team_record_elements.pros')
@include('teams.components.team_record_elements.orgs')
@include('teams.components.team_record_elements.patients')

@isset($editable) {{-- If the user has no edition rights, we don't need to print the JS at all --}}
    @section('js')
        @parent
        <script type="text/javascript">
            updateSettingsUrl = {!! json_encode(route('teams.update.settings'), JSON_HEX_TAG) !!};
            deleteTeamUrl = {!! json_encode(route('teams.update.delete', ''), JSON_HEX_TAG) !!};
            getTeamProsUrl = {!! json_encode(route('teams.pros_vs_team'), JSON_HEX_TAG) !!};
            updateTeamProsUrl = {!! json_encode(route('teams.update.pros'), JSON_HEX_TAG) !!};
            viewProUrl = {!! json_encode(route('pros.ui.record'), JSON_HEX_TAG) !!};
            getTeamPatientsUrl = {!! json_encode(route('teams.patients_vs_team'), JSON_HEX_TAG) !!};
            updateTeamPatientsUrl = {!! json_encode(route('teams.update.patients'), JSON_HEX_TAG) !!};
        </script>
        <script type="text/javascript" src="{{ asset('js/pg_team_record_desc.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/pg_team_record_orgs.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/pg_team_record_pros.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/pg_team_record_patients.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/form_validations.js') }}"></script>
    @endsection
@endif