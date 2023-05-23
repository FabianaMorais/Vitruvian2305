{{-- Team card
By: Luís Henriques on 04/03/200

Slots:
    img_src
    title
 --}}

<div class="card vstyle-main" style="width:180px; height: 100%; ">
    <div class="card-header vstyle-light">
        <div class="row">
            <div class="col-12 col-vcenter" style="height: 110px;">
                <img class="mx-auto my-5 mt-3" style="width:110px;" src="{{$img_src}}">
            </div>
        </div>
    </div>
    <div class="card-body text-center">
        <h5 class="card-title">{!! $title !!}</h5>
    </div>
</div>