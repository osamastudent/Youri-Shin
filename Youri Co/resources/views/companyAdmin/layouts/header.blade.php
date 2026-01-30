<style>
    .profile-card {
        position: absolute;
        top: 40px;
        right: 0;
        display: none;
        width: 200px;
        z-index: 1000;
    }
    .profile-pic:hover + .profile-card, .profile-card:hover {
        display: block;
    }
    .profile-pic {
        cursor: pointer;
    }
    .nav-item {
        position: relative;
    }
    
    /* Fix profile dropdown going too far right */
.navbar .dropdown-menu-right {
    right: 0 !important;
    left: auto !important;
    transform: translateX(-10px);
}

@media (max-width: 768px) {
    .navbar .dropdown-menu-right {
        right: 10px !important;
        left: auto !important;
        transform: none;
    }
}

</style>
    
<header class="topbar">
         <nav class="navbar top-navbar navbar-expand-md navbar-dark">
    <div class="navbar-collapse">

        <!-- LEFT SIDE -->
        <ul class="navbar-nav mr-auto align-items-center">

            <li class="nav-item">
                <a class="nav-link nav-toggler d-block d-sm-none waves-effect waves-dark" href="javascript:void(0)">
                    <i class="ti-menu"></i>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link sidebartoggler d-none d-md-block d-lg-block waves-effect waves-dark" href="javascript:void(0)">
                    <i class="icon-menu"></i>
                </a>
            </li>

            <!-- Search (hidden on mobile) -->
            <li class="nav-item d-none d-md-block">
                <form class="app-search">
                    <input type="text" class="form-control" placeholder="Search & enter">
                </form>
            </li>

            <!-- Logged-in company/user info (Desktop only) -->
            @if(Auth::check())
                <li class="nav-item d-none d-lg-flex align-items-center ml-3">
                    <span class="small">
                        <strong>{{ Auth::user()->name }}</strong>
                        | <strong>{{ Auth::user()->refrel_code }}</strong>
                    </span>
                </li>
            @endif

        </ul>

        <!-- RIGHT SIDE -->
        <ul class="navbar-nav ml-auto my-lg-0 align-items-center">

            <li class="nav-item dropdown u-pro">
                <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic d-flex align-items-center"
                   href="#"
                   id="navbarDropdown1"
                   role="button"
                   data-toggle="dropdown"
                   aria-haspopup="true"
                   aria-expanded="false">

                    <img src="/uploads/{{ Auth::user()->logo_img }}"
                         alt="user"
                         class="rounded-circle"
                         width="30"
                         height="30">

                    <span class="d-none d-lg-inline ml-1">
                        <i class="fa fa-angle-down"></i>
                    </span>
                </a>

                <div class="card profile-card dropdown-menu dropdown-menu-right animated flipInY"
                     aria-labelledby="navbarDropdown1">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ Auth::user()->name }}</h5>

                        <a href="{{ route('profile', Auth::user()->id) }}" class="dropdown-item">
                            <i class="ti-user"></i> My Profile
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </li>

        </ul>

    </div>
</nav>

            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
            <!-- jQuery -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <!-- Bootstrap JS -->
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        </header>