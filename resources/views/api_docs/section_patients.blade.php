<div id="i-get-patients" class="mt-5">
    <h3 class="h3">Knowing Your Patients</h3>
    <label>The /patients endpoints allow you to obtain patient codes in order to request specific data.</label>
</div>

<div id="i-get-my-patients" class="mt-4">
    <h5 class="h5">Your Patients</h5>
    <label>Retrieves the list of patients which are associated with you directly.</label>

    @component('api_docs.box_request')
        @slot('method') GET @endslot
        @slot('route')
            /patients
        @endslot
        @slot('returned')
            @component('api_docs.returned_values_component', 
                ['attributes' => [
                    'patients' => 'An array of patient codes from all patients directly owned by you'
                    ]
                ])
            @endcomponent
        @endslot
    @endcomponent

</div>

<div id="i-get-all-patients" class="mt-4">
    <h5 class="h5">All Patients</h5>
    <label>Retrieves the list of patients which are associated with you either directly or through team projects.</label>

    @component('api_docs.box_request')
        @slot('method') GET @endslot
        @slot('route')
            /patients/all
        @endslot
        @slot('returned')
            @component('api_docs.returned_values_component', 
                ['attributes' => [
                    'patients' => 'An array of patient codes from all patients associated with you'
                    ]
                ])
            @endcomponent
        @endslot
    @endcomponent

</div>

<div id="i-get-team-patients" class="mt-4">
    <h5 class="h5">Patients From a Team</h5>
    <label>Retrieves the list of patients associated with the passed team projects.</label>
    <label>You must be a participant in each one of the passed team projects in order to make this request.</label>

    @component('api_docs.box_request')
        @slot('method') POST @endslot
        @slot('route')
            /patients/teams
        @endslot
        @slot('expected')
            @component('api_docs.expected_values_component', 
                ['attributes' => [
                    'teams' => 'REQUIRED - An array of team codes'
                    ]
                ])
            @endcomponent
            
        @endslot
        @slot('returned')
            @component('api_docs.returned_values_component', 
                ['attributes' => [
                    'team_name' => 'Current team project name',
                    'code' => 'Current team project code',
                    'patients' => 'An array of patient codes from all patients participating in this project'
                    ]
                ])
                @slot('objects_in_array') Team Project @endslot
            @endcomponent
        @endslot
    @endcomponent

</div>