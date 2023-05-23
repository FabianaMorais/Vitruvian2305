<script type="text/javascript" src="{{ asset('js/recaptcha.js') }}"></script>
<script>window.onload = setRecaptcha;</script>
<form action="{{ route('contact form submit') }}" data-grecaptcha-action="contactformsubmit" method="POST">
    @csrf
    <div class="form-group mb-0">
        <div class="row">
            {{--Name--}}
            <div class="col-12 text-left">
                <label for="sender_name">@lang('pg_welcome.CONTACT_FORM_NAME_LBL')</label>
                <input type="text" class="form-control {{ $errors->has('sender_name') ? 'is-invalid' : '' }}" name="sender_name" id="sender_name" value="{{ old('sender_name') }}">
                @if($errors->has('sender_name')) 
                    <div class="invalid-feedback"> 
                {{ $errors->first('sender_name') }} 
                    </div> 
                @endif
            </div>
            {{--Subject--}}
            <div class="col-12 text-left mt-2 ">
                <label for="subject">@lang('pg_welcome.CONTACT_FORM_SUBJECT_LBL')</label>
                <input type="text" class="form-control {{ $errors->has('subject') ? 'is-invalid' : '' }}" name="subject" id="subject" value="{{ old('subject') }}">
                @if($errors->has('subject')) 
                    <div class="invalid-feedback"> 
                {{ $errors->first('subject') }} 
                    </div> 
                @endif
            </div>
            {{--Message--}}
            <div class="col-12 text-left mt-2 mb-2">
                <label for="message">@lang('pg_welcome.CONTACT_FORM_MESSAGE_LBL')</label>
                <textarea type="text" class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}" cols="50" rows="5" name="message" id="message" value="{{ old('message') }}" style="resize: none;"> </textarea>
                @if($errors->has('message')) 
                    <div class="invalid-feedback"> 
                {{ $errors->first('message') }} 
                    </div> 
                @endif
            </div>
            {{--Email (optional)--}}
            <div class="col-12 text-left">
                <label for="sender_email">@lang('pg_welcome.CONTACT_FORM_EMAIL_LBL')</label>
                <input type="text" class="form-control {{ $errors->has('sender_email') ? 'is-invalid' : '' }}" name="sender_email" id="sender_email" value="{{ old('sender_email') }}">
                @if($errors->has('sender_email')) 
                    <div class="invalid-feedback"> 
                {{ $errors->first('sender_email') }} 
                    </div> 
                @endif
            </div>
            {{--Phone Number (optional) --}}
            <div class="col-12 text-left mt-2 mb-2">
                <label for="sender_phone_number">@lang('pg_welcome.CONTACT_FORM_PHONE_NUMBER_LBL')</label>
                <input type="text" class="form-control {{ $errors->has('sender_phone_number') ? 'is-invalid' : '' }}" name="sender_phone_number" id="sender_phone_number" value="{{ old('sender_phone_number') }}">
                @if($errors->has('sender_phone_number')) 
                    <div class="invalid-feedback"> 
                {{ $errors->first('sender_phone_number') }} 
                    </div> 
                @endif
            </div>
            
        </div>
        <div class="text-danger">
            @error('grecaptcha')
                <span>@lang('pg_welcome.RECAPTCHA_NOT_VERIFIED')</span>
            @enderror
        </div>
        <div class="row py-2">
            <div class="col-12 text-center">
                <button type="submit" class="btn vbtn-main mt-2">@lang('pg_welcome.CONTACT_FORM_SUBMIT_BUTTON')</button>
            </div>
        </div>
    </div>
</form>