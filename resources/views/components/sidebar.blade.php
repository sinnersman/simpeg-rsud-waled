<div>
    <nav class="sidebar">
        <div class="sidebar-header">
            <a href="#" class="sidebar-brand">
                {{ env('APP_TITLE') }} <span class=""></span>
            </a>
            <div class="sidebar-toggler">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <div class="sidebar-body">
            <ul class="nav" id="sidebarNav">
                <li class="nav-item nav-category">Main</li>
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}" class="nav-link">
                        <i class="link-icon" data-lucide="box"></i>
                        <span class="link-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#ePersonal" role="button" aria-expanded="false" aria-controls="ePersonal">
                        <i class="link-icon" data-lucide="users"></i>
                        <span class="link-title">E-Personal</span>
                        <i class="link-arrow" data-lucide="chevron-down"></i>
                    </a>
                    <div class="collapse" data-bs-parent="#sidebarNav" id="ePersonal">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="{{ route('pegawai.index') }}" class="nav-link">Data Pegawai</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/advanced-ui/owl-carousel.html" class="nav-link">Dokumen Karyawan</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item nav-category">Pengaturan</li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#manajemenAkun" role="button" aria-expanded="false" aria-controls="manajemenAkun">
                        <i class="link-icon" data-lucide="users"></i>
                        <span class="link-title">Manajemen Akun</span>
                        <i class="link-arrow" data-lucide="chevron-down"></i>
                    </a>
                    <div class="collapse" data-bs-parent="#sidebarNav" id="manajemenAkun">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="pages/advanced-ui/cropper.html" class="nav-link">List Pengguna</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/advanced-ui/owl-carousel.html" class="nav-link">Hak Akses</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#Master" role="button" aria-expanded="false" aria-controls="Master">
                        <i class="link-icon" data-lucide="database"></i>
                        <span class="link-title">Master</span>
                        <i class="link-arrow" data-lucide="chevron-down"></i>
                    </a>
                    <div class="collapse" data-bs-parent="#sidebarNav" id="Master">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="{{ route('jabatan.index') }}" class="nav-link">Data Jabatan</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/advanced-ui/owl-carousel.html" class="nav-link">Data Unit Kerja</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('induk_unit_kerja.index') }}" class="nav-link">Data Induk Unit Kerja</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</div>