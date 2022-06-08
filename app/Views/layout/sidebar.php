   <div id="layoutSidenav_nav">
       <nav class="sb-sidenav accordion sb-sidenav-dark bg-dark" id="sidenavAccordion">
           <div class="sb-sidenav-menu">
               <div class="nav">
                   <!-- <div class="sb-sidenav-menu-heading">Core</div>
                   <a class="nav-link" href="/">
                       <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                       Dashboard
                   </a> -->


                   <div class="sb-sidenav-menu-heading"> </div>

                   <?php if (has_permission('pembelian')) : ?>

                       <a class="nav-link" href="/produk">
                           <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                           Data Produk
                       </a>
                   <?php endif; ?>

                   <?php if (has_permission('data-users')) : ?>
                       <a class="nav-link" href="/users">
                           <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                           Pengelolaan User
                       </a>
                   <?php endif; ?>


                   <?php if (has_permission('penjualan')) : ?>
                       <a class="nav-link" href="/jual">
                           <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                           Penjualan
                       </a>
                   <?php endif; ?>

                   <?php if (has_permission('pembelian')) : ?>
                       <a class="nav-link" href="/beli">
                           <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                           Pembelian
                       </a>
                   <?php endif; ?>




                   <?php if (has_permission('data-customer')) : ?>
                       <a class="nav-link" href="/customer">
                           <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                           Data Customer
                       </a>
                   <?php endif; ?>

                   <?php if (has_permission('data-supplier')) : ?>
                       <a class="nav-link" href="/supplier">
                           <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                           Data Supplier
                       </a>
                   <?php endif; ?>

                   <!-- <a class="nav-link" href="">
                           <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                           Data Karyawan
                       </a> -->

                   <!-- Unguided Modul 4 -->


                   <?php if (has_permission('laporan-pembelian', 'data_customer')) : ?>
                       <a class="nav-link" href="/beli/laporan">
                           <div class="sb-nav-link-icon"><i class="fas fa-address-card"></i></div>
                           Laporan Pembelian
                       </a>

                   <?php endif; ?>
                   <?php if (has_permission('laporan-penjualan')) : ?>
                       <a class="nav-link" href="/jual/laporan">
                           <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                           Laporan Penjualan
                       </a>
                   <?php endif; ?>


                   <!-- <a class="nav-link" href="/Customer">
                       <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                       Data Customer
                   </a> -->

                   <!--  -->
                   <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                       <nav class="sb-sidenav-menu-nested nav">
                           <a class="nav-link" href="layout-static.html">Static Navigation</a>
                           <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
                       </nav>
                   </div>
                   <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                       <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                           <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                               Authentication
                               <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                           </a>
                           <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                               <nav class="sb-sidenav-menu-nested nav">
                                   <a class="nav-link" href="login.html">Login</a>
                                   <a class="nav-link" href="register.html">Register</a>
                                   <a class="nav-link" href="password.html">Forgot Password</a>
                               </nav>
                           </div>
                           <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                               Error
                               <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                           </a>
                           <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                               <nav class="sb-sidenav-menu-nested nav">
                                   <a class="nav-link" href="401.html">401 Page</a>
                                   <a class="nav-link" href="404.html">404 Page</a>
                                   <a class="nav-link" href="500.html">500 Page</a>
                               </nav>
                           </div>
                       </nav>
                   </div>
                   <!-- <div class="sb-sidenav-menu-heading">Addons</div>
                   <a class="nav-link" href="charts.html">
                       <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                       Charts
                   </a>
                   <a class="nav-link" href="tables.html">
                       <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                       Tables
                   </a> -->

               </div>
           </div>
           <div class="sb-sidenav-footer">
               Login sebagai : <?= user()->username ?>
           </div>
       </nav>
   </div>