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
                        <li class="header__item"><a href="#!" class="header__link">Profile</a></li>
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
                        <a href="{{route('tickets')}}" class="nav__a {{Route::currentRouteName() == 'tickets' ? 'nav__a--active' : ''}}">Tickets</a>
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
            <button class="btn btn--green btn--add"><i class="fas fa-plus"></i> New Ticket</button>
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
                    <a href="#!" class="submenu__a ">Open <span>(2)</span></a>
                </li>
                <li class="submenu__li">
                    <a href="#!" class="submenu__a submenu__a--active">Ongoing <span>(0)</span></a>
                </li>
                <li class="submenu__li">
                    <a href="#!" class="submenu__a">For Verification <span>(0)</span></a>
                </li>
                <li class="submenu__li">
                    <a href="#!" class="submenu__a">Closed <span>(0)</span></a>
                </li>
                <li class="submenu__li">
                    <a href="#!" class="submenu__a">My Tickets <span>(0)</span></a>
                </li>
                <li class="submenu__li">
                    <a href="#!" class="submenu__a">All <span>(2)</span></a>
                </li>
            </ul>
        @show
    </nav>

</header>
