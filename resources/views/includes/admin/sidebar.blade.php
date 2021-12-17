<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header  d-flex  align-items-center">
            <a class="{{ route('admin.index') }}" href="javascript:void(0)">
                <img src="{{ asset('assets/img/logo.png') }}" class="navbar-brand-img img-fluid" alt="...">
            </a>
            <div class=" ml-auto ">
                <!-- Sidenav toggler -->
                <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link  <?php echo ($page == "Dashboard" ? "active" : "")?>" href="{{ route('admin.index') }}">
                            <i class="ni ni-shop text-primary"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  <?php echo ($page == "My Clients" ? "active" : "")?>"
                           href="{{ route('admin.clients.index') }}">
                            <i class="fas fa-users text-primary"></i>
                            <span class="nav-link-text">Standard Clients</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  <?php echo ($page == "Business Clients" ? "active" : "")?>"
                           href="{{ route('admin.business-clients.index') }}">
                            <i class="fas fa-users text-primary"></i>
                            <span class="nav-link-text">Business Clients</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  <?php echo ($page == "Dispute Reasons" ? "active" : "")?>"
                           href="{{ route('admin.reason.index') }}">
                            <i class="fas fa-asterisk text-primary"></i>
                            <span class="nav-link-text">Dispute Reasons</span>
                        </a>
                    </li>
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link  <?php echo ($page == "Letter Keys" ? "active" : "")?>"--}}
{{--                           href="{{ route('admin.keys') }}">--}}
{{--                            <i class="fas fa-calculator text-primary"></i>--}}
{{--                            <span class="nav-link-text">Letter Keys</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
                    <li class="nav-item">
                        <a class="nav-link  <?php echo ($page == "Letters Library" ? "active" : "")?>"
                           href="{{ route('admin.letters.library') }}">
                            <i class="fas fa-envelope text-primary"></i>
                            <span class="nav-link-text">Letters Library</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  <?php echo ($page == "Letters Flow" ? "active" : "")?>"
                           href="{{ route('admin.letter.flows') }}">
                            <i class="fas fa-road text-primary"></i>
                            <span class="nav-link-text">Letters Flows</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  <?php echo ($page == "Training Videos" ? "active" : "")?>"
                           href="{{ route('admin.video.index') }}">
                            <i class="fas fa-video text-primary"></i>
                            <span class="nav-link-text">Training Videos</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  <?php echo ($page == "Subscriptions" ? "active" : "")?>"
                           href="{{ route('admin.subscriptions') }}">
                            <i class="fas fa-calculator text-primary"></i>
                            <span class="nav-link-text">Subscriptions & Payments</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  <?php echo ($page == "Subscription Packages" ? "active" : "")?>"
                           href="{{ route('admin.packages') }}">
                            <i class="fas fa-boxes text-primary"></i>
                            <span class="nav-link-text">Subscriptions Packages</span>
                        </a>
                    </li>
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link  <?php echo ($page == "Subscription Forms" ? "active" : "")?>"--}}
{{--                           href="{{ route('admin.subscription.forms') }}">--}}
{{--                            <i class="fas fa-calculator text-primary"></i>--}}
{{--                            <span class="nav-link-text">Subscription Forms</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}

                </ul>

            </div>
        </div>
    </div>
</nav>
