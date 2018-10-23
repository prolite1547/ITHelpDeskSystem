<header class="header">
    <div class="row-flex">
        <div class="header__logo-box">
            <img src="{{asset('images/icon.png')}}" alt="Citihardware Logo" class="header__logo">
        </div>
        <div class="header__user">
            <span class="header__name">Nimper B. Aragulo</span>
            <div class="header__settings">
                <i class="fas fa-user-cog"></i>
                <i class="fas fa-caret-down"></i>
            </div>
        </div>
    </div>


    <div class="row-flex">
        <div class="left">
            <nav class="nav">
                <ul class="nav__ul">
                    <li class="nav__li">
                        <a href="#!" class="nav__a ">Dashboard</a>
                    </li>
                    <li class="nav__li">
                        <a href="#!" class="nav__a nav__a--active">Tickets</a>
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
