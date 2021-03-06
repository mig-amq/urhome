<nav class="navbar navbar-expand-md navbar-dark fixed-top" id="nav">
    <a class="navbar-brand" href="/">
        <img src="{{ asset('img/icons/logo.svg') }}" alt=""> 
        <span><b>urhome</b></span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav">
            <li class="nav-item {{Request::segment(1) == '' ? 'active' : ''}}">
                <a class="nav-link" href="/">Home</a>
            </li>
            <li class="nav-item dropdown {{Request::segment(1) == 'properties' ? 'active' : ''}}">
                <a href="/properties" class="nav-link">Properties</a>
            </li>
            <li class="nav-item dropdown {{Request::segment(1) == 'contact' ? 'active' : ''}}">
                    <a href="/contact" class="nav-link">Contact Us</a>
                </li>
            
        </ul>
        <ul class="navbar-nav"> 
            <li class="nav-item dropdown">
                
                <a href="#" class="nav-link dropdown-toggle {{Request::segment(1) == 'account' ? 'active' : ''}}" id="accountDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @if(Auth::check())
                        <img src="{{Auth::user()->ProfileImage}}" class="img-thumbnail rounded-circle"/>
                        <span>
                            {{ Auth::user()->FirstName . ' ' . Auth::user()->LastName }}
                        </span>
                    @else
                        <i class="far right fa-user-circle"></i>
                        Account
                    @endif
                </a>
                <div class="dropdown-menu" aria-labelledby="accountDropdown">
                    @if(Auth::check())
                        <a href="/users" class="dropdown-item">Profile</a>
                        @if(Auth::user()->user_type->id == 2 && Auth::user()->Status == 1)
                            {{-- broker --}}
                            @if (Auth::user()->broker_information->can(App\Feature::UPLOAD))
                                <a href="/properties/post" class="dropdown-item">Post a Listing</a>
                            @endif
                            @if (Auth::user()->broker_information->can(App\Feature::REPORT))
                                <a href="/users/reports" class="dropdown-item">Generate Reports</a>
                            @endif
                        @endif
                        @if(Auth::user()->user_type->id == 3) 
                            {{-- admin --}}
                            <a href="/admin/advertisements" class="dropdown-item">Advertisements</a>
                            <a href="/admin/brokers" class="dropdown-item">Broker Requests</a>
                            <a href="/admin/logs" class="dropdown-item">Audit Logs</a>
                            <a href="/admin/requests" class="dropdown-item">360&#176; Requests</a>
                            <a href="/admin/reports" class="dropdown-item">Generate Reports</a>
                        @endif
                        <a href="/logout" class="dropdown-item">Log Out</a>
                    @else
                        <a href="#" class="dropdown-item captcha-refresh" data-toggle="modal" data-target="#loginModal">Log In</a>
                        <a href="#" class="dropdown-item" data-toggle="modal" data-target="#registerModal">Register</a>
                    @endif
                </div>
            </li>
        </ul>
    </div>

    @if(Session::has('verified') || isset($verified))
        @php
            $alert = "<b>Success!</b> Your email has been verified.";
        @endphp
    @endif

    @if(Session::has('status'))
        @php
            $alert = Session::get('status');
        @endphp
    @endif

    @if (Auth::check())
        @php
        $user = Auth::user();

        if ($user->broker_information != null) {
            if($user->broker_information->is_expired()) {
                $user->broker_information->SubscriptionID = null;
                $user->broker_information->SubscriptionStart = null;
                $user->broker_information->save();
            }
        }

        @endphp
    @endif

    @if (Auth::check())
        @if(Auth::user()->user_type->id == 2 && AUth::user()->broker_information->SubscriptionID == null)
        <div id="popup_alert" class="alert alert-sm alert-success alert-dismissible fade show">
            <span>You have not subscribed to any broker package yet. Please <a href='/paypal'>click here</a> to purchase a package</span> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
    @endif
    

    @if(isset($alert))
        <div id="popup_alert" class="alert alert-sm alert-success alert-dismissible fade show">
            <span>{!! $alert !!}</span> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
</nav>

<script>
    $(window).scroll(() => {
        if ($(window).scrollTop() > 0)
            $("body:not(.nolanding) #nav").addClass("moved");
        else
            $("body:not(.nolanding) #nav").removeClass("moved");
    })
</script>

@if(!Auth::check()) 
    <!-- Login Modal -->
    @include('includes.login')

    <!-- Register Modal -->
    @include('includes.register')
@endif