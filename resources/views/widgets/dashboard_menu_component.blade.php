{{--
    Component for dashboard menu buttons
    Parameters:
        link - optional, adds an href to that route
        fa_icon - optional (to allow buttons with no icon), fontawesome icon name (i.e. fa-user-plus)
        text - mandatory, text to display below the icon 
        color - mandatory, color of the text and icon to display
--}}
 
@if(isset($link))
    <a href="{{$link}}" style="text-decoration: none;" class="dashboard-icon-content">
@endif
<div class="container">
    <div class="row">
        <div class="col-12 px-0 mx-0 dashboard-button-topbar-{{$card_number}}" style="height:8px;"></div>
        <div class="col-12 dashboard-button-container col-vcenter">
            @if(isset($fa_icon))
                <div class="row mb-2">
                    <div class="col-12 text-center">
                        <i class="fas {{$fa_icon}} col-vcenter vicon-main" style="font-size:3em;"></i>
                    </div>
                </div>
            @endif
            <div class="row mt-2">
                <div class="col-12 text-center">
                    <h4 class="h4" style="font-weight: bold;">{{$text_a}}</h4>
                </div>
                <div class="col-12 text-center">
                    <h4 class="h6 dashboard-description-text">{{$text_b}}</h6>
                </div>
            </div>
        </div>
    </div>
</div>
@if(isset($link))
    </a>
@endif