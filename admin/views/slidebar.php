<div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Trang chủ  
                            </a>

                            <div class="sb-sidenav-menu-heading">Quản lý</div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-car"></i></div>
                                Xe và Nhà xe
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="Car.php">Xe</a>
                                    <a class="nav-link" href="C_house.php">Nhà xe</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Tài khoản
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                
                                    <div class="nav-link collapsed" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="customerList.php">Khách hàng</a>
                                            <a class="nav-link" href="adminProfile.php">Cá nhân</a>
                                            <a class="nav-link" href="staffList.php">Nhân viên</a>
                                        
                                        </nav>
                                    </div>
                                </nav>
                            </div>
                            
                            <div class="sb-sidenav-menu-heading">Tuyến đường</div>
                            <a class="nav-link" href="route.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-car"></i></div>
                                Tuyến đường
                            </a>
                            <a class="nav-link" href="trip.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-car"></i></div>
                                Chuyến xe
                            </a>
                            <a class="nav-link" href="Location.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-route"></i></div>
                                Lộ trình    
                            </a>
                            <a class="nav-link" href="city.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-city"></i></div>
                                Thành phố
                            </a>
                            
                            <div class="sb-sidenav-menu-heading">Vé và Thống kê</div>
                            <a class="nav-link" href="ticket.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-ticket"></i></div>
                                Vé
                            </a>
                            <a class="nav-link" href="report.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-chart-simple"></i></div>
                                Thống Kê
                            </a>
                        </div>
                    </div>

                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Admin
                    </div>
                </nav>
            </div>