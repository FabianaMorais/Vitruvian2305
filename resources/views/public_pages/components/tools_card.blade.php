{{--
    Slots:
        @slot('align_text') left @endslot // Aligns text to the left and cards to the right

        // Left card
        @slot('card_l_img') {{ asset('images/product/vit_watch_round.png') }} @endslot
        @slot('card_l_title') card l title @endslot
        @slot('card_l_text') card l text  ajshgfjas hkgjhasgfjhas g gafgfasghjfgh jkafghkjfasghjk afs ghkjfasghkafs @endslot
        @slot('card_l_btn_text') Explore @endslot
        @slot('card_l_btn_link') # @endslot

        // Right card
        @slot('card_r_style') vtool-card-B @endslot
        @slot('card_r_img') {{ asset('images/product/vit_mobile_app.png') }} @endslot
        @slot('card_r_title') Card R title @endslot
        @slot('card_r_text') card r text asf asfasfsa fsafasfsas fsf asf a @endslot
        @slot('card_r_btn_text') Explore @endslot
        @slot('card_r_btn_link') # @endslot

        // Main text
        @slot('card_desc_title') Test Title @endslot // Supports span elements to change text style
        @slot('card_desc_text') Test desc @endslot
--}}
<div class="vtools-card-canvas my-5">
    <div class="row">

        <div class="col-12 mb-4 order-1 text-center
                    col-xl mb-xl-0 text-xl-left @if(!isset($aling_text) || !$aling_text != 'left') order-xl-2 @else order-xl-1 @endif">
            <div class="vtools-description align-text-bottom">
                <h2>{{ $card_desc_title }}</h2>
                <p>{{ $card_desc_text }}</p>
            </div>
        </div>


        <div class="col-12 order-2
                    col-xl-auto @if(!isset($align_text) || $align_text != 'left') order-xl-1 @else order-xl-2 @endif">

            <div class="row justify-content-center">
                <div class="col-12 my-4
                            col-sm-auto
                            my-lg-0">
                        <div class="vsingle-tool-card mx-auto @if(isset($card_l_style)) {{ $card_l_style }} @endif">
                        <div class="vsingle-tool-img">
                            <img src="{{ $card_l_img }}">
                        </div>
                        <div class="vsingle-tool-txt">
                            <h3>{{ $card_l_title }}</h3>
                            <p>{{ $card_l_text }}</p>
                        </div>
                        <a href="{{ $card_l_btn_link }}" class="vview-tool-btn">{{ $card_l_btn_text }}</a>
                    </div>
                </div>

                <div class="col-12 my-4
                            col-sm-auto
                            my-lg-0">
                    <div class="vsingle-tool-card mx-auto @if(isset($card_r_style)) {{ $card_r_style }} @endif">
                        <div class="vsingle-tool-img">
                            <img src="{{ $card_r_img }}">
                        </div>
                        <div class="vsingle-tool-txt">
                            <h3>{{ $card_r_title }}</h3>
                            <p>{{ $card_r_text }}</p>
                        </div>
                        <a href="{{ $card_r_btn_link }}" class="vview-tool-btn">{{ $card_r_btn_text }}</a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>