<template>
    <!-- Main Sidebar Container -->

    <aside class="main-sidebar sidebar-light-primary elevation-4">
        <!-- Brand Logo -->

        <router-link to="/dashboard" class="brand-link">
            <img src="/images/tut_wuri_handayani.png" class="brand-image" />

            <span class="brand-text font-weight-bold">SDN JURUMUDI 1</span>
        </router-link>

        <!-- Sidebar -->

        <div class="sidebar">
            <nav class="mt-2">
                <ul
                    class="nav nav-pills nav-sidebar flex-column"
                    data-widget="treeview"
                    role="menu"
                    data-accordion="false"
                >
                    <li class="nav-item">
                        <router-link to="/dashboard" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>

                            <p>Dashboard</p>
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
                                <router-link to="/kriteria" class="nav-link">
                                    <i class="fas fa-circle nav-icon"></i>

                                    <p>Kriteria</p>
                                </router-link>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link to="/alternatif" class="nav-link">
                                    <i class="fas fa-circle nav-icon"></i>

                                    <p>Alternatif</p>
                                </router-link>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item" style="cursor: pointer">
                        <a class="nav-link" @click.prevent="cekAhp()">
                            <i class="nav-icon fas fa-balance-scale-left"></i>

                            <p>Pembobotan Kriteria</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <router-link to="/penilaian" class="nav-link">
                            <i class="nav-icon fas fa-poll"></i>

                            <!-- <i class="nav-icon"
                                ><b style="font-size: 12px">(SAW)</b></i
                            > -->

                            <p>Penilaian Alternatif</p>
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-envelope-open-text"></i>

                            <p>
                                Laporan
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link
                                    to="/laporan-penilaian-alternatif"
                                    class="nav-link"
                                >
                                    <i class="fas fa-circle nav-icon"></i>

                                    <p>Penilaian Alternatif</p>
                                </router-link>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link
                                    to="/laporan-perangkingan-alternatif"
                                    class="nav-link"
                                >
                                    <i class="fas fa-circle nav-icon"></i>

                                    <p>Perangkingan Alternatif</p>
                                </router-link>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link
                                    to="/surat-keputusan"
                                    class="nav-link"
                                >
                                    <i class="fas fa-circle nav-icon"></i>

                                    <p>Surat Keputusan</p>
                                </router-link>
                            </li>
                        </ul>
                    </li>

                    <!-- <li class="nav-item">
                        <router-link to="/artikel" class="nav-link">
                            <i class="nav-icon fas fa-newspaper"></i>

                            <p>Artikel</p>
                        </router-link>
                    </li> -->
                </ul>
            </nav>

            <!-- /.sidebar-menu -->
        </div>

        <!-- /.sidebar -->
    </aside>
</template>

<script>
export default {
    data() {
        return {
            userLogin: "",
        };
    },

    created() {
        this.getUserLogin();
    },
    methods: {
        getUserLogin() {
            var userLogin = document.getElementById("userlogin").value;
            axios.get("/api/user/" + userLogin).then((res) => {
                this.userLogin = res.data;

                //  this.karyawan = responde.data;
            });
        },
        cekAhp() {
            axios.get("/api/perbandingan-kriteria").then((res) => {
                console.log(res.data);
                if (res.data !== 0) {
                    this.$router.push("/perbandingan/hasil");
                } else {
                    this.$router.push("/perbandingan/buat");
                }
            });
        },
    },
};
</script>
