@foreach($attributes as $key=>$value)
    <div class="row py-2">
        <div class="col-12 col-md-4">
            <h6 class="h6">{{$key}}</h6>
            
        </div>
        <div class="col-12 col-md-8  pl-2 ml-2 pl-md-0 ml-md-0">
            {{$value}}
        </div>
    </div>
    @if(!$loop->last)
        <hr class="my-2">
    @endif
    
@endforeach