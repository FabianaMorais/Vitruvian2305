<form action="{{ $postRoute }}" method="POST" enctype="multipart/form-data">
@csrf

    @isset( $pro_entry->key )
        <input name="pro_key" type="hidden" value="{{ $pro_entry->key }}">
    @endif

    <div class="row justify-content-center">
        <div class="col-auto
                    col-vcenter">

            <div class="row">
                <div class="col text-center">
                    <input type="hidden" id="loadImgErrorMsg" class="form-control" value="@lang('generic.ERROR_LOAD_IMG')">

                    {{-- Default image is the professional's current image --}}
                    <input type="hidden" id="loadImgDefault" class="form-control"
                        @isset($pro_entry->avatar)
                                value="{{ asset('user_uploads/avatars/' . $pro_entry->avatar) }}"
                            @else
                                value="{{ asset('user_uploads/avatars/avt_default.jpg' ) }}"
                            @endif
                        >

                    <input name="avatar_file" id="avatar_file" onchange="selectImage('avatar_file', 'img_avatar', $('#loadImgErrorMsg').val(), $('#loadImgDefault').val())" type="file" accept="image/png, image/jpeg, image/jpg" style="display:none"/>

                    <label for="avatar_file" style="cursor: pointer;">
                        <img id='img_avatar' class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover; margin-left: auto; margin-right: auto;"
                            @isset($pro_entry->avatar)
                                src="{{ asset('user_uploads/avatars/' . $pro_entry->avatar ) }}"
                            @else
                                src="{{ asset('user_uploads/avatars/avt_default.jpg' ) }}"
                            @endif
                        >
                    </label>

                </div>
            </div>

            <div class="row justify-content-center">

                <div class="col-4 px-1">
                    <button type="button" style="width: 100%; height: auto;" class="btn btn-sm vbtn-support" onClick="cancelImgSelection('avatar_file', 'img_avatar', $('#loadImgDefault').val())">
                        <i class="fas fa-undo-alt"></i>
                    </button>
                </div>
                <div class="col-4 px-1">
                    <label for="avatar_file" style="width: 100%; height: auto;" class='btn btn-sm vbtn-main' style="min-width:30%; cursor: pointer">
                        <i class="fas fa-user-edit"></i>
                    </label>
                </div>
            </div>

        </div>
        <div class="col-12 text-center
                    col-md text-md-left pl-md-0
                    col-vcenter">

            @if ($errors->has('avatar_file'))
                <span class="invalid-feedback d-block mb-2" role="alert"><strong>{{ $errors->first('avatar_file') }}</strong></span>
            @endif

            {{-- Full Name --}}
            <input name="full_name" class="form-control form-control-lg {{ $errors->has('full_name') ? ' is-invalid' : '' }}" type="text" maxlength="80" placeholder="@lang('record_pro.FULL_NAME_PH')"
                @if(old('full_name') !== null)
                    value="{{ old('full_name') }}"
                @elseif(isset($pro_entry->full_name))
                    value="{{ $pro_entry->full_name }}"
                @endif
            >

            @if ($errors->has('full_name'))
                <span class="invalid-feedback d-block text-left ml-1 mt-0 mb-1" role="alert"><strong>{{ $errors->first('full_name') }}</strong></span>
            @endif
            {{-- Full Name --}}


            {{-- Role --}}
            <div class="form-group mt-2 mb-0">
                <select name="type" class="form-control {{ $errors->has('type') ? ' is-invalid' : '' }}">
                    <option invalid hidden @if(!isset($pro_entry->type)) selected @endif >@lang('record_pro.ROLE_PH')</option>
                    <option value="researcher" @if( isset($pro_entry->type) && $pro_entry->type == App\Models\Users\User::RESEARCHER || (old('type') !== null && old('type') == 'researcher') ) selected @endif >{{ ucwords(trans('generic.RESEARCHER')) }}</option>
                    <option value="doctor" @if( isset($pro_entry->type) && $pro_entry->type == App\Models\Users\User::DOCTOR || (old('type') !== null && old('type') == 'doctor') ) selected @endif >{{ ucwords(trans('generic.DOCTOR')) }}</option>
                    <option value="caregiver" @if( isset($pro_entry->type) && $pro_entry->type == App\Models\Users\User::CAREGIVER || (old('type') !== null && old('type') == 'caregiver') ) selected @endif >{{ ucwords(trans('generic.CAREGIVER')) }}</option>
                </select>

                @if ($errors->has('type'))
                    <span class="invalid-feedback d-block text-left ml-1 mt-0" role="alert"><strong>{{ $errors->first('type') }}</strong></span>
                @endif
            </div>
            {{-- Role --}}

        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <h6 class="h6 text-uppercase font-weight-bold mb-0">@lang('record_pro.ACCOUNT_INFO_TITLE')</h6>
            <hr class="mt-1">
        </div>

        {{-- Username --}}
        <div class="col-12">
            <h6 class="h6 font-weight-light">@lang('record_pro.USERNAME')</h6>
        </div>
        <div class="col-12">
            @isset($pro_entry->username)
                <h6 class="h6">{{ $pro_entry->username }}</h6>
            @else
                <input name="name" value="{{ old('name') }}" class="form-control form-control-sm {{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" maxlength="80" placeholder="@lang('record_pro.USERNAME_PH')">
            @endif

            @if ($errors->has('name'))
                <span class="invalid-feedback d-block text-left ml-1 mt-0 mb-1" role="alert"><strong>{{ $errors->first('name') }}</strong></span>
            @endif
        </div>
        {{-- Username --}}


        {{-- Email --}}
        <div class="col-12 mt-3">
            <h6 class="h6 font-weight-light">@lang('record_pro.EMAIL')</h6>
        </div>
        <div class="col-12">
            <input name="email" type="email" class="form-control form-control-sm {{ $errors->has('email') ? ' is-invalid' : '' }}" maxlength="80" placeholder="@lang('record_pro.EMAIL_PH')"
                @if(old('email') !== null)
                    value="{{ old('email') }}"
                @elseif(isset($pro_entry->email))
                    value="{{ $pro_entry->email }}"
                @endif
            >

            @if ($errors->has('email'))
                <span class="invalid-feedback d-block text-left ml-1 mt-0 mb-1" role="alert"><strong>{{ $errors->first('email') }}</strong></span>
            @endif
        </div>
        {{-- Email --}}
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <h6 class="h6 text-uppercase font-weight-bold mb-0">@lang('record_pro.PRO_INFO_TITLE')</h6>
            <hr class="mt-1">
        </div>

        {{-- Phone --}}
        <div class="col-12">
            <h6 class="h6 font-weight-light">@lang('record_pro.PHONE')</h6>
        </div>

        <div class="col-12">
            <input name="phone" type="text" class="form-control form-control-sm {{ $errors->has('phone') ? ' is-invalid' : '' }}" maxlength="30" placeholder="@lang('record_pro.PHONE_PH')"
                @if(old('phone') !== null)
                    value="{{ old('phone') }}"
                @elseif(isset($pro_entry->phone))
                    value="{{ $pro_entry->phone }}"
                @endif
            >

            @if ($errors->has('phone'))
                <span class="invalid-feedback d-block text-left ml-1 mt-0 mb-1" role="alert"><strong>{{ $errors->first('phone') }}</strong></span>
            @endif
        </div>
        {{-- Phone --}}


        {{-- Address --}}
        <div class="col-12 mt-3">
            <h6 class="h6 font-weight-light">@lang('record_pro.ADDRESS')</h6>
        </div>

        <div class="col-12">
            <input name="address" type="text" class="form-control form-control-sm {{ $errors->has('address') ? ' is-invalid' : '' }}" maxlength="160" placeholder="@lang('record_pro.ADDRESS_PH')"
                @if(old('address') !== null)
                    value="{{ old('address') }}"
                @elseif(isset($pro_entry->address))
                    value="{{ $pro_entry->address }}"
                @endif
            >

            @if ($errors->has('address'))
                <span class="invalid-feedback d-block text-left ml-1 mt-0 mb-1" role="alert"><strong>{{ $errors->first('address') }}</strong></span>
            @endif
        </div>
        {{-- Address --}}
    </div>

    <div class="row mt-3">
        <div class="col-12 text-center text-sm-right">

            @isset($extraBtns)
                {!! $extraBtns !!} {{-- Extra buttons may be added to this form --}}
            @endif

            <button type="submit" class="btn btn-sm vbtn-main"><i class="fas fa-save"></i> @lang('record_pro.BTN_SAVE')</button>
        </div>
    </div>
</form>

@section('js')
    @parent
    <script type="text/javascript" src="{{ asset('js/image_selector.js') }}"></script>
@endsection