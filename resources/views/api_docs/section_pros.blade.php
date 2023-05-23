<div id="i-pros" class="mt-5">
    <h3 class="h3">Professionals</h3>
    <label>The /professionals endpoints allow you to obtain information about the professionals in your organization.</label>
</div>
<div id="i-pros-teams" class="mt-4">
    <h5 class="h5">Team Members</h5>

    <label>Retrieves the full list of team members for the passed team projects.</label>

    @component('api_docs.box_request')
        @slot('method') POST @endslot
        @slot('route')
            /professionals/teams
        @endslot
        @slot('expected')
            teams: An array of team codes
        @endslot
        @slot('returned')
            @component('api_docs.returned_values_component', 
                ['attributes' => [
                    'team_name' => 'Current team project name',
                    'code' => 'Current team project code',
                    'professionals' => 'An array of all professionals participating in the current project',
                    '[' => '',
                    'name' => 'The professional\'s full name',
                    'role' => 'The professional\'s role in the team project (leader or member)',
                    'type' => 'The professional\'s type (medical professional, researcher or caregiver)',
                    ']' => ''
                    ]
                ])
                @slot('objects_in_array') Team Project @endslot
            @endcomponent
        @endslot
    @endcomponent

</div>