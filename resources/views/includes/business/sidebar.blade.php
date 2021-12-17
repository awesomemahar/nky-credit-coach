<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header  d-flex  align-items-center">
            <a class="navbar-brand" href="{{ url('business') }}">
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
                        <a class="nav-link  <?php echo($page == "Dashboard" ? "active" : "")?>"
                           href="{{ url('business') }}">
                            <i class="ni ni-shop text-primary"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </li>
                    @if(Auth::user()->type == 2)
                        <li class="nav-item">
                            <a class="nav-link  <?php echo($page == "My Clients" ? "active" : "")?>"
                               href="{{ url('business/client') }}">
                                <i class="fas fa-users text-primary"></i>
                                <span class="nav-link-text">My Clients</span>
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link  <?php echo ($page == "My Clients" ? "active" : "")?>"
                               href="{{ url('client/credit/'.Auth::user()->id) }}">
                                <i class="fas fa-users text-primary"></i>
                                <span class="nav-link-text">Credit Profile Dashboard</span>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link  <?php echo($page == "Disputes" ? "active" : "")?>"
                           href="{{ route('business.disputes') }}">
                            <i class="fas fa-calendar text-primary"></i>
                            <span class="nav-link-text">Disputes</span>
                        </a>
                    </li>
                    {{--<li class="nav-item">--}}
                        {{--<a class="nav-link  <?php echo($page == "Disputes Status" ? "active" : "")?>"--}}
                           {{--href="{{ route('business.disputes.status') }}">--}}
                            {{--<i class="fas fa-calendar text-primary"></i>--}}
                            {{--<span class="nav-link-text">Disputes Status</span>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    <li class="nav-item">
                        <a class="nav-link  <?php echo($page == "Letters Library" ? "active" : "")?>"
                           href="{{ url('business/letters') }}">
                            <i class="fas fa-envelope text-primary"></i>
                            <span class="nav-link-text">Letters Library</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  <?php echo ($page == "Letters Flow" ? "active" : "")?>"
                           href="{{ route('business.letter.flows') }}">
                            <i class="fas fa-road text-primary"></i>
                            <span class="nav-link-text">Letters Flows</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  <?php echo($page == "My Calendar" ? "active" : "")?>"
                           href="{{ url('business/calendar') }}">
                            <i class="fas fa-calendar text-primary"></i>
                            <span class="nav-link-text">My Calendar</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  <?php echo($page == "Training Videos" ? "active" : "")?>"
                           href="{{ url('business/video') }}">
                            <i class="fas fa-video text-primary"></i>
                            <span class="nav-link-text">Training Videos</span>
                        </a>
                    </li>
                    @if($theme == 'bg-blue')
                    <li class="nav-item">
                        <a class="nav-link  <?php echo($page == "FINANCIAL CALCULATOR" ? "active" : "")?>"
                           href="{{ url('business/financial') }}">
                            <i class="fas fa-calculator text-primary"></i>
                            <span class="nav-link-text">Financial Calculator</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  <?php echo($page == "Debt Reduction Calculator" ? "active" : "")?>"
                           href="{{ url('business/debt') }}">
                            <i class="fas fa-calculator text-primary"></i>
                            <span class="nav-link-text">Debt Reduction Calculator</span>
                        </a>
                    </li>
                    @endif
                </ul>

            </div>
        </div>
    </div>
</nav>
