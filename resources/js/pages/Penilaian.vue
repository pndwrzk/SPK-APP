<template>
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Daftar Penilaian Alternatif (Guru)</h1>
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
                                Daftar Penilaian Alternatif
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
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <div>
                                        <router-link
                                            class="btn btn-dark px-5 float-right mb-3"
                                            :to="{ name: 'tambah-penilaian' }"
                                        >
                                            Tambah Penilaian
                                        </router-link>
                                    </div>

                                    <div class="" v-if="penilaian.length == 0">
                                        <h5>
                                            <i class="fas fa-info"></i>
                                            Info:
                                        </h5>
                                        Data Penilaian guru tidak tersedia
                                    </div>

                                    <div class="table-responsive" v-else>
                                        <table
                                            class="table table-bordered table-striped text-center"
                                        >
                                            <thead class="thead-white">
                                                <tr>
                                                    <th>#</th>

                                                    <th>Periode</th>

                                                    <th>Opsi</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr
                                                    v-for="(
                                                        pnl, index
                                                    ) in penilaian"
                                                >
                                                    <td>{{ index + 1 }}</td>

                                                    <td>{{ pnl.periode }}</td>

                                                    <td>
                                                        <div
                                                            class="btn-group"
                                                            role="group"
                                                            aria-label="Basic example"
                                                        >
                                                            <router-link
                                                                class="btn btn-outline-dark btn-sm"
                                                                :to="{
                                                                    name: 'hasil-penilaian',
                                                                    params: {
                                                                        kode: pnl.periode,
                                                                    },
                                                                }"
                                                            >
                                                                <i
                                                                    class="fas fa-eye"
                                                                ></i>
                                                            </router-link>

                                                            <!-- <a
                                                                class="btn btn-outline-dark btn-sm"
                                                                v-bind:href="
                                                                    '/penilaian/' +
                                                                    pnl.periode +
                                                                    '/rangking'
                                                                "
                                                                target="_blank"
                                                            >
                                                                <i
                                                                    class="fas fa-print"
                                                                ></i> -->
                                                            </a>

                                                            <router-link
                                                                class="btn btn-outline-dark btn-sm"
                                                                :to="{
                                                                    name: 'pilih-alternatif-terbaik',
                                                                    params: {
                                                                        kode: pnl.periode,
                                                                    },
                                                                }"
                                                            >
                                                                <span
                                                                    class="text-small"
                                                                >
                                                                    <b>SK</b>
                                                                </span>
                                                            </router-link>

                                                            <a
                                                                class="btn btn-outline-dark btn-sm"
                                                                @click.prevent="
                                                                    deletePenilaian(
                                                                        pnl.periode
                                                                    )
                                                                "
                                                            >
                                                                <i
                                                                    class="fas fa-trash"
                                                                ></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- /.card-body -->
                            </div>

                            <!-- /.card -->
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
export default {
    data() {
        return {
            penilaian: [],
        };
    },
    // watch adalah akan menjalan getUser jika ada perubahan pada URL
    watch: {
        $route: "getPenilaian",
    },
    // created secara otomatis akan dijalan apabila pages sudah selesai di render
    mounted() {
        this.getPenilaian();
        Fire.$on("RefreshData", () => {
            this.getPenilaian();
        });
    },

    methods: {
        getPenilaian() {
            axios.get("/api/penilaian").then((res) => {
                this.penilaian = res.data;
            });
        },
        deletePenilaian(kode) {
            Swal.fire({
                title: "Hapus Data?",
                text: "Data yang dihapus akan hilang.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
            }).then((res) => {
                if (res.value) {
                    axios.delete("/api/penilaian/" + kode).then((res) => {
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
