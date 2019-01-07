<header class="header">
    <div class="row-flex">
        <div class="header__logo-box">
            <img src="{{asset('images/icon.png')}}" alt="Citihardware Logo" class="header__logo">
        </div>
        <div class="header__user">
            <div class="user">
                <div class="user__name">{{Auth::user()->full_name}}</div>
                <span class="user__position">{{Auth::user()->role->role}}</span>
            </div>
            <div class="header__settings">
                <div class="header__dropdown">
                    <svg class="icon">
                        <use xlink:href="{{asset('svg/sprite.svg#icon-caret-down')}}"></use>
                        <ul class="header__list">
                            <li class="header__item"><a href="{{route('userProfile',['id' => Auth::id()])}}" class="header__link">Profile</a></li>
                            <li class="header__item">
                                <a href="!#" class="header__link" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </svg>

                </div>
            </div>
        </div>
    </div>


    <div class="row-flex">
        <div class="left">
            <nav class="nav">
                <ul class="nav__ul">
                    <li class="nav__li">
                        <a href="{{route('dashboard')}}" class="nav__a {{Route::currentRouteName() == 'dashboard' ? 'nav__a--active' : ''}}">Dashboard</a>
                    </li>
                    <li class="nav__li">
                        <a href="{{route('myTickets')}}" class="nav__a {{in_array(Route::currentRouteName(),$ticketRoutes) ? 'nav__a--active' : ''}}">Tickets</a>
                    </li>
                    <li class="nav__li">
                        <a href="#!" class="nav__a">Requests</a>
                    </li>
                    <li class="nav__li">
                        <a href="{{route('datacorrections.system')}}"class="nav__a {{in_array(Route::currentRouteName(),$dcRoutes) ? 'nav__a--active' : ''}}">Data Corrections</a>
                    </li>
                    <li class="nav__li">
                        <a href="{{route('reportsPage')}}" class="nav__a {{Route::currentRouteName() == 'reportsPage' ? 'nav__a--active' : ''}}">Reports</a>
                    </li>
                    @if(Auth::user()->role_id === 4)
                    <li class="nav__li">
                        <a href="{{route('adminPage')}}" class="nav__a {{Route::currentRouteName() == 'adminPage' ? 'nav__a--active' : ''}}">Admin</a>
                    </li>
                    @endif
                </ul>
            </nav>
        </div>

        <div class="right">
            <a href="{{route('addTicketView')}}" class="btn btn--green btn--add"><i class="fas fa-plus"></i> New Ticket</a>
            <form action="" class="form form--search">
                <i class="fas fa-search form--search__icon"></i>
                <input type="text" class="form__search" placeholder="search... (or ticket ID)">
            </form>
        </div>
    </div>

    <nav class="submenu">
        @section('submenu')
            <ul class="submenu__ul">
                <li class="submenu__li">
                    <a href="{{route('myTickets')}}" class="submenu__a {{Route::currentRouteName() == 'myTickets' ? 'submenu__a--active' : ''}}">My Tickets <span>({{$ticketUserTicketsCount}})</span></a>
                </li>
                <li class="submenu__li">
                    <a href="{{route('openTickets')}}" class="submenu__a {{Route::currentRouteName() == 'openTickets' ? 'submenu__a--active' : ''}}">Open <span>({{$ticketOpenCount}})</span></a>
                </li>
                <li class="submenu__li">
                    <a href="{{route('ongoingTickets')}}" class="submenu__a {{Route::currentRouteName() == 'ongoingTickets' ? 'submenu__a--active' : ''}}">Ongoing <span>({{$ticketOngoingCount}})</span></a>
                </li>
                {{--<li class="submenu__li">--}}
                    {{--<a href="{{route('verificationTickets')}}" class="submenu__a {{Route::currentRouteName() == 'verificationTickets' ? 'submenu__a--active' : ''}}">For Verification <span>(0)</span></a>--}}
                {{--</li>--}}
                <li class="submenu__li">
                    <a href="{{route('closedTickets')}}" class="submenu__a {{Route::currentRouteName() == 'closedTickets' ? 'submenu__a--active' : ''}}">Resolved <span>({{$ticketClosedCount}})</span></a>
                </li>
                <li class="submenu__li">
                    <a href="{{route('allTickets')}}" class="submenu__a {{Route::currentRouteName() == 'allTickets' ? 'submenu__a--active' : ''}}">All <span>({{$ticketCount}})</span></a>
                </li>
            </ul>
        @show
    </nav>

</header>
