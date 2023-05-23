<input type="hidden" id="loadImgErrorMsg" class="form-control" value="@lang('pg_profile.AVATAR_ERROR_IMG')">
<input type="hidden" id="loadImgDefault" class="form-control" value="{{ asset('user_uploads/avatars/' . session('avatar')) }}"> {{-- User's previous avatar image --}}
<input name="in_profile_avt" id="in_profile_avt" onchange="selectImage('in_profile_avt', 'img_avatar', $('#loadImgErrorMsg').val(), $('#loadImgDefault').val())" type="file" accept="image/png, image/jpeg, image/jpg" style="display:none"/>

<div class="row">
    <div class="col-12 offset-0 px-4
                col-lg-10 offset-lg-1 px-lg-0">

        <div class="row">
            <div class="col-12">
                <h6 class="h6 text-uppercase font-weight-bold mb-0">@lang('pg_profile.AVATAR')</h6>
                <hr class="mt-1">
            </div>

            <div class="col-12">
                <div class="row">
                    <div class="col-auto col-vcenter">
                        <h6 class="h6 font-weight-light">@lang('pg_profile.AVATAR_CHOOSE_FILE')</h6>
                    </div>
                    <div class="col-auto">
                        {{-- NOTE: Buttons must be labels in order to interact with input --}}
                        <label type="button" for="in_profile_avt" class='btn btn-sm vbtn-main'>
                            <i class="fas fa-camera"></i> @lang('pg_profile.AVATAR_BTN_CHOOSE')
                        </label>

                        <label type="button" class="btn btn-sm vbtn-support" onClick="cancelImgSelection('in_profile_avt', 'img_avatar', $('#loadImgDefault').val())">
                            <i class="fas fa-undo-alt"></i> @lang('pg_profile.AVATAR_BTN_RESET')
                        </label>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

