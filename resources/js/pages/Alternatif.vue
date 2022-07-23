<template>
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Daftar Data Alternatif ( Guru )</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <!-- <li class="breadcrumb-item"><a href="#">Home</a></li> -->

                            <li class="breadcrumb-item">
                                <router-link to="dashboard">
                                    Dashboard
                                </router-link>
                            </li>

                            <li class="breadcrumb-item active">Alternatif</li>
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
                            <!-- <div class="card-header bg-white">
                 <div class="div ">
                        <button class="btn btn-dark px-3 float-right"><i class="fas fa-plus "></i></button>
                  </div>
              </div> -->

                            <!-- ./card-header -->

                            <div class="card-body">
                                <div class="float-right">
                                    <!-- <a
                                        v-if="alternatif.length != 0"
                                        href="alternatif/export-pdf"
                                        class="btn btn-outline-dark mb-3 mr-2"
                                        target="_blank"
                                    >

                                        <i class="fas fa-print"></i>

                                    </a> -->

                                    <router-link
                                        class="btn btn-dark px-5 float-right mb-3"
                                        :to="{ name: 'tambah-alternatif' }"
                                    >
                                        Tambah Data
                                    </router-link>
                                </div>

                                <div class="" v-if="alternatif.length == 0">
                                    <h5>
                                        <i class="fas fa-info"></i>
                                        Info:
                                    </h5>
                                    Data Alternatif (Guru) tidak tersedia
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

                                                <th>Jenis Kelamin</th>

                                                <th>Opsi</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr
                                                v-for="(
                                                    al, index
                                                ) in alternatif"
                                            >
                                                <td>{{ index + 1 }}</td>

                                                <td>{{ al.kode_guru }}</td>

                                                <td>
                                                    <router-link
                                                        :to="{
                                                            name: 'detail-alternatif',
                                                            params: {
                                                                kode: al.kode_guru,
                                                            },
                                                        }"
                                                    >
                                                        {{ al.nama }}
                                                    </router-link>
                                                </td>

                                                <td>{{ al.jenis_kelamin }}</td>

                                                <td>
                                                    <div
                                                        class="btn-group"
                                                        role="group"
                                                        aria-label="Basic example"
                                                    >
                                                        <router-link
                                                            class="btn btn-outline-dark btn-sm"
                                                            :to="{
                                                                name: 'edit-alternatif',
                                                                params: {
                                                                    kode: al.kode_guru,
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
                                                                deleteAlternatif(
                                                                    al.kode_guru
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
        </section>

        <!-- /.content -->
    </div>

    <!-- /.content-wrapper -->
</template>

<script>
export default {
    data() {
        return {
            alternatif: [],
        };
    },
    // watch adalah akan menjalan getUser jika ada perubahan pada URL
    watch: {
        $route: "getAlternatif",
    },
    // created secara otomatis akan dijalan apabila pages sudah selesai di render
    created() {
        this.getAlternatif();
        Fire.$on("RefreshData", () => {
            this.getAlternatif();
        });
    },

    methods: {
        getAlternatif() {
            axios.get("/api/alternatif").then((res) => {
                this.alternatif = res.data;
            });
        },
        deleteAlternatif(kode) {
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
                    axios
                        .delete("/api/alternatif/" + kode)
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
