<header class="header">
    <div class="row-flex u-padding-big">
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
    <div class="row-flex row-flex__ai--fe">
        <div class="left">
            <nav class="nav">
                <ul class="nav__ul">
                    <li class="nav__li">
                        <a href="{{route('dashboard')}}" class="nav__a {{Route::currentRouteName() == 'dashboard' ? 'nav__a--active' : ''}}">Dashboard</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>
