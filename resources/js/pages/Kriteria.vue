<template>
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Daftar Data Kriteria</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <!-- <li class="breadcrumb-item"><a href="#">Home</a></li> -->

                            <li class="breadcrumb-item">
                                <router-link to="dashboard">
                                    Dashboard
                                </router-link>
                            </li>

                            <li class="breadcrumb-item active">Kriteria</li>
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
                                    <div class="float-right">
                                        <!-- <a
                                            v-if="kriteria.length != 0"
                                            href="kriteria/export-pdf"
                                            target="_blank"
                                            class="btn btn-outline-dark mb-3 mr-2"
                                        >

                                            <i
                                                class="fas fa-print"
                                                target="_blank"
                                            ></i>

                                        </a> -->

                                        <router-link
                                            class="btn btn-dark px-5 mb-3"
                                            :to="{ name: 'tambah-kriteria' }"
                                        >
                                            Tambah Data
                                        </router-link>
                                    </div>

                                    <div class="" v-if="kriteria.length == 0">
                                        <h5>
                                            <i class="fas fa-info"></i>
                                            Info:
                                        </h5>
                                        Data kriteria tidak tersedia
                                    </div>

                                    <div class="table-responsive" v-else>
                                        <table
                                            class="table table-bordered table-striped text-center"
                                        >
                                            <thead class="thead-white">
                                                <tr>
                                                    <th>#</th>

                                                    <th>Kode</th>

                                                    <th>Nama</th>

                                                    <th>Atribut</th>

                                                    <th>Bobot</th>

                                                    <th>Opsi</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr
                                                    v-for="(
                                                        kr, index
                                                    ) in kriteria"
                                                >
                                                    <td>{{ index + 1 }}</td>

                                                    <td>
                                                        {{ kr.kode_kriteria }}
                                                    </td>

                                                    <td>{{ kr.nama }}</td>

                                                    <td>{{ kr.atribut }}</td>

                                                    <td v-if="kr.bobot">
                                                        {{ kr.bobot }}
                                                    </td>

                                                    <td v-else>-</td>

                                                    <td>
                                                        <div
                                                            class="btn-group"
                                                            role="group"
                                                            aria-label="Basic example"
                                                        >
                                                            <router-link
                                                                class="btn btn-outline-dark btn-sm"
                                                                :to="{
                                                                    name: 'edit-kriteria',
                                                                    params: {
                                                                        kode: kr.kode_kriteria,
                                                                    },
                                                                }"
                                                            >
                                                                <i
                                                                    class="fas fa-edit"
                                                                ></i>
                                                            </router-link>

                                                            <a
                                                                class="btn btn-outline-dark btn-sm"
                                                                @click.prevent="
                                                                    deleteKriteria(
                                                                        kr.kode_kriteria
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
            kriteria: [],
        };
    },
    // watch adalah akan menjalan getUser jika ada perubahan pada URL
    watch: {
        $route: "getKriteria",
    },
    // created secara otomatis akan dijalan apabila pages sudah selesai di render
    created() {
        this.getKriteria();
        Fire.$on("RefreshData", () => {
            this.getKriteria();
        });
    },

    methods: {
        getKriteria() {
            axios.get("/api/kriteria").then((res) => {
                this.kriteria = res.data;
                //  this.guru = responde.data;
            });
        },

        deleteKriteria(kode) {
            Swal.fire({
                title: "Hapus Data?",
                text: "Data yang dihapus akan hilang juga di penilaian.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
            }).then((res) => {
                if (res.value) {
                    axios
                        .delete("/api/kriteria/" + kode)
                        .then((res) => {
                            Fire.$emit("RefreshData");
                            Toast.fire({
                                icon: "success",
                                title: res.data.message,
                            });
                        })
                        .catch((e) => {
                            Toast.fire({
                                icon: "warning",
                                title: e.response.data.message,
                            });
                        });
                }
            });
        },
    },
};
</script>
