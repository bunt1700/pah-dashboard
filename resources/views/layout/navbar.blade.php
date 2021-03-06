<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element row">
                    <div class="col-lg-4">
                        <img alt="image" class="rounded-circle" src="img/profile_small.jpg"/>
                    </div>
                    <a data-toggle="dropdown" class="dropdown-toggle col-lg-8" href="#">
                        <span class="block m-t-xs font-bold">Mark Bunt <b class="caret"></b></span>
                        <span class="text-muted text-xs block">@productaanhuis</span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a class="dropdown-item" href="profile.html">Profiel</a></li>
                        <li><a class="dropdown-item" href="contacts.html">Collega's</a></li>
                        <li><a class="dropdown-item" href="mailbox.html">Inbox</a></li>
                        <li class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="login.html">Uitloggen</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
            <li class="special_link">
                <a href="{{ route('homepage') }}">
                    <i class="fa fa-th-large"></i><span class="nav-label">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="fa fa-shopping-cart"></i> <span class="nav-label">Inventaris</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="{{ route('productlist') }}">Producten</a></li>
                    <li><a href="{{ route('categorization') }}">Categorie&euml;n</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>