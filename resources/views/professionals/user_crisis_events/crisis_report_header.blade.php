<div class="row mt-2 align-items-end">
    <div class="col-12 ">
        <div class="row">
            <div class="col-12">
                <span class="font-weight-bold">Type: </span><span class="font-weight-lighter">{{$name}}</span><br/>
            </div>
            <div class="col-12">
                <span class="font-weight-bold">Date: </span><span class="font-weight-lighter">{{$datetime}}</span><br/>
            </div>
            <div class="col-12">
                <span class="font-weight-bold">Duration: </span><span class="font-weight-lighter">{{$duration}} s</span>
            </div>
            <div class="col-12">
                <span class="font-weight-bold">Submitted by: </span><span class="font-weight-lighter">@if($submitted_by_doctor == 'true') Professional @else Patient @endif</span>
            </div>
        </div>
    </div>
</div>