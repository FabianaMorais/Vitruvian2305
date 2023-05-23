@extends('base.page_public')

@section('content')
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="h1 vpg-title">@lang('pgs_public.TEAM_TTL')</h1>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 text-center order-2
                    col-sm-10
                    col-md-6 text-md-left order-md-1
                    col-lg-5
                    col-xl-4
                    col-vcenter">
            <h4 class="h4 vpg-desc">@lang('pgs_public.TEAM_INTRO')</h4>
        </div>
        <div class="col-10 order-1 mb-5
                    col-sm-8
                    col-md-6 order-md-2
                    col-lg-5
                    col-xl-4
                    col-vcenter">
            <img class="d-block mx-auto" style="width: 80%; height: auto;" src="{{ asset('images/team/team_illustration.svg')}}"> 
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12 text-center
                    col-sm-10 offset-sm-1">
            <h3 class="h3 vpg-subtitle">
                @lang('pgs_public.BOARD_TTL')
            </h3>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-auto my-3">
            @component('public_pages.components.team_member_card')
                @slot('img_src') {{ asset('images/team/Paulo.jpg') }} @endslot
                @slot('title') Paulo Martins @endslot
                @slot('text') Management, sales, marketing, design, R&D @endslot
                @slot('text_b') Founder and CEO<br><a class="vtxt-link" href="https://www.linkedin.com/in/vitruvianshield" target="_blank">Linked-in</a> @endslot
            @endcomponent
        </div>
        <div class="col-auto my-3">
            @component('public_pages.components.team_member_card')
                @slot('img_src') {{ asset('images/team/Bruno.jpg') }} @endslot
                @slot('title') Bruno Carrilho @endslot
                @slot('text_b') General Manager<br>Vitruvian Shield - PT<br><a class="vtxt-link" href="https://www.linkedin.com/in/bruno-carrilho-9a398926b/" target="_blank">Linked-in</a> @endslot
            @endcomponent
        </div>
        <div class="col-auto my-3">
            @component('public_pages.components.team_member_card')
                @slot('img_src') {{ asset('images/team/Pascal.jpg') }} @endslot
                @slot('title') Pascal Gilomen @endslot
                @slot('text') Comptable chez Gilomen fiscalité conseils SA @endslot
                @slot('text_b') CFO<br><a class="vtxt-link" href="https://www.linkedin.com/in/pascal-gilomen-524931b3/" target="_blank">Linked-in</a> @endslot
            @endcomponent
        </div>
        <div class="col-auto my-3">
            @component('public_pages.components.team_member_card')
                @slot('img_src') {{ asset('images/team/Sebastien.jpg') }} @endslot
                @slot('title') Sébastien Guarnay @endslot
                @slot('text') Data scientist for medical applications<br>PhD in Physics<br>Double MSc in Electrical Engineering and Information Technology @endslot
                @slot('text_b') Medical Data Scientist<br><a class="vtxt-link" href="https://www.linkedin.com/in/sebastien-guarnay" target="_blank">Linked-in</a> @endslot
            @endcomponent
        </div>
        <div class="col-auto my-3">
            @component('public_pages.components.team_member_card')
                @slot('img_src') {{ asset('images/team/Patrick.jpg') }} @endslot
                @slot('title') Patrick Casteau @endslot
                @slot('text') Sports Business Consultant with expertise in business development, stakeholders relations and project/event management<br>Entrepreneur in the Sports, Education, Tech and Health industries @endslot
                @slot('text_b')Head of Sports Division<br><a class="vtxt-link" href="https://www.linkedin.com/in/patrick-casteau/" target="_blank">Linked-in</a> @endslot
            @endcomponent
        </div>

    </div>

    <div class="row mt-3">
        <div class="col-12 text-center
                    col-sm-10 offset-sm-1">
            <h3 class="h3 vpg-subtitle">
                @lang('pgs_public.DEVS_TTL')
            </h3>
        </div>
    </div>
    <div class="row justify-content-center"> {{-- mx-lg-5 & px-lg-5 to look better in lg. Change this is when changing the number of team elements --}}
        <div class="col-auto my-3">
            @component('public_pages.components.team_member_card')
                @slot('img_src') {{ asset('images/team/Sohrab.jpg') }} @endslot
                @slot('title') Sohrab Saberi Moghadam @endslot
                @slot('text') PHD Expertise in neuroscience and cardiovascular wearable medical devices Software tests for RPM solutions Algorithm design, ML and AI for R&D solutions @endslot
                @slot('text_b') Bio-medical Engineer <br>Data scientist<br><a class="vtxt-link" href="https://www.linkedin.com/in/dr-sohrab-saberi-2471a632/" target="_blank">Linked-in</a> @endslot
            @endcomponent
        </div>
        <div class="col-auto my-3">
            @component('public_pages.components.team_member_card')
                @slot('img_src') {{ asset('images/team/Vahid.jpg') }} @endslot
                @slot('title') Vahid Khazaei Nezhad @endslot
                @slot('text') MSc in Software engineering<br>Data Scientist and Software Analyzer and Designer, Software Architecture and Database Designer @endslot
                @slot('text_b') CTO <br><a class="vtxt-link" href="https://www.linkedin.com/in/vahid-khazaei-nezhad-a4074595/" target="_blank">Linked-in</a> @endslot
            @endcomponent
        </div>
        <div class="col-auto my-3">
            @component('public_pages.components.team_member_card')
                @slot('img_src') {{ asset('images/team/Ana.jpg') }} @endslot
                @slot('title') Ana Rita Silva Lopes @endslot
                @slot('text') Msc in Sports<br>Web Developer<br>Cyber Security Fundamentals @endslot
                @slot('text_b') Software Developer<br>DevOps<br><a class="vtxt-link" href="https://www.linkedin.com/in/ana-rita-silva-lopes/" target="_blank">Linked-in</a> @endslot
            @endcomponent
        </div>
        <div class="col-auto my-3">
            @component('public_pages.components.team_member_card')
                @slot('img_src') {{ asset('images/team/Fabiana.jpg') }} @endslot
                @slot('title') Fabiana Rodrigues @endslot
                @slot('text') MSc in Biomedical Engineering @endslot
                @slot('text_b') Full Stack Developer<br><a class="vtxt-link" href="https://www.linkedin.com/in/fabiana-morais-1207b730/" target="_blank">Linked-in</a> @endslot
            @endcomponent
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12 text-center
                    col-sm-10 offset-sm-1">
            <h3 class="h3 vpg-subtitle">
                @lang('pgs_public.ADVISORS_TTL')
            </h3>
        </div>
        <div class="col-12
                    col-sm-10 offset-sm-1 text-center mt-2">
            <h6 class="h6">
                @lang('pgs_public.TEAM_CHUV_INTRO')
            </h6>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-auto my-3">
            @component('public_pages.components.team_member_card')
                @slot('img_src') {{ asset('images/team/Philippe.jpg') }} @endslot
                @slot('title') Prof. Philippe Ryvlin @endslot
                @slot('text') Head of the Department of Clinical Neurosciences - CHUV @endslot
                @slot('text_b') Medical Adviser for Vitruvian Shield clinical trials and gold standard validation<br><a class="vtxt-link" href="https://www.linkedin.com/in/philippe-ryvlin-20166417b/" target="_blank">Linked-in</a> @endslot
            @endcomponent
        </div>
        <div class="col-auto my-3">
            @component('public_pages.components.team_member_card')
                @slot('img_src') {{ asset('images/team/Ilona.jpg') }} @endslot
                @slot('title') Dr. Ilona Wisniewsk @endslot
                @slot('text') CHUV Research Manager<br>Clinical Scientist<br>Neuropsychologist<br>Foundation Manager @endslot
                @slot('text_b') Project Chief<br><a class="vtxt-link" href="https://www.linkedin.com/in/dr-ilona-wisniewski-hubbard-221666a0/" target="_blank">Linked-in</a> @endslot
            @endcomponent
        </div> 
        <div class="col-auto my-3">
            @component('public_pages.components.team_member_card')
                @slot('img_src') {{ asset('images/team/Vincent.jpg') }} @endslot
                @slot('title') Dr.Vincent Greek @endslot
                @slot('text') Medical Doctor - Internist<br>eMBA Data Scientist<br>Digital Health Transformer @endslot
                @slot('text_b') Clinical Advisor<br><a class="vtxt-link" href="https://www.linkedin.com/in/vincentgrek/" target="_blank">Linked-in</a> @endslot
            @endcomponent
        </div>
        <div class="col-auto my-3">
            @component('public_pages.components.team_member_card')
                @slot('img_src') {{ asset('images/team/Marco.jpg') }} @endslot
                @slot('title') Dr. Marco Ruëdi, MD, eMBA, eMMM @endslot
                @slot('text') Entrepreneur, Coach and Trainer in the Swiss Start-up ecosystem<br>Translational medicine @endslot
                @slot('text_b') Innosuisse Start up Coach<br><a class="vtxt-link" href="https://www.linkedin.com/in/marcoruedi/" target="_blank">Linked-in</a> @endslot
            @endcomponent
        </div>
        <div class="col-auto my-3">
            @component('public_pages.components.team_member_card')
                @slot('img_src') {{ asset('images/team/Frederic.jpg') }} @endslot
                @slot('title')Frederic Briguet @endslot
                @slot('text') Commercial strategy, Business development and Product marketing @endslot
                @slot('text_b')Marketing Advisor<br><a class="vtxt-link" href="https://www.linkedin.com/in/fredbriguet/" target="_blank">Linked-in</a> @endslot
            @endcomponent
        </div>
        
    </div>

@endsection
