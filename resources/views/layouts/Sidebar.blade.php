   <!-- Main Sidebar Container -->
   <aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link">
      <img src='/images/AdminLTELogo.png' alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">SPK-APP</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src='/images/user2-160x160.jpg' class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block ">Alexander Pierce</a>
        </div>
      </div> -->

      <!-- SidebarSearch Form
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fa fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <router-link to="/dashboard" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p>
                </router-link>
           </li>
               

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa fa-book-reader"></i>
              <p>
                Master
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
               <router-link to="/alternatif" class="nav-link">
                  <i class="fas fa-circle  nav-icon"></i>
                  <p>Alternatif</p>
              </router-link>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/kriteria" class="nav-link">
                  <i class="fas fa-circle  nav-icon"></i>
                  <p>Kriteria</p>
               </router-link>
              </li>
            </ul>
          </li>
           <li class="nav-item">
                <router-link to="/saw" class="nav-link">
                    <i class="nav-icon fas fa-poll"></i><p>SAW</p>
                </router-link>
           </li>
             <li class="nav-item">
                <router-link to="/dashboard" class="nav-link">
                    <i class="nav-icon fas fa-balance-scale-left"></i><p>AHP</p>
                </router-link>
           </li>
           <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa fa-book"></i>
              <p>
                Laporan
               <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../../index.html" class="nav-link">
                  <i class="fas fa-circle  nav-icon"></i>
                  <p>Perangkingan Guru</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../../index.html" class="nav-link">
                  <i class="fas fa-circle  nav-icon"></i>
                  <p>Penilaian Guru</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
             <i class="nav-icon fas fa-envelope-open-text"></i>
              <p>
                Surat Keputusan
                  <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../../index.html" class="nav-link">
                  <i class="fas fa-circle  nav-icon"></i>
                  <p>Perangkingan Guru</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../../index.html" class="nav-link">
                  <i class="fas fa-circle  nav-icon"></i>
                  <p>Penilaian Guru</p>
                </a>
              </li>
            </ul>
          </li>       
          {{-- @if(session('user_login')->kode_role == 1) --}}
           <li class="nav-item">
                <router-link to="/saw" class="nav-link">
                    <i class="nav-icon fas fa-user"></i><p>Users</p>
                </router-link>
           </li>
            {{-- @endif --}}
          </ul>
          

           
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>