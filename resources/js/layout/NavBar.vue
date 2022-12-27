<template>
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <Link href="/" class="nav-link"> الرئيسية</Link>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <!--                <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
                                                                     document.getElementById('logout-form').submit();">تسجيل الخروج</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>-->
            </li>
        </ul>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Navbar Search -->
            <!-- Messages Dropdown Menu -->
            <li class="nav-item">
                <Link class="nav-link" href="/feedback">
                    <i class="far fa-comments"></i>
                    <span class="badge badge-danger navbar-badge" id="message"></span>
                </Link>
            </li>
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item">
                <Link class="nav-link" href="/">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge" id="cart"></span>
                </Link>
            </li>
            <!-- fullscreen -->

            <li class="nav-item">
                <Link class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </Link>
            </li>

        </ul>
    </nav>

</template>
