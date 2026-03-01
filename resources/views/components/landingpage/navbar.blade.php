       <!-- Header Section Start -->
       <header>
           @if ($abouts)
               <div class="header-top-section fix" id="home">
                   <div class="container-fluid">
                       <div class="header-top-wrapper">
                           <ul class="contact-list">
                               <li>
                                   <i class="far fa-envelope"></i>
                                   {{ $abouts->contact_email }}
                               </li>
                               <li>
                                   <i class="fa-solid fa-phone-volume"></i>
                                   {{ $abouts->contact_phone }}
                               </li>
                           </ul>
                           <div class="top-right">
                               <div class="social-icon d-flex align-items-center">
                                   <span>Follow Us:</span>
                                   <a href="{{ $abouts->instagram_url }}" target="_blank"><i
                                           class='bx bxl-instagram-alt'></i></a>
                                   <a href="{{ $abouts->youtube_url }}" target="_blank"><i
                                           class='bx bxl-youtube'></i></a>
                                   <a href="{{ $abouts->tiktok_url }}" target="_blank"><i class='bx bxl-tiktok'></i></a>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           @else
               <div class="header-top-section fix" id="home">
                   <div class="container-fluid">
                       <div class="header-top-wrapper">
                           <ul class="contact-list">
                               <li>
                                   <i class="far fa-envelope"></i>
                                   hmpi@gmail.com
                               </li>
                               <li>
                                   <i class="fa-solid fa-phone-volume"></i>
                                   082345423434532
                               </li>
                           </ul>
                           <div class="top-right">
                               <div class="social-icon d-flex align-items-center">
                                   <span>Follow Us:</span>
                                   <a href="https://www.instagram.com/hmpinformatika_upy?igsh=MTZjdzg3YWp0ZjhmeA=="
                                       target="_blank"><i class='bx bxl-instagram-alt'></i></a>
                                   <a href="https://www.youtube.com/@hmpinformatikaupy" target="_blank"><i
                                           class='bx bxl-youtube'></i></a>
                                   <a href="https://www.tiktok.com/@hmpinformatikaupy1?_t=ZS-8vMXZWIPdBf&_r=1"
                                       target="_blank"><i class='bx bxl-tiktok'></i></a>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           @endif

           <div id="header-sticky" class="header-1">
               <div class="container-fluid">
                   <div class="mega-menu-wrapper">
                       <div class="header-main style-2">
                           <div class="header-left">
                               <div class="logo">
                                   <a href="/about" class="header-logo">
                                       <img src="{{ asset('assets/img/logo/black-logo.svg') }}"
                                           alt="logo-img" height="50px" width="auto">
                                   </a>
                               </div>
                           </div>

                           <div class="header-right d-flex justify-content-end align-items-center">
                               <div class="mean__menu-wrapper">
                                   <div class="main-menu">
                                       <nav id="mobile-menu">
                                           <ul>
                                               <li class="has-dropdown active menu-thumb">
                                                   <a href="/#home">
                                                       Home
                                                   </a>
                                               </li>

                                               <li>
                                                   <a href="/#about">About</a>
                                               </li>
                                               <li>
                                                   <a href="/#activity">
                                                       Work Programs
                                                       <i class="fas fa-angle-down"></i>
                                                   </a>
                                                   <ul class="submenu">
                                                       <li><a href="/workPrograms">All Programs</a></li>
                                                   </ul>
                                               </li>
                                               <li>
                                                   <a href="/#teams">
                                                       Divisions and Teams
                                                       <i class="fas fa-angle-down"></i>
                                                   </a>
                                                   <ul class="submenu">
                                                       <li><a href="/teams">All Members</a></li>
                                                   </ul>
                                               </li>
                                               <li>
                                                   <a href="/#articles">
                                                       News & Articles
                                                       <i class="fas fa-angle-down"></i>
                                                   </a>
                                                   <ul class="submenu">
                                                       <li><a href="/posts">All News & Articles</a></li>
                                                       <li><a href="/categories">Categories</a></li>
                                                   </ul>
                                               </li>
                                               <li>
                                                   <a href="/contact">Contact</a>
                                               </li>
                                           </ul>
                                       </nav>
                                   </div>
                               </div>
                               <div class="header__hamburger d-lg-none my-auto">
                                   <div class="sidebar__toggle">
                                       <i class="fas fa-bars"></i>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </header>
