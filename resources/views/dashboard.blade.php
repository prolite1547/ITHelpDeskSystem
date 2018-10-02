<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>

    <style>
        .header {
            background-color: #1b4b72;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="row">
            <div class="header__icon-box">
                <img src="{{asset('images/icon.png')}}" alt="Citihardware Logo" class="header__icon">
            </div>
            <div class="user">
                <span class="user__name">Nimper B. Aragulo</span>
                <div class="user__settings">
                    <i class="fas fa-gear"></i>
                </div>
            </div>
        </div>


        <div class="row">
            <nav class="nav">
                <ul class="nav__ul">
                    <li class="nav__li">
                        <a href="#!" class="nav__a">Dashboard</a>
                    </li>
                    <li class="nav__li">
                        <a href="#!" class="nav__a">Tickets</a>
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

            <div class="right">
                <button class="btn btn--green"><i class="fas fa-add"></i>New Ticket</button>
                <form action="">
                    <input type="text" placeholder="Search ticket ID...">
                </form>
            </div>
        </div>

    </header>
</body>
</html>
