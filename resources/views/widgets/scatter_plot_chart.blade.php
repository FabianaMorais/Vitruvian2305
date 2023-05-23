{{-- 
    Currently set for 1 dataset
    params:
        chart_title (mandatory) _> title to be displayed on chart
        canvas_id (mandatory) -> element id for canvas to draw chart in

    --}}

<div class="row">
    <div class="col-11 offset-1 text-left">
        <h4 class="h6 vtext-dark font-weight-bold chart-title">{{$chart_title}}</h4>
    </div>
    <div class="col-12">
        <div id="{{$canvas_id}}_container" class="row">
            <div class="col-12">
                <canvas id="{{$canvas_id}}"></canvas>
            </div>
            <div class="col-5 offset-2 text-left x-axis-ts-label pt-2">
                <span id="{{$canvas_id}}_label_1"></span>
            </div>
            <div class="col-5 text-right x-axis-ts-label pt-2">
                <span id="{{$canvas_id}}_label_2"></span>
            </div>
        </div>
    </div>
</div>
