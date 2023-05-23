<div class="row">
    <div class="col-12">
        <h5 class="card-title">@lang('pg_patient_description.PATIENT_PROFESSIONALS_CARD_TTL')</h5>
    </div>
</div>
<div class="row" style="height:100px; overflow-y: auto;">
    <div class="col-12">
        <ul id="professionals_list_group" class="list-group professionals-card-list">
            @if( count($patient_professionals) == 0 ) 
                @component('widgets.illustration_panel_v')
                    @slot('id') no_professionals_illustration @endslot
                    @slot('title') NEVER APPEARS @endslot
                    @slot('desc_1') HERE TO IMPLEMENT LATER WHEN ORGS CAN ADD PATIENTS TO PROFESSIONALS @endslot
                    @slot('illustration') no_professionals.png @endslot
                @endcomponent
            @else
                @foreach($patient_professionals as $professional)
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-auto col-vcenter">
                                <img class="rounded-circle my-1" style="width: 35px; height: 35px; object-fit: cover;" src="{{ asset('user_uploads/avatars/' . $professional->avatar) }}">
                            </div>
                            <div class="col col-vcenter text-break">
                                @if(Auth::user()->id == $professional->key)
                                    @lang('pg_patient_description.YOU')
                                @else
                                    {{ $professional->name }}
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
    
</div>