<div class=@if(isset($edit)) "row edit-med-row-entry" @else "row med-row-entry" @endif>

    <div class="col-12 col-md-6 text-left">
        {{-- number of pills in the taking--}}
        <label for=@if(isset($edit)) "edit_med_taking_amount" @else "med_taking_amount" @endif> @lang('pg_professionals.AMOUNT_TO_TAKE_LBL')</label>
        <input type="number" min="0" value="0" class="form-control " name=@if(isset($edit)) "edit_med_taking_amount" @else "med_taking_amount" @endif id=@if(isset($edit)) "edit_med_taking_amount" @else "med_taking_amount" @endif >
    </div>
    <div class="col-12 col-md-6 text-left">
        {{-- time for first taking--}}
        <div class="row">
            <div class="col-6">
            
                <label for=@if(isset($edit)) "edit_med_taking_hours" @else "med_taking_hours" @endif> @lang('pg_professionals.HOURS_TO_TAKE_LBL')</label>
                <input type="number" min="0" val="0" max="23" class="form-control " name=@if(isset($edit)) "edit_med_taking_hours" @else "med_taking_hours" @endif id=@if(isset($edit)) "edit_med_taking_hours" @else "med_taking_hours" @endif >  
            </div>
            <div class="col-6">
            
                <label for=@if(isset($edit)) "edit_med_taking_mins" @else "med_taking_mins" @endif> @lang('pg_professionals.MINS_TO_TAKE_LBL')</label>
                <input type="number" min="0" val="0" max="23" class="form-control " name=@if(isset($edit)) "edit_med_taking_mins" @else "med_taking_mins" @endif id=@if(isset($edit)) "edit_med_taking_mins" @else "med_taking_mins" @endif >  
            </div>
        </div>
    </div>
</div>