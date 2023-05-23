<div id="i-teams" class="mt-5">
    <h3 class="h3">Team Projects</h3>
    <label>The /teams endpoints allow you to obtain team project codes in order to request information about specific team projects.</label>
</div>
<div id="i-get-my-teams" class="mt-4">
    <h5 class="h5">Your Teams Projects</h5>

    <label>Retrieves the list of team projects in which you are included.</label>

    @component('api_docs.box_request')
        @slot('method') GET @endslot
        @slot('route')
            /teams
        @endslot
        @slot('returned')
            @component('api_docs.returned_values_component', 
                ['attributes' => [
                    'teams' => 'Team project codes from a project in which you participate'
                    ]
                ])
                
            @endcomponent
        @endslot
    @endcomponent

</div>
<div id="i-get-org-teams" class="mt-4">
    <h5 class="h5">Your Organization's Teams</h5>

    <label>Retrieves the full list of team projects conducted by your current organization.</label>

    @component('api_docs.box_request')
        @slot('method') GET @endslot
        @slot('route')
            /teams/organization
        @endslot
        @slot('returned')
            @component('api_docs.returned_values_component', 
                ['attributes' => [
                    'teams' => 'Team project codes from your organization'
                    ]
                ])
            @endcomponent
        @endslot
    @endcomponent

</div>
