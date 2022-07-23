<template>
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ "Hasil Perbandingan Kriteria " }}</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <router-link to="/dashboard">
                                    Dashboard
                                </router-link>
                            </li>

                            <li class="breadcrumb-item active">
                                Hasil Perbandingan
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- /.container-fluid -->
        </section>

        <!-- Main content -->

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <strong>Matriks Perbandingan Awal</strong>
                        </h3>

                        <div class="card-tools">
                            <button
                                type="button"
                                class="btn btn-tool"
                                data-card-widget="collapse"
                                title="Collapse"
                            >
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <table
                            class="table table-bordered table-striped text-center"
                        >
                            <thead class="thead-white">
                                <tr>
                                    <th>Kriteria</th>

                                    <th v-for="(kr, index) in kriteria">
                                        {{ kr.nama }}
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="(kr, index) in kriteria">
                                    <th>{{ kr.nama }}</th>

                                    <td
                                        v-for="(mp, index) in matriksAwal"
                                        v-if="
                                            mp.kode_kriteria == kr.kode_kriteria
                                        "
                                    >
                                        {{ mp.nilai }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- /.card-body -->
                </div>

                <!-- /.card -->

                <!-- Default box -->

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <strong>Matriks Nilai Perbandingan</strong>
                        </h3>

                        <div class="card-tools">
                            <button
                                type="button"
                                class="btn btn-tool"
                                data-card-widget="collapse"
                                title="Collapse"
                            >
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table
                                class="table table-bordered table-striped text-center"
                            >
                                <thead class="thead-white">
                                    <tr>
                                        <th>Kriteria</th>

                                        <th v-for="(kr, index) in kriteria">
                                            {{ kr.nama }}
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="(kr, index) in kriteria">
                                        <th>{{ kr.nama }}</th>

                                        <td
                                            v-for="(
                                                mp, index
                                            ) in matriksPerbandingan"
                                            v-if="
                                                mp.kode_kriteria ==
                                                kr.kode_kriteria
                                            "
                                        >
                                            {{ mp.nilai }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Jumlah</th>

                                        <td v-for="(t, index) in total">
                                            <b> {{ t.jumlah }}</b>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- /.card-body -->
                </div>

                <!-- /.card -->

                <!-- Default box -->

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <strong>Normalisasi dan Eigen</strong>
                        </h3>

                        <div class="card-tools">
                            <button
                                type="button"
                                class="btn btn-tool"
                                data-card-widget="collapse"
                                title="Collapse"
                            >
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table
                                class="table table-bordered table-striped text-center"
                            >
                                <thead class="thead-white">
                                    <tr>
                                        <th>Kriteria</th>

                                        <th v-for="(kr, index) in kriteria">
                                            {{ kr.nama }}
                                        </th>

                                        <th>Jumlah Baris</th>

                                        <th>Eigen</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="(kr, index) in kriteria">
                                        <th>{{ kr.nama }}</th>

                                        <td
                                            v-for="(
                                                mn, index
                                            ) in matriksNormalisasi"
                                            v-if="
                                                mn.kode_kriteria ==
                                                kr.kode_kriteria
                                            "
                                        >
                                            {{ mn.nilai }}
                                        </td>

                                        <td
                                            v-for="(e, index) in bobotPrioritas"
                                            v-if="
                                                e.kode_kriteria ==
                                                kr.kode_kriteria
                                            "
                                        >
                                            {{ e.jumlah_baris }}
                                        </td>

                                        <td
                                            v-for="(e, index) in bobotPrioritas"
                                            v-if="
                                                e.kode_kriteria ==
                                                kr.kode_kriteria
                                            "
                                        >
                                            {{ e.bobot }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td
                                            v-for="(kr, index) in kriteria"
                                        ></td>

                                        <td></td>

                                        <th>{{ total_jumlah_baris }}</th>

                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- /.card-body -->
                </div>

                <!-- /.card -->

                <!-- Default box -->

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <strong>Hasil Cek Nilai Konsistensi</strong>
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <!-- <tr>
                                    <th width="30%">Consistency Measure</th>
                                    <td class="text-center" width="5%">:</td>
                                    <td width="65%">
                                        <span v-for="(c, index) in cm">
                                            [{{ c.cm }}]
                                        </span>
                                    </td>
                                </tr> -->
                                <tr>
                                    <th width="30%">Consistency Vector</th>

                                    <td class="text-center" width="5%">:</td>

                                    <td>
                                        <span v-for="(c, index) in cm">
                                            [{{ c.cm }}]
                                        </span>
                                    </td>
                                </tr>

                                <tr>
                                    <th width="30%">
                                        Rata-Rata Consistency Vector
                                    </th>

                                    <td class="text-center" width="5%">:</td>

                                    <td>{{ averageCm }}</td>
                                </tr>

                                <tr>
                                    <th width="30%">Consistency Index</th>

                                    <td class="text-center" width="5%">:</td>

                                    <td>{{ ci }}</td>
                                </tr>

                                <tr>
                                    <th>Consistency Ratio</th>

                                    <td class="text-center">:</td>

                                    <td>{{ result }}</td>
                                </tr>

                                <tr>
                                    <th><strong>Hasil Konsistensi</strong></th>

                                    <td class="text-center">:</td>

                                    <th>{{ cekResult }}</th>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- /.card-body -->
                </div>

                <!-- /.card -->

                <a
                    @click.prevent="hapusPerbandingan()"
                    class="btn btn-dark mb-3"
                    style="width: 100%"
                    :disabled="disabled"
                >
                    <i v-show="loading" class="fa fa-spinner fa-spin"></i>
                    Reset
                </a>
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
            loading: false,
            disabled: false,
            kriteria: [],
            matriksPerbandingan: [],
            matriksAwal: [],
            total: "",
            matriksNormalisasi: [],
            bobotPrioritas: [],
            cm: [],
            ci: "",
            result: "",
            total_jumlah_baris: "",
            averageCm: "",
        };
    },
    watch: {
        $route: "getHasilPerbandingan",
    },
    // created secara otomatis akan dijalan apabila pages sudah selesai di render
    mounted() {
        this.getHasilPerbandingan();
    },

    methods: {
        getHasilPerbandingan() {
            axios
                .get("/api/hasil-perbandingan")
                .then((res) => {
                    console.log(res.data);
                    this.kriteria = res.data.kriteria;
                    this.matriksPerbandingan = res.data.matriks_perbandingan;
                    this.cm = res.data.cm;
                    this.total = res.data.jumlah;
                    this.matriksAwal = res.data.matriks_awal;
                    this.matriksNormalisasi = res.data.matriks_normalisasi;
                    this.bobotPrioritas = res.data.bobot_prioritas;
                    this.averageCm = res.data.average_cm;
                    this.ci = res.data.ci;
                    this.result = res.data.result;
                    this.total_jumlah_baris = res.data.total_jumlah_baris;
                })
                .catch((e) => {
                    this.$router.push("/perbandingan/buat");
                });
        },
        hapusPerbandingan() {
            this.loading = true;
            this.disabled = true;
            axios.delete("/api/hasil-perbandingan").then((res) => {
                Toast.fire({
                    icon: "success",
                    title: res.data.message,
                });
                this.loading = false;
                this.disabled = false;
                this.$router.push("/perbandingan/buat");
            });
        },
    },
    computed: {
        JumlahKriteria: function () {
            return this.kriteria.length;
        },
        cekResult: function () {
            if (this.result < 0.1) {
                return "Konsisten";
            } else {
                return "Tidak Konsisten";
            }
        },
    },
};
</script>
