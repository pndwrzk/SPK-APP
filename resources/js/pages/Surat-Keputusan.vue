<template>
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Surat Keputusan</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <!-- <li class="breadcrumb-item"><a href="#">Home</a></li> -->

                            <li class="breadcrumb-item">
                                <router-link to="dashboard">
                                    Dashboard
                                </router-link>
                            </li>

                            <li class="breadcrumb-item active">
                                Surat Keputusan
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
                <div class="row">
                    <div class="col-12">
                        <div>
                            <div class="card p-4" v-if="sk.length == 0">
                                <h5>
                                    <i class="fas fa-info"></i>
                                    Info:
                                </h5>
                                Data Surat Keputusan tidak teredia
                            </div>

                            <div class="card" v-else>
                                <div class="card-header">
                                    <b>Daftar Surat Keputusan</b>

                                    <!-- <a
                                        href="/surat-keputusan/export-pdf"
                                        class="btn btn-dark float-right"
                                        target="_blank"
                                    >
                                        <i class="fas fa-print"></i>
                                    </a> -->
                                </div>

                                <div class="card-body">
                                    <form
                                        action="/laporan-hasil-keputusan/export-pdf"
                                        metode="get"
                                    >
                                        <div class="row mb-2">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label
                                                        class="col-form-label"
                                                    >
                                                        Periode Awal
                                                    </label>

                                                    <datepicker
                                                        placeholder="Silahkan pilih periode awal penilaian"
                                                        :bootstrap-styling="
                                                            true
                                                        "
                                                        minimum-view="year"
                                                        name="periode_awal"
                                                        format="yyyy"
                                                    ></datepicker>
                                                </div>
                                            </div>
                                            <span
                                                style="margin-top: 45px"
                                                class="font-weight-bold"
                                                >s.d.</span
                                            >
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label
                                                        class="col-form-label"
                                                    >
                                                        Periode Akhir
                                                    </label>

                                                    <datepicker
                                                        placeholder="Silahkan pilih periode akhir penilaian"
                                                        :bootstrap-styling="
                                                            true
                                                        "
                                                        minimum-view="year"
                                                        name="periode_akhir"
                                                        format="yyyy"
                                                    ></datepicker>
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                <button
                                                    class="btn btn-dark"
                                                    style="margin-top: 37px"
                                                >
                                                    Cetak
                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                    <table
                                        class="table table-bordered table-striped text-center"
                                    >
                                        <thead class="thead-white">
                                            <tr>
                                                <th>#</th>

                                                <th>Kode SK</th>

                                                <th>Periode Penilaian</th>

                                                <th>Tanggal Buat</th>

                                                <th>Guru</th>

                                                <th>Nilai SAW</th>

                                                <th>Opsi</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr v-for="(s, index) in sk">
                                                <td>{{ index + 1 }}</td>

                                                <td>
                                                    {{ s.kode_suratkeputusan }}
                                                </td>

                                                <td>
                                                    {{ s.periode }}
                                                </td>

                                                <td>{{ s.tanggal }}</td>

                                                <td>{{ s.nama }}</td>

                                                <td>{{ s.nilai_saw }}</td>

                                                <td>
                                                    <a
                                                        class="btn btn-outline-dark"
                                                        @click.prevent="
                                                            deleteKeputusan(
                                                                s.kode_suratkeputusan
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="fas fa-trash"
                                                        ></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- /.card -->
                            </div>

                            <!-- ///////////////// -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- /.content -->
    </div>

    <!-- /.content-wrapper -->
</template>

<script>
import Datepicker from "vuejs-datepicker";
export default {
    components: {
        Datepicker,
    },
    data() {
        return {
            sk: "",
        };
    },
    // watch adalah akan menjalan getUser jika ada perubahan pada URL
    watch: {
        $route: "getSK",
    },
    // created secara otomatis akan dijalan apabila pages sudah selesai di render
    mounted() {
        this.getSK();
        Fire.$on("RefreshData", () => {
            this.getSK();
        });
    },

    methods: {
        getSK() {
            axios.get("/api/surat-keputusan").then((res) => {
                this.sk = res.data;
            });
        },
        deleteKeputusan(kode) {
            Swal.fire({
                title: "Hapus Data?",
                text: "Surat keputusan akan dihapus",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
            }).then((res) => {
                if (res.value) {
                    axios.delete("/api/surat-keputusan/" + kode).then((res) => {
                        Fire.$emit("RefreshData");
                        Toast.fire({
                            icon: "success",
                            title: res.data.message,
                        });
                    });
                }
            });
        },
    },
};
</script>
