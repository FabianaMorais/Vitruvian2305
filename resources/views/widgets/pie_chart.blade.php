{{-- similar to scatter plot but with up to 5 color legends, 3 mandatory + 2 optional --}}
<div class="row">
    <div class="col-12 text-center mb-4">
        <h4 class="h4 font-weight-bold" style="font-size:15pt;line-height:1;">{{$chart_title}}</h4>
    </div>
    <div class="col-12 mb-4">
        <canvas id="{{$canvas_id}}"></canvas>
    </div>
</div>
<div class="row justify-content-center">
    {{-- legend 1 --}}
    <div class="col-6 col-lg-4 col-vcenter">
        <div class="row justify-content-center">
            <div class="col-auto col-vcenter px-2">
                <div id="{{$legend_1_id}}" class="legend-box-container">
                </div>
            </div>
            <div class="col-auto col-vcenter text-left pl-0">
                <span class="chart-legend-label">{{$legend_1_text}}</span>
            </div>
        </div>
    </div>
    {{-- legend 2 --}}
    <div class="col-6 col-lg-4 col-vcenter">
        <div class="row justify-content-center">
            <div class="col-auto col-vcenter px-2">
                <div id="{{$legend_2_id}}" class="legend-box-container">
                </div>
            </div>
            <div class="col-auto col-vcenter text-left pl-0">
                <span class="chart-legend-label">{{$legend_2_text}}</span>
            </div>
        </div>
    </div>
    {{-- legend 3 --}}
    <div class="col-6 col-lg-4 col-vcenter">
        <div class="row justify-content-center">
            <div class="col-auto col-vcenter px-2">
                <div id="{{$legend_3_id}}" class="legend-box-container">
                </div>
            </div>
            <div class="col-auto col-vcenter text-left pl-0">
                <span class="chart-legend-label">{{$legend_3_text}}</span>
            </div>
        </div>
    </div>
    {{-- legend 4 --}}
    @if(isset($legend_4_id))
        <div class="col-6 col-lg-4 col-vcenter">
            <div class="row justify-content-center">
                <div class="col-auto col-vcenter px-2">
                    <div id="{{$legend_4_id}}" class="legend-box-container">
                    </div>
                </div>
                <div class="col-auto col-vcenter text-left pl-0">
                    <span class="chart-legend-label">{{$legend_4_text}}</span>
                </div>
            </div>
        </div>
    @endif
    {{-- legend 5 --}}
    @if(isset($legend_5_id))
        <div class="col-6 col-lg-4 col-vcenter">
            <div class="row justify-content-center">
                <div class="col-auto col-vcenter px-2">
                    <div id="{{$legend_5_id}}" class="legend-box-container">
                    </div>
                </div>
                <div class="col-auto col-vcenter text-left pl-0">
                    <span class="chart-legend-label">{{$legend_5_text}}</span>
                </div>
            </div>
        </div>
    @endif
</div>