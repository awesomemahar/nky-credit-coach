<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header  d-flex  align-items-center">
            <a class="navbar-brand" href="javascript:void(0)">
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
                        <a class="nav-link  <?php echo ($page == "Dashboard" ? "active" : "")?>" href="{{ route('client.index') }}">
                            <i class="ni ni-shop text-primary"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  <?php echo ($page == "Credit Profile Dashboard" ? "active" : "")?>"
                           href="{{ route('client.credit.profile') }}">
                            <i class="fas fa-users text-primary"></i>
                            <span class="nav-link-text">Credit Profile Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link  <?php echo($page == "Disputes" ? "active" : "")?>"
                           href="{{ route('client.disputes') }}">
                            <i class="fas fa-calendar text-primary"></i>
                            <span class="nav-link-text">Disputes</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link  <?php echo ($page == "Letters Library" ? "active" : "")?>"
                           href="{{ route('client.letters.library') }}">
                            <i class="fas fa-envelope text-primary"></i>
                            <span class="nav-link-text">Letters Library</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  <?php echo ($page == "Letters Flow" ? "active" : "")?>"
                           href="{{ route('client.letter.flows') }}">
                            <i class="fas fa-road text-primary"></i>
                            <span class="nav-link-text">Letters Flows</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link  <?php echo ($page == "Training Videos" ? "active" : "")?>"
                           href="{{ route('client.training.videos') }}">
                            <i class="fas fa-video text-primary"></i>
                            <span class="nav-link-text">Training Videos</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  <?php echo ($page == "Financial Calculator" ? "active" : "")?>"
                           href="{{ route('client.financial.calculator')  }}">
                            <i class="fas fa-calculator text-primary"></i>
                            <span class="nav-link-text">Financial Calculator</span>
                        </a>
                    </li>
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link  <?php echo ($page == "My Calendar" ? "active" : "")?>" href="{{ route('client.calendar') }}">--}}
{{--                            <i class="fas fa-calendar text-primary"></i>--}}
{{--                            <span class="nav-link-text">My Calendar</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
                    <!-- <li class="nav-item">
                        <a >
                            <i class="ni ni-shop text-primary"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                       <div class="collapse show" id="navbar-dashboards">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="../../pages/dashboards/dashboard.html" class="nav-link">
                                        <span class="sidenav-mini-icon"> D </span>
                                        <span class="sidenav-normal"> Dashboard </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../../pages/dashboards/alternative.html" class="nav-link">
                                        <span class="sidenav-mini-icon"> A </span>
                                        <span class="sidenav-normal"> Alternative </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#navbar-examples" data-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="navbar-examples">
                            <i class="ni ni-ungroup text-orange"></i>
                            <span class="nav-link-text">Examples</span>
                        </a>
                        <div class="collapse" id="navbar-examples">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="../../pages/examples/pricing.html" class="nav-link">
                                        <span class="sidenav-mini-icon"> P </span>
                                        <span class="sidenav-normal"> Pricing </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../../pages/examples/login.html" class="nav-link">
                                        <span class="sidenav-mini-icon"> L </span>
                                        <span class="sidenav-normal"> Login </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../../pages/examples/register.html" class="nav-link">
                                        <span class="sidenav-mini-icon"> R </span>
                                        <span class="sidenav-normal"> Register </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../../pages/examples/lock.html" class="nav-link">
                                        <span class="sidenav-mini-icon"> L </span>
                                        <span class="sidenav-normal"> Lock </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../../pages/examples/timeline.html" class="nav-link">
                                        <span class="sidenav-mini-icon"> T </span>
                                        <span class="sidenav-normal"> Timeline </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../../pages/examples/profile.html" class="nav-link">
                                        <span class="sidenav-mini-icon"> P </span>
                                        <span class="sidenav-normal"> Profile </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../../pages/examples/rtl-support.html" class="nav-link">
                                        <span class="sidenav-mini-icon"> RP </span>
                                        <span class="sidenav-normal"> RTL Support </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#navbar-components" data-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="navbar-components">
                            <i class="ni ni-ui-04 text-info"></i>
                            <span class="nav-link-text">Components</span>
                        </a>
                        <div class="collapse" id="navbar-components">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="../../pages/components/buttons.html" class="nav-link">
                                        <span class="sidenav-mini-icon"> B </span>
                                        <span class="sidenav-normal"> Buttons </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../../pages/components/cards.html" class="nav-link">
                                        <span class="sidenav-mini-icon"> C </span>
                                        <span class="sidenav-normal"> Cards </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../../pages/components/grid.html" class="nav-link">
                                        <span class="sidenav-mini-icon"> G </span>
                                        <span class="sidenav-normal"> Grid </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../../pages/components/notifications.html" class="nav-link">
                                        <span class="sidenav-mini-icon"> N </span>
                                        <span class="sidenav-normal"> Notifications </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../../pages/components/icons.html" class="nav-link">
                                        <span class="sidenav-mini-icon"> I </span>
                                        <span class="sidenav-normal"> Icons </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../../pages/components/typography.html" class="nav-link">
                                        <span class="sidenav-mini-icon"> T </span>
                                        <span class="sidenav-normal"> Typography </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#navbar-multilevel" class="nav-link" data-toggle="collapse" role="button"
                                        aria-expanded="true" aria-controls="navbar-multilevel">
                                        <span class="sidenav-mini-icon"> M </span>
                                        <span class="sidenav-normal"> Multi level </span>
                                    </a>
                                    <div class="collapse show" id="navbar-multilevel" style="">
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <a href="#!" class="nav-link ">Third level menu</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#!" class="nav-link ">Just another link</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#!" class="nav-link ">One last link</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#navbar-forms" data-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="navbar-forms">
                            <i class="ni ni-single-copy-04 text-pink"></i>
                            <span class="nav-link-text">Forms</span>
                        </a>
                        <div class="collapse" id="navbar-forms">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="../../pages/forms/elements.html" class="nav-link">
                                        <span class="sidenav-mini-icon"> E </span>
                                        <span class="sidenav-normal"> Elements </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../../pages/forms/components.html" class="nav-link">
                                        <span class="sidenav-mini-icon"> C </span>
                                        <span class="sidenav-normal"> Components </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../../pages/forms/validation.html" class="nav-link">
                                        <span class="sidenav-mini-icon"> V </span>
                                        <span class="sidenav-normal"> Validation </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#navbar-tables" data-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="navbar-tables">
                            <i class="ni ni-align-left-2 text-default"></i>
                            <span class="nav-link-text">Tables</span>
                        </a>
                        <div class="collapse" id="navbar-tables">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="../../pages/tables/tables.html" class="nav-link">
                                        <span class="sidenav-mini-icon"> T </span>
                                        <span class="sidenav-normal"> Tables </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../../pages/tables/sortable.html" class="nav-link">
                                        <span class="sidenav-mini-icon"> S </span>
                                        <span class="sidenav-normal"> Sortable </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../../pages/tables/datatables.html" class="nav-link">
                                        <span class="sidenav-mini-icon"> D </span>
                                        <span class="sidenav-normal"> Datatables </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#navbar-maps" data-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="navbar-maps">
                            <i class="ni ni-map-big text-primary"></i>
                            <span class="nav-link-text">Maps</span>
                        </a>
                        <div class="collapse" id="navbar-maps">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="../../pages/maps/google.html" class="nav-link">
                                        <span class="sidenav-mini-icon"> G </span>
                                        <span class="sidenav-normal"> Google </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../../pages/maps/vector.html" class="nav-link">
                                        <span class="sidenav-mini-icon"> V </span>
                                        <span class="sidenav-normal"> Vector </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li> -->

                </ul>

            </div>
        </div>
    </div>
</nav>
