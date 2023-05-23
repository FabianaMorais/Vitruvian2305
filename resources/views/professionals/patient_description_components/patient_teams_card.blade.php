
<div class="row">
    <div class="col-12">
        <h5 class="card-title">@lang('pg_patient_description.PATIENT_TEAMS_CARD_TTL')</h5>
    </div>
</div>

<div class="row" style="height:100px; overflow-y: auto;">
    <div class="col-12 col-vcenter">
        <ul id="professionals_list_group" class="list-group professionals-card-list">
            @if( count($patient_teams) == 0 ) 
            <div class="row" style="height:100%">
                <div class="col-5
                            text-left col-vcenter">
                            <h6 class="h6 font-weight-light">@lang('pg_patient_description.NO_TEAMS_DESC')</h6>
                            
                </div>
                <div class="col-7
                            text-center col-vcenter">
                    <img class="w-100 mx-auto" style="max-width: 400px;" src="{{ asset('images/illustrations/no_teams.png') }}">
                </div>
                
            </div>
            @else
                @foreach($patient_teams as $team)
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col col-vcenter text-break">
                                {{ $team->name }}
                            </div>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
    
</div>