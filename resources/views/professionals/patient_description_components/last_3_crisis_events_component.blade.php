@if(count($crisis_event_list) == 0)
    @component('widgets.illustration_panel_h')
        @slot('id') search_illustration @endslot
        @slot('title') @lang('pg_patient_description.NO_USER_CRISIS_TTL') @endslot
        @slot('desc_1') @lang('pg_patient_description.NO_USER_CRISIS_DESC') @endslot
        @slot('illustration') no_user_crisis.png @endslot
        @slot('btns') <a class="btn vbtn-main btn-sm" data-toggle="modal" data-target="#addCrisisModal" style="color:white;">@lang('generic.ADD_NEW')</a>  @endslot
    @endcomponent
@else
    <div class="row flex-grow-1">
        <div class="col-12">
            <div class="h-100 overflow-auto position-relative my-1" style="min-height: 210px"> {{-- List canvas --}}
                <div class="position-absolute w-100"> {{-- List scrollable area --}}

                    @foreach($crisis_event_list as $crisis_event)
                        <a onclick="goToCrisisEvent( {{$loop->index}})" @if(isset($full_list)) id="page_nr_{{$loop->index}}" @endif href="#" class="list-group-item list-group-item-action py-1">
                            <div class="row">
                                <div class="col-8">
                                    <div class="row pl-2 pt-2">
                                        <div class="col-12 pt-0 mt-0 pb-0 mb-0 ">
                                            <span class="font-weight-bold" style="font-size:10pt;line-height:1;">{{$crisis_event->crisis_event_name}}@if($crisis_event->submitted_by_doctor == false) <span class="text-danger">*</span> @endif</span>
                                        </div>
                                        <div class="col-12 pt-0 mt-0 pb-0 mb-0">
                                            <span class="font-weight-lighter text-nowrap" style="font-size:8pt;"><i class="far fa-clock" style="font-size:8pt"></i>  {{$crisis_event->crisis_date}} {{$crisis_event->crisis_event_time}}</span>
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                                <div class="col-3 col-vcenter offset-1 text-right">
                                    <i class="far fa-eye"></i>
                                </div>
                            </div>
                        </a>
                        @if(!isset($full_list))
                            @if($loop->index == 2)
                                @break
                            @endif
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="row px-1 mb-0 mt-2 pb-0 pt-2">
        <div class="col-4 col-vcenter">
            <h6 class="h6 font-weight-lighter" style="font-size:8pt"><span class="text-danger">*</span> Patient submitted</h6>
        </div>
        @if(!isset($full_list))
        <div class="col-4 text-right pb-0 pt-0 mt-0 mb-0" style="color:white;">
            <a class="btn vbtn-main btn-sm" data-toggle="modal" data-target="#addCrisisModal">@lang('generic.ADD_NEW')</a>
        </div>
        <div class="col-4 text-right pb-0 pt-0 mt-0 mb-0">
            <button onclick="goToCrisisEvent(0)" @if(count($crisis_event_list) == 0) disabled @endif class="btn vbtn-main btn-sm">View all</button>
        </div>
        @endif
    </div>
@endif
