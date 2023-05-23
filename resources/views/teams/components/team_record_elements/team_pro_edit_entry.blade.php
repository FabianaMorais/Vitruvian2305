<div id="entry_{{$pro->key}}" class="list-group-item list-group-item-action py-1 @isset($pro->role) active @endif">

    <input id="key_{{$pro->key}}" class="team-pro-entry" type="hidden" value="{{ $pro->key }}">

    <div class="row">
        <div class="col-1 col-vcenter">
            <div class="custom-control custom-checkbox">
                <input id="cb_{{$pro->key}}" type="checkbox" class="custom-control-input" onclick="clickProCb('{{$pro->key}}', this)" @isset($pro->role) checked @endif>
                <label class="custom-control-label" for="cb_{{$pro->key}}"></label>
            </div>
        </div>
        <div class="col-10 col-sm col-vcenter">
            <div class="row">
                <div class="col-auto col-vcenter">
                    <img class="rounded-circle my-1" style="width: 40px; height: 40px; object-fit: cover;" src="{{ asset('user_uploads/avatars/' . $pro->avatar) }}">
                </div>
                <div class="col col-vcenter text-left">
                    <label class="my-0">{{ $pro->name }}</label>
                </div>
            </div>
        </div>

        <div id="role_panel_{{$pro->key}}" class="col-auto col-sm-auto col-vcenter" @if(!isset($pro->role)) style="display: none" @endif>
            <div class="form-group my-0">
                <select id="role_{{$pro->key}}" class="form-control form-control-sm">
                    <option value="member" @if(!isset($pro->role) || $pro->role != App\Models\TeamUser::LEADER) selected @endif>@lang('record_team.ROLE_MEMBER')</option>
                    <option value="leader" @if(isset($pro->role) && $pro->role == App\Models\TeamUser::LEADER) selected @endif>@lang('record_team.ROLE_LEADER')</option>
                </select>
            </div>
        </div>
        <div id="access_panel_{{$pro->key}}" class="col-auto col-sm-auto col-vcenter" @if(!isset($pro->role)) style="display: none" @endif>
            <div class="form-group my-0">
                <select id="access_{{$pro->key}}" class="form-control form-control-sm">
                    <option value="read" @if( !isset($pro->access) || ($pro->access != App\Models\TeamUser::WRITE) ) selected @endif >@lang('record_team.ACCESS_READ')</option>
                    <option value="write" @if( isset($pro->access) && ($pro->access == App\Models\TeamUser::WRITE) ) selected @endif >@lang('record_team.ACCESS_WRITE')</option>
                </select>
            </div>
        </div>
    </div>
</div>