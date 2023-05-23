<div class="list-group">
    @foreach($teams_with_patients as $key=>$team_with_patients)

        <div class="row py-1">
            <div class="col-9 col-vcenter">
                {{$team_with_patients->name}} ({{$team_with_patients->patient_count}})
            </div>
            <div class="col-2 mx-0 px-0 col-vcenter">
                <div class="form-check mx-0 px-0">
                    <div class="custom-control custom-checkbox">
                        <input value="team_{{$key}}" id="team_{{$key}}" name="team_{{$key}}" type="checkbox"  class="custom-control-input" onchange="selectTeam({{$key}})">
                        <label for="team_{{$key}}" class="custom-control-label"></label>
                    </div>
                </div>
            </div>
            <div class="col col-vcenter mx-0 px-0" style="cursor:pointer">
                <i id="closed_team_selection_team_{{$key}}" class="fas fa-angle-down" onclick="showTeam('team_{{$key}}')"></i>
                <i id="open_team_selection_team_{{$key}}" class="fas fa-angle-up" onclick="hideTeam('team_{{$key}}')" style="display:none;"></i>
            </div>
            <div class="col-12 my-0 py-0">
                <hr>
            </div>
        
        </div>
        <div id="patients_team_{{$key}}" class="row" style="display:none;">
            <div class="col-12">
                <ul  class="list-group list-group-flush user-list">    
                    @foreach($team_with_patients->patients as $patient)
                        <li class="col-12 list-group-item py-0 my-0">
                            <div class="row">
                                <div class="col-9 col-vcenter">
                                    <div class="row">
                                        <div class="col-auto col-vcenter">
                                            <img class="rounded-circle my-1" style="width: 40px; height: 40px; object-fit: cover;" src="{{ asset('user_uploads/avatars/avt_default.jpg') }}">
                                        </div>
                                        <div class="col-auto col-vcenter text-left">
                                            <label class="my-0">{{$patient->name}}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 col-vcenter">
                                    <div class="form-check">
                                        <div class="custom-control custom-checkbox" >
                                            <input value="{{$patient->id}}" id="patient_{{$key}}_{{$patient->id}}" name="patient_{{$key}}_{{$patient->id}}" type="checkbox"  class="custom-control-input" onchange="selectUser({{$key}},{{$patient->id}})">
                                            <label for="patient_{{$key}}_{{$patient->id}}" class="custom-control-label"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

    

    @endforeach
</div>