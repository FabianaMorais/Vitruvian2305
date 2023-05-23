<div id="entry_{{$pat->key}}" class="list-group-item list-group-item-action py-1 @if(isset($pat->selected) && $pat->selected == true) active @endif">

    <input id="key_{{$pat->key}}" class="team-patient-entry" type="hidden" value="{{ $pat->key }}">

    <div class="row">
        <div class="col-1 col-vcenter">
            <div class="custom-control custom-checkbox">
                <input id="cb_{{$pat->key}}" type="checkbox" class="custom-control-input" onclick="clickPatientCb('{{$pat->key}}', this)"  @if(isset($pat->selected) && $pat->selected == true) checked @endif>
                <label class="custom-control-label" for="cb_{{$pat->key}}"></label>
            </div>
        </div>
        <div class="col-10 col-sm col-vcenter">
            <div class="row">
                <div class="col-auto col-vcenter">
                    <img class="rounded-circle my-1" style="width: 40px; height: 40px; object-fit: cover;" src="{{ asset('user_uploads/avatars/' . $pat->avatar) }}">
                </div>
                <div class="col col-vcenter text-left">
                    <label class="my-0">{{ $pat->name }}</label>
                </div>
            </div>
        </div>

    </div>
</div>