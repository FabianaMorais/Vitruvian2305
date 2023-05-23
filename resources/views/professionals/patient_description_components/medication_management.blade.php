<div class="row justify-content-center">
  @if(count($daily_medication_schedule) == 0 || count($patient_medication) == 0)
    {{--TODO: Add "no medication for this user" page --}}
    @component('widgets.illustration_panel_v')
        @slot('id') no_med_illustration @endslot
        @slot('title') @lang('pg_patient_description.NO_MEDICATION_TITLE') @endslot
        @slot('desc_1') @lang('pg_patient_description.NO_MEDICATION_DESC_1') @endslot
        @slot('illustration') no_medication.png @endslot
    @endcomponent
    
  @else
    <div  class="col-auto mb-3">
      <div id="demo">
          <div id="med_calendar"></div>
      </div>
    </div>
    @if(count($patient_medication)>0)
    <div id="medication_schedule_container" class="col-auto">
      <div class="row"  style="display: flex;">
        <div class="col-12 mb-2">
          <div class="card" style="height:100%;min-width:230px;">
            <div class="card-body">
              @php
                $rows = count($daily_medication_schedule);
              @endphp
              @for($j = 0; $j < $rows; $j ++)
                <div class="row" style="display: flex;">
                    <div class="col-auto col-vcenter px-3 pl-2">
                      @if($daily_medication_schedule[$j]->type == 10)
                        <img class="mx-auto" style="width: 15px ; height : auto;" src="{{ asset('images/medication_icons/capsule.svg') }}">
                      @elseif($daily_medication_schedule[$j]->type == 20)
                        <img class="mx-auto" style="width: 15px ; height : auto;" src="{{ asset('images/medication_icons/pill.svg') }}">
                      @elseif($daily_medication_schedule[$j]->type == 21)
                        <img class="mx-auto" style="width: 15px ; height : auto;" src="{{ asset('images/medication_icons/tablet.svg') }}">
                      @elseif($daily_medication_schedule[$j]->type == 22)
                        <img class="mx-auto" style="width: 15px ; height : auto;" src="{{ asset('images/medication_icons/buccal.svg') }}">
                      @elseif($daily_medication_schedule[$j]->type == 30)
                        <img class="mx-auto" style="width: 15px ; height : auto;" src="{{ asset('images/medication_icons/syrup.svg') }}">
                      @elseif($daily_medication_schedule[$j]->type == 31)
                        <img class="mx-auto" style="width: 15px ; height : auto;" src="{{ asset('images/medication_icons/liquid.svg') }}">
                      @elseif($daily_medication_schedule[$j]->type == 40)
                        <img class="mx-auto" style="width: 15px ; height : auto;" src="{{ asset('images/medication_icons/suppository.svg') }}">
                      @elseif($daily_medication_schedule[$j]->type == 50)
                        <img class="mx-auto" style="width: 15px ; height : auto;" src="{{ asset('images/medication_icons/topical.svg') }}">
                      @elseif($daily_medication_schedule[$j]->type == 51)
                        <img class="mx-auto" style="width: 15px ; height : auto;" src="{{ asset('images/medication_icons/drops.svg') }}">
                      @elseif($daily_medication_schedule[$j]->type == 60)
                        <img class="mx-auto" style="width: 15px ; height : auto;" src="{{ asset('images/medication_icons/inhaler.svg') }}">
                      @elseif($daily_medication_schedule[$j]->type == 61)
                        <img class="mx-auto" style="width: 15px ; height : auto;" src="{{ asset('images/medication_icons/implant.svg') }}">
                      @elseif($daily_medication_schedule[$j]->type == 70)
                        <img class="mx-auto" style="width: 15px ; height : auto;" src="{{ asset('images/medication_icons/injection.svg') }}">
                      @endif



                    </div>
                    <div class="col-auto px-0 col-vcenter">
                      <span style="font-size: 10px;">{{$daily_medication_schedule[$j]->hour}} : {{$daily_medication_schedule[$j]->minute}} </span>
                    </div>
                    <div class="col-5 col-vcenter px-2">
                      <span style="font-size: 12px;">{{$daily_medication_schedule[$j]->name}} ({{$daily_medication_schedule[$j]->dosage}}mg)</span>
                    </div>

                    @if($daily_medication_schedule[$j]->prescribed_by_professional == true )
                    <div class="col col-vcenter">
                      <i id="arrow_down_med_options" class="fas fa-sort-down" style="font-size:15px; cursor: pointer; float:right;" onclick="showMedOptions()" data-toggle="collapse" data-target="#med_options_{{$j}}"></i>
                      <i id="arrow_up_med_options" class="fas fa-sort-down" style="font-size:15px; display: none; cursor: pointer; float:right;" onclick="hideMedOptions()" data-toggle="collapse" data-target="#med_options_{{$j}}"></i>
                    </div>
                    <div class="col-12 collapse mt-2" id="med_options_{{$j}}">
                    <div class="row">
                      <div class="col text-center" onclick="showTreatmentEdition('{{$daily_medication_schedule[$j]->id}}')" style="cursor: pointer;">
                        <i class="far fa-edit" style="font-size: 20px;"></i> @lang('generic.EDIT')
                      </div>
                      <div class="col text-center" onclick="setTreatmentFinish('{{$daily_medication_schedule[$j]->id}}')" style="cursor: pointer;">
                        <i class="far fa-trash-alt" style="font-size: 20px;"></i> @lang('generic.DEL')
                      </div>
                    </div>

                    </div>

                    @endif



                  </div>
                @if($j != $rows - 1)
                  <hr>
                @endif
              @endfor
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12" id="medication_schedule_loading">
      @component('widgets.panel_loading')
          @slot('id') med_schedule_loading @endslot
      @endcomponent
    </div>
    @endif
  @endif
</div>

