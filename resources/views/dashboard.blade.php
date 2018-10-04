@extends('layouts.master')
@section('title','Dashboard')
@section('content')
    <div class="container container--tickets">
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
                    <i class="fas fa-search form--search__icon"></i><input type="text" class="form__search" placeholder="search... (or ticket ID)"></span>
                </form>
            </div>
        </div>

        <nav class="submenu">
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
        </nav>
    </header>

    <main>
        <div class="row u-margin-top-xsmall">
            <div class="col-1-of-4">
                <aside class="side">
                    <div class="side__title">
                        <h3 class="heading-tertiary">Ticket types</h3>
                        <span class="side__filter"><i class="fas fa-filter"></i></span>
                    </div>
                    <div class="side__content">
                        <dl class="side__dl">
                            <dt class="side__dt">All types <span class="side__count">(2)</span></dt>
                            <dd class="side__dd">Incident <span class="side__count">(1)</span></dd>
                            <dd class="side__dd">Request <span class="side__count">(1)</span></dd>
                        </dl>
                    </div>
                </aside>
            </div>
            <div class="col-3-of-4">
            </div>
        </div>
    </main>
    </div>
@endsection

