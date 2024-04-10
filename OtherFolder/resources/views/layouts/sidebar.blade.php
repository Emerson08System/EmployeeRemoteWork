        <!-- Main sidebar -->
        <div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">

            <!-- Sidebar content -->
            <div class="sidebar-content">

                <!-- Sidebar header -->
                <div class="sidebar-section">
                    <div class="sidebar-section-body d-flex justify-content-center">
                        <h5 class="sidebar-resize-hide flex-grow-1 my-auto">Navigation</h5>

                        <div>
                            <button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                                <i class="ph-arrows-left-right"></i>
                            </button>

                            <button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
                                <i class="ph-x"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /sidebar header -->


                <!-- Main navigation -->
                <div class="sidebar-section">
                    <ul class="nav nav-sidebar" id="navbar-nav" data-nav-type="accordion">

                        <!-- Main -->
                        <li class="nav-item-header pt-0">
                            <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Main</div>
                            <i class="ph-dots-three sidebar-resize-show"></i>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('remote.dashboard') }}" class="nav-link">
                                <i class="ph-house"></i>
                                <span>
                                    Dashboard
                                </span>
                            </a>
                        </li>

                        <!-- Forms -->
                        <li class="nav-item-header">
                            <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Employee Monitoring / Tracking</div>
                            <i class="ph-dots-three sidebar-resize-show"></i>
                        </li>
                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link {{ Route::is('remote.request') ? 'active' : '' }}">
                                <i class="ph ph-address-book"></i>
                                <span>Remote Request</span>
                            </a>
                            <ul class="nav-group-sub collapse{{ Route::is('remote.request') ? 'collapsed' : '' }}">
                                <li class="nav-item"><a href="{{ route('remote.request') }}" class="nav-link {{ Route::is('remote.request') ? 'active' : '' }}">Remote Request</a></li>
                            </ul>
                        </li>


                        {{-- <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link {{ Route::is('remote.monitoring') ? 'active' : '' }}">
                                <i class="ph ph-monitor"></i>
                                <span>Monitoring</span>
                            </a>
                            <ul class="nav-group-sub collapse{{ Route::is('remote.monitoring') ? 'collapsed' : '' }} ">
                                <li class="nav-item"><a href="{{ route('remote.monitoring') }}" class="nav-link {{ Route::is('remote.monitoring') ? 'active' : '' }}">Monitoring</a></li>
                            </ul>
                        </li> --}}

                        {{-- <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link {{ Route::is('remote.schedule') ? 'active' : '' }}">
                                <i class="ph ph-calendar"></i>
                                <span>Schedule</span>
                            </a>
                            <ul class="nav-group-sub collapse{{ Route::is('remote.schedule') ? 'collapsed' : '' }}">
                                <li class="nav-item"><a href="{{ route('remote.schedule') }}" class="nav-link {{ Route::is('remote.schedule') ? 'active' : '' }}">Schedule</a></li>
                            </ul>
                        </li> --}}

                        <li class="nav-item nav-item-submenu">
                            <a href="" class="nav-link {{ Route::is('remote.employees') || Route::is('remote.schedule') ? 'active' : '' }}">
                                <i class="ph ph-users-three"></i>
                                <span>Remote Employee</span>
                            </a>
                            <ul class="nav-group-sub collapse{{ Route::is('remote.employees') || Route::is('remote.schedule') ? 'collapsed' : '' }}">
                                <li class="nav-item"><a href="{{ route('remote.employees') }}" class="nav-link {{ Route::is('remote.employees') ? 'active' : '' }}">Lists Employee Remote</a></li>
                                <li class="nav-item"><a href="{{ route('remote.schedule') }}" class="nav-link {{ Route::is('remote.schedule') ? 'active' : '' }}">Schedule</a></li>
                            </ul>
                        </li>

                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link {{ Route::is('remote.projects') || Route::is('remote.task') ? 'active' : '' }}">
                                <i class="ph ph-list"></i>
                                <span>Projects</span>
                            </a>
                            <ul class="nav-group-sub collapse{{ Route::is('remote.projects') || Route::is('remote.task') ? 'collapsed' : '' }}">
                                <li class="nav-item"><a href="{{ route('remote.projects') }}" class="nav-link {{ Route::is('remote.projects') ? 'active' : '' }}">Projects</a></li>
                                <li class="nav-item"><a href="{{ route('remote.task') }}" class="nav-link {{ Route::is('remote.task') ? 'active' : '' }}">Task Assign</a></li>
                            </ul>
                        </li>

                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link {{ Route::is('remote.meetings') ? 'active' : '' }}">
                                <i class="ph ph-presentation-chart"></i>
                                <span>Meetings</span>
                            </a>
                            <ul class="nav-group-sub collapse{{ Route::is('remote.meetings') ? 'collapsed' : '' }}">
                                <li class="nav-item"><a href="{{ route('remote.meetings') }}" class="nav-link {{ Route::is('remote.meetings') ? 'active' : '' }}">Meeting</a></li>
                            </ul>
                        </li>

                    </ul>
                </div>
                <!-- /main navigation -->

            </div>
            <!-- /sidebar content -->

        </div>
        <!-- /main sidebar -->
