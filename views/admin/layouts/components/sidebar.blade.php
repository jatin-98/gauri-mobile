<div class="sidebar-wrapper">
    <div>
        <div class="logo-wrapper"><a href="index.html"><img class="img-fluid for-light" src="{{asset('assets/images/logo/logo.png')}}" alt=""><img class="img-fluid for-dark" src="../assets/images/logo/logo_dark.png" alt=""></a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
        </div>
        <div class="logo-icon-wrapper"><a href="index.html"><img class="img-fluid" src="{{asset('assets/images/logo/logo-icon.png')}}" alt=""></a></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn"><a href="index.html"><img class="img-fluid" src="../assets/images/logo/logo-icon.png" alt=""></a>
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                    </li>

                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav active" href="{{url('/admin')}}"><i data-feather="home"></i><span>Dashboard</span></a></li>

                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i data-feather="shopping-bag"></i><span>Products</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{url('/admin/products')}}">Listing</a></li>
                            <li><a href="{{url('/admin/products/add')}}">Add Products</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i data-feather="file-text"></i><span>Invoices</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{url('/admin/invoices')}}">Listing</a></li>
                            <li><a href="{{url('/admin/invoices/add')}}">Create Invoice</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i data-feather="trending-up"></i><span>Sales</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{url('/admin/sales')}}">Listing</a></li>
                            <li><a href="{{url('/admin/sales/add')}}">Create Sale</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{url('/admin/settings')}}"><i data-feather="settings"></i><span>Settings</span></a></li>

                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{url('/logout')}}"><i data-feather="log-out"></i><span>Logout</span></a></li>
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>