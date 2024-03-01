<div class="sidebar sidebar-hidden">
    <!-- Sidebar content goes here -->
    <ul>
        <li><a href="/gametime">HT/FT</a></li>
        <li><a href="/bothscore">Both to score</a></li>
        <li><a href="/doublechance">Double chance</a></li>
        <li><a href="/handicap">Handicap</a></li>
        <li><a href="/corner">Corners</a></li>
        <li><a href="/overtwo">Probability Over 2.5</a></li>
        <li><a href="/scores">Scores</a></li>
    </ul>
</div>
<header>
    <!-- Header Start -->
    <div class="header-area header-transparent">
        <div class="main-header ">
            <div class="header-bottom  header-sticky">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <!-- Logo -->
                        <div class="col-xl-2 col-lg-2">
                            <div class="logo-container">
                                <div class="logo">
                                    <a href="/"><img style="width: 100px" src="assets/img/logo/logo.png" alt=""><span style="color: white;font-size: 2rem" class="logo-text"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-10 col-lg-10">
                            <div class="menu-wrapper d-flex align-items-center justify-content-end">
                                <!-- Main-menu -->
                                <div class="main-menu d-none d-lg-block">
                                    <nav>
                                        <ul id="navigation">
                                            <li><a href="#">PICK OF THE DAY</a>
                                                <ul style="width: auto" class="submenu">
                                                    <li>
                                                        <div class="voice-chat-card">
                                                            <div class="voice-chat-card-header">
                                                                {{--                                                            <img style="width: 100px; object-fit: cover; border-radius: 50%"  src="assets/img/logo.png" alt="Logo">--}}
                                                                <a href="/detail">
                                                                    <div class="team-names">
                                                                        <p>Manchester City (90%)</p>
                                                                        <p>Manchester United (10%)</p>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="voice-chat-card">
                                                            <div class="voice-chat-card-header">
                                                                {{--                                                            <img style="width: 100px; object-fit: cover; border-radius: 50%"  src="assets/img/logo.png" alt="Logo">--}}
                                                                <a href="/detail">
                                                                    <div class="team-names">
                                                                        <p>Manchester City (90%)</p>
                                                                        <p>Manchester United (10%)</p>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </li>

                                                </ul>
                                            </li>
                                            <li><a href="#">Filter</a>
                                                <ul style="width: 200px" class="submenu">
                                                    <li><a href="/probability">1x2  probability</a></li>
                                                    <li><a href="/cs1">Correct score</a></li>
                                                    <li><a href="/over1">Over 1.5</a></li>
                                                    <li><a href="/over2">Over 2.5</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="fetch-league-matches">Pay now</a>
                                            </li>
                                            <li>
                                                <div class="search">
                                                    <div class="search-box">
                                                        <div class="search-field">
                                                            <form action="{{ route('search') }}" method="get">
                                                                <input name="date" placeholder="Search by date" class="input" type="text">
                                                                <input name="home_team" placeholder="Search by home team" class="input" type="text">
                                                                <input name="away_team" placeholder="Search by away team" class="input" type="text">

                                                                <div class="search-box-icon">
                                                                    <button class="btn-icon-content" type="submit">
                                                                        <i class="search-icon">
                                                                            <svg xmlns="://www.w3.org/2000/svg" version="1.1" viewBox="0 0 512 512">
                                                                                <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" fill="#fff"></path>
                                                                            </svg>
                                                                        </i>
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                            </li>
                                            <!-- Button -->
                                            @if (Route::has('login'))
                                                @auth
                                                    <li><a href="#"><i class="fas fa-user"></i>{{ Auth::user()->name }}</a>
                                                        <ul style="width: 200px" class="submenu">
                                                            <li>
                                                                <a  class="button-header" style="color: white"  class="dropdown-item" href="{{ route('logout') }}"
                                                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                                                    <i class="fas fa-sign-out-alt"></i>{{ __('Logout') }}
                                                                </a>
                                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                                    @csrf
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                @else
                                                    <li><a class="button-header" style="color: white" href="/login"><i class="fas fa-sign-in-alt"></i> Log In</a></li>
                                                    @if (Route::has('register'))
                                                        <li><a   class="button-header" style="color: white"  href="/register"><i class="fas fa-user-plus"></i>Sign Up</a></li>
                                                    @endif
                                                @endauth
                                            @endif
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <!-- Mobile Menu -->
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->
</header>
<style>
    /* Add this CSS to your stylesheet */
    .voice-chat-card:hover {
        background-color: black;
    }

</style>
