<!-- ========== App Menu Start ========== -->
<div class="main-nav">
    <!-- Sidebar Logo -->
    <div class="logo-box">
        <a href="/dashboard" class="logo-dark">
            <img src="{{ $abouts->large_logo ? asset('storage/' . $abouts->large_logo) : asset('assets_dashboard/images/logo-dark.png') }}"
                class="logo-lg" alt="logo dark">
        </a>

        <a href="/dashboard" class="logo-light">
            <img src="{{ $abouts->large_logo ? asset('storage/' . $abouts->large_logo) : asset('assets_dashboard/images/logo-light.png') }}"
                class="logo-lg" alt="logo light">
        </a>
    </div>

    <!-- Menu Toggle Button (sm-hover) -->
    <button type="button" class="button-sm-hover" aria-label="Show Full Sidebar">
        <iconify-icon icon="solar:hamburger-menu-broken" class="button-sm-hover-icon"></iconify-icon>
    </button>

    <div class="scrollbar" data-simplebar>

        <ul class="navbar-nav" id="navbar-nav">

            <li class="nav-item">
                <a class="nav-link" href="/dashboard">
                    <span class="nav-icon">
                        <iconify-icon icon="material-symbols:dashboard-rounded"></iconify-icon>
                    </span>
                    <span class="nav-text"> Dashboard </span>
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="/dashboard/dataMemberSections">
                    <span class="nav-icon">
                        <iconify-icon icon="ic:round-remember-me"></iconify-icon>
                    </span>
                    <span class="nav-text"> Member Data </span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link d-flex align-items-center" href="/dashboard/message">
                    <span class="nav-icon">
                        <iconify-icon icon="mdi:email-outline"></iconify-icon>
                    </span>
                    <span class="nav-text">Message</span>

                    @if ($unreadMessages > 0)
                        <span class="badge bg-danger ms-auto">{{ $unreadMessages }}</span>
                    @endif
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="/dashboard/event">
                    <span class="nav-icon">
                        <iconify-icon icon="mdi:event-outline"></iconify-icon>
                    </span>
                    <span class="nav-text"> Event/Proker </span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/dashboard/posts">
                    <span class="nav-icon">
                        <iconify-icon icon="material-symbols:post-rounded"></iconify-icon>
                    </span>
                    <span class="nav-text">All Post </span>
                </a>
            </li>

        </ul>

        @can('super-admin')
            <ul class="navbar-nav" id="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link" href="/dashboard/categories">
                        <span class="nav-icon">
                            <iconify-icon icon="iconamoon:category-fill"></iconify-icon>
                        </span>
                        <span class="nav-text">Post Categories </span>
                    </a>
                </li>

                <li class="menu-title">Administartor</li>

                <li class="nav-item">
                    <a class="nav-link" href="/dashboard/userSettings">
                        <span class="nav-icon">
                            <iconify-icon icon="fa6-solid:users-gear"></iconify-icon>
                        </span>
                        <span class="nav-text"> User Settings </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/dashboard/divisions">
                        <span class="nav-icon">
                            <iconify-icon icon="mingcute:group-3-fill"></iconify-icon>
                        </span>
                        <span class="nav-text"> Divisions </span>
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="/dashboard/about">
                        <span class="nav-icon">
                            <iconify-icon icon="bx:spreadsheet"></iconify-icon>
                        </span>
                        <span class="nav-text"> About Settings </span>
                    </a>
                </li>

                <li class="menu-title">Presensi</li>

                <li class="nav-item">
                    <a class="nav-link" href="/dashboard/qrcodes">
                        <span class="nav-icon">
                            <iconify-icon icon="mdi:qrcode-scan"></iconify-icon>
                        </span>
                        <span class="nav-text"> Data Qr Codes </span>
                    </a>
                    <a class="nav-link" href="/dashboard/presences">
                        <span class="nav-icon">
                            <iconify-icon icon="iconamoon:scanner-light"></iconify-icon>
                        </span>
                        <span class="nav-text"> Presence </span>
                    </a>
                    <a class="nav-link" href="/dashboard/laporan-presensi">
                        <span class="nav-icon">
                            <iconify-icon icon="lsicon:report-outline"></iconify-icon>
                        </span>
                        <span class="nav-text"> Laporan Presensi </span>
                    </a>
                </li>


                <li class="menu-title">Content Settings</li>


                <li class="nav-item">
                    <a class="nav-link" href="/dashboard/prokerSections">
                        <span class="nav-icon">
                            <iconify-icon icon="fluent:layout-row-two-settings-24-regular"></iconify-icon>
                        </span>
                        <span class="nav-text"> Proker Sections </span>
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="/dashboard/homeSections">
                        <span class="nav-icon">
                            <iconify-icon icon="bx:carousel"></iconify-icon>
                        </span>
                        <span class="nav-text"> Home Carousel </span>
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="/dashboard/background">
                        <span class="nav-icon">
                            <iconify-icon icon="hugeicons:background"></iconify-icon>
                        </span>
                        <span class="nav-text"> BreadCrumb Backgrounds </span>
                    </a>
                </li>


            </ul>
        @endcan
        <ul class="navbar-nav" id="navbar-nav">
            <li class="menu-title">
                <hr>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/logout">
                    <span class="nav-icon">
                        <iconify-icon icon="ri:logout-circle-r-line"></iconify-icon>
                    </span>
                    <span class="nav-text"> Log Out </span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- ========== App Menu End ========== -->
