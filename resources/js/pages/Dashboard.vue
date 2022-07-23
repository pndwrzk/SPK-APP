<template>
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Dashbord</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Layout</a></li> -->

                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- /.container-fluid -->
        </section>

        <!-- Main content -->

        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->

                <div class="row">
                    <!-- ./col -->

                    <div class="col-lg-4 col-6">
                        <!-- small box -->

                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ dashboard.guru }}</h3>

                                <p>Alternatif (Guru)</p>
                            </div>

                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>

                            <router-link
                                to="/alternatif"
                                class="small-box-footer"
                            >
                                More info
                                <i class="fas fa-arrow-circle-right"></i>
                            </router-link>
                        </div>
                    </div>

                    <!-- ./col -->

                    <div class="col-lg-4 col-6">
                        <!-- small box -->

                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ dashboard.kriteria }}</h3>

                                <p>Kriteria</p>
                            </div>

                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>

                            <router-link
                                to="/kriteria"
                                class="small-box-footer"
                            >
                                More info
                                <i class="fas fa-arrow-circle-right"></i>
                            </router-link>
                        </div>
                    </div>

                    <!-- ./col -->

                    <div class="col-lg-4 col-6">
                        <!-- small box -->

                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ dashboard.hasil }}</h3>

                                <p>Penilaian Alternatif</p>
                            </div>

                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>

                            <router-link
                                to="/penilaian"
                                class="small-box-footer"
                            >
                                More info
                                <i class="fas fa-arrow-circle-right"></i>
                            </router-link>
                        </div>
                    </div>
                </div>

                <!-- /.row -->

                <div
                    class="row row-timeline"
                    style="max-height: 400px; overflow-y: auto"
                >
                    <div class="col-lg-12 mx-auto">
                        <h5>
                            <b>Sistem Penunjang Keputusan</b>
                        </h5>

                        <!-- Timeline -->

                        <ul class="timeline">
                            <li
                                class="timeline-item bg-white rounded ml-3 px-4 pt-4 pb-5 shadow"
                                v-for="(ar, index) in artikel"
                            >
                                <div class="timeline-arrow"></div>

                                <h2 class="h5 mb-0">
                                    <b>{{ ar.judul }}</b>
                                </h2>

                                <span class="small text-gray">
                                    <b>Tanggal Terbit</b>
                                    : {{ ar.tanggal_terbit }}
                                </span>

                                <read-more
                                    class="mt-2"
                                    more-str="Baca Selengkapnya"
                                    :text="ar.konten"
                                    link="#"
                                    less-str="Baca Singkat"
                                    :max-chars="250"
                                ></read-more>

                                <div class="float-right">
                                    <p>
                                        {{ ar.pengunggah }}

                                        |
                                        <b>Sumber : </b>

                                        <a
                                            v-bind:href="ar.link"
                                            target="_blank"
                                        >
                                            {{ ar.penerbit }}
                                        </a>
                                    </p>
                                </div>
                            </li>
                        </ul>

                        <!-- End -->
                    </div>
                </div>
            </div>
        </section>

        <!-- /.content -->
    </div>

    <!-- /.content-wrapper -->
</template>

<script>
export default {
    data() {
        return {
            dashboard: [],
            artikel: [],
            readMoreActivated: false,
        };
    },
    watch: {
        $route: "getDataDashboard",
    },

    created() {
        this.getDataDashboard();
    },

    methods: {
        getDataDashboard() {
            axios.get("/api/data-dashboard").then((res) => {
                this.dashboard = res.data;

                this.artikel = res.data.artikel;
            });
        },
        handleread() {
            this.readMoreActivated = true;
        },
        handleread1() {
            this.readMoreActivated = false;
        },
        konten(konten) {
            return konten.innerHTML;
        },
    },
};
</script>
