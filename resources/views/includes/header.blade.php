<header class="header">
    <div class="row-flex">
        <div class="header__logo-box">
            <img src="{{asset('images/icon.png')}}" alt="Citihardware Logo" class="header__logo">
        </div>
        <div class="header__user">
            <span class="header__name">{{Auth::user()->name}}</span>
            <div class="header__settings">
                <div class="header__dropdown">
                    <div class="header__icon-box">
                        <i class="fas fa-caret-down"></i>
                    </div>
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
                        <a href="{{route('myTickets')}}" class="nav__a {{in_array(Route::currentRouteName(),['openTickets','myTickets','ongoingTickets','closedTickets','allTickets']) ? 'nav__a--active' : ''}}">Tickets</a>
                    </li>
                    <li class="nav__li">
                        <a href="#!" class="nav__a">Requets</a>
                    </li>
                    <li class="nav__li">
                        <a href="#!" class="nav__a">Reports</a>
                    </li>
                    <li class="nav__li">
                        <a href="#!" class="nav__a">Knowledge Base</a>
                    </li>
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
                    <a href="{{route('myTickets')}}" class="submenu__a {{Route::currentRouteName() == 'myTickets' ? 'submenu__a--active' : ''}}">My Tickets <span>(0)</span></a>
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
                    <a href="{{route('closedTickets')}}" class="submenu__a {{Route::currentRouteName() == 'closedTickets' ? 'submenu__a--active' : ''}}">Closed <span>(0)</span></a>
                </li>
                <li class="submenu__li">
                    <a href="{{route('allTickets')}}" class="submenu__a {{Route::currentRouteName() == 'allTickets' ? 'submenu__a--active' : ''}}">All <span>(2)</span></a>
                </li>
            </ul>
        @show
    </nav>

</header>
