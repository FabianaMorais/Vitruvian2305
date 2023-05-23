@extends('base.page_app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            {{-- patients dashboard buttons --}}
            @if(in_array(App\Models\Permissions::VIEW_PATIENTS_PERMISSION, $permissions) || in_array(App\Models\Permissions::ADD_PATIENTS_PERMISSION, $permissions || in_array(App\Models\Permissions::RECOVER_PATIENT_PASSWORD_PERMISSION, $permissions)))
                <div class="col-12 mb-4">
                    <div class="row">
                        <div class="col-12 text-left">
                            <h4 class="h4 {{$color}}">Patients</h4>
                        </div>
                    </div>
                    <div class="row">
                        @if(in_array(App\Models\Permissions::VIEW_PATIENTS_PERMISSION, $permissions))
                            <div class="col-12 col-md-6 col-lg-3">
                                @component('widgets.dashboard_menu_component')
                                    @slot('link') {{ route('list patients') }} @endslot
                                    @slot('fa_icon') fa-users @endslot
                                    @slot('text_a') @lang('pg_professionals.LIST_PATIENTS_TTL') @endslot
                                    @slot('text_b') @lang('pg_professionals.LIST_PATIENTS_DESC') @endslot
                                    @slot('card_number') 1 @endslot
                                @endcomponent
                            </div>
                        @endif
                        
                        @if(in_array(App\Models\Permissions::ADD_PATIENTS_PERMISSION, $permissions))
                            <div class="col-12 col-md-6 col-lg-3 mt-2 mt-md-0">
                                @component('widgets.dashboard_menu_component')
                                    @slot('link') {{ route('patients.new.form') }} @endslot
                                    @slot('fa_icon') fa-user-plus add-user-offset-fix @endslot
                                    @slot('text_a') @lang('pg_professionals.ADD_PATIENT_TTL') @endslot
                                    @slot('text_b') @lang('pg_professionals.ADD_PATIENT_DESC') @endslot
                                    @slot('card_number') 2 @endslot
                                @endcomponent
                            </div>
                        @endif
                        
                        @if(in_array(App\Models\Permissions::RECOVER_PATIENT_PASSWORD_PERMISSION, $permissions))
                            <div class="col-12 col-md-6 col-lg-3 mt-2 mt-md-4 mt-lg-0">
                                @component('widgets.dashboard_menu_component')
                                    @slot('link') {{ route('recover patient password form') }} @endslot
                                    @slot('fa_icon') fa-users @endslot
                                    @slot('text_a') @lang('pg_professionals.RECOVER_PASSWORD_TTL') @endslot
                                    @slot('text_b') @lang('pg_professionals.RECOVER_PASSWORD_DESC') @endslot
                                    @slot('card_number') 3 @endslot
                                @endcomponent
                            </div>
                        @endif
                        
                    </div>
                </div>
            @endif
            {{-- teams dashboard buttons --}}
            @if(in_array(App\Models\Permissions::VIEW_TEAMS_PERMISSION, $permissions) || in_array(App\Models\Permissions::ADD_TEAMS_PERMISSION, $permissions ))
                <div class="col-12 mb-4">
                    <div class="row">
                        <div class="col-12 text-left">
                            <h4 class="h4 {{$color}}">Teams</h4>
                        </div>
                    </div>
                    <div class="row">
                        @if(in_array(App\Models\Permissions::VIEW_TEAMS_PERMISSION, $permissions))
                            <div class="col-12 col-md-6 col-lg-3">
                                @component('widgets.dashboard_menu_component')
                                    @slot('link') {{ route('list patients') }} @endslot
                                    @slot('fa_icon') fa-users @endslot
                                    @slot('text_a') @lang('pg_professionals.LIST_TEAMS_TTL') @endslot
                                    @slot('text_b') @lang('pg_professionals.LIST_TEAMS_DESC') @endslot
                                    @slot('card_number') 1 @endslot
                                @endcomponent
                            </div>
                        @endif
                        
                        @if(in_array(App\Models\Permissions::ADD_TEAMS_PERMISSION, $permissions))
                            <div class="col-12 col-md-6 col-lg-3 mt-2 mt-md-0">
                                @component('widgets.dashboard_menu_component')
                                    @slot('link') {{ route('patients.new.form') }} @endslot
                                    @slot('fa_icon') fa-user-plus add-user-offset-fix @endslot
                                    @slot('text_a') @lang('pg_professionals.ADD_TEAM_TTL') @endslot
                                    @slot('text_b') @lang('pg_professionals.ADD_TEAM_DESC') @endslot
                                    @slot('card_number') 2 @endslot
                                @endcomponent
                            </div>
                        @endif
                        
                    </div>
                </div>
            @endif
            {{-- Research tools dashboard buttons --}}
            @if(in_array(App\Models\Permissions::DOWNLOAD_DATA_PERMISSION, $permissions))
                <div class="col-12 mb-4">
                    <div class="row">
                        <div class="col-12 text-left">
                            <h4 class="h4 {{$color}}">Research</h4>
                        </div>
                    </div>
                    <div class="row">
                        @if(in_array(App\Models\Permissions::DOWNLOAD_DATA_PERMISSION, $permissions))
                            <div class="col-12 col-md-6 col-lg-3">
                                @component('widgets.dashboard_menu_component')
                                    @slot('link') {{ route('download csv data options view') }} @endslot
                                    @slot('fa_icon') fa-file-download @endslot
                                    @slot('text_a') @lang('pg_professionals.DOWNLOAD_DATA_TTL') @endslot
                                    @slot('text_b') @lang('pg_professionals.DOWNLOAD_DATA_DESC') @endslot
                                    @slot('card_number') 4 @endslot
                                @endcomponent
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
