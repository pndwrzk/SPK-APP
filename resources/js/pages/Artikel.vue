<template>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Daftar Data Artikel</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <!-- <li class="breadcrumb-item"><a href="#">Home</a></li> -->
                            <li class="breadcrumb-item">
                                <router-link to="dashboard"
                                    >Dashboard</router-link
                                >
                            </li>
                            <li class="breadcrumb-item active">Artikel</li>
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
                                    <!-- <a v-if="alternatif.length != 0" href="alternatif/export-pdf" class="btn btn-outline-dark mb-3 mr-2"><i class="fas fa-print"></i></a> -->
                                    <router-link
                                        class="btn btn-dark px-4 float-right mb-3"
                                        :to="{ name: 'tambah-artikel' }"
                                        >Tambah Artikel</router-link
                                    >
                                </div>

                                <!-- <div class=""  v-if="alternatif.length == 0">
                          <h5><i class="fas fa-info "></i> Info:</h5>
                           Data Alternatif (guru) tidak tersedia
           </div> -->
                                <div class="table-responsive">
                                    <table
                                        class="table  table-bordered table-striped text-center"
                                    >
                                        <thead class="thead-white">
                                            <tr>
                                                <th>#</th>
                                                <th>Penerbit/Sumber</th>
                                                <th>Tanggal Terbit</th>
                                                <th>Judul</th>
                                                <th>Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(ar, index) in artikel">
                                                <td>{{ index + 1 }}</td>
                                                <td>
                                                    <a
                                                        v-bind:href="ar.link"
                                                        target="_blank"
                                                        >{{ ar.penerbit }}</a
                                                    >
                                                </td>
                                                <td>{{ ar.tanggal_terbit }}</td>
                                                <td>{{ ar.judul }}</td>
                                                <td>
                                                    <div
                                                        class="btn-group"
                                                        role="group"
                                                        aria-label="Basic example"
                                                    >
                                                        <router-link
                                                            class="btn btn-outline-dark btn-sm"
                                                            :to="{
                                                                name:
                                                                    'detail-artikel',
                                                                params: {
                                                                    kode:
                                                                        ar.kode
                                                                }
                                                            }"
                                                            ><i
                                                                class="fas fa-eye"
                                                            ></i
                                                        ></router-link>
                                                        <router-link
                                                            class="btn btn-outline-dark btn-sm"
                                                            :to="{
                                                                name:
                                                                    'edit-artikel',
                                                                params: {
                                                                    kode:
                                                                        ar.kode
                                                                }
                                                            }"
                                                            ><i
                                                                class="fas fa-edit"
                                                            ></i
                                                        ></router-link>
                                                        <a
                                                            @click.prevent="
                                                                deleteartikel(
                                                                    ar.kode
                                                                )
                                                            "
                                                            class="btn btn-outline-dark btn-sm"
                                                            ><i
                                                                class="fas fa-trash"
                                                            ></i
                                                        ></a>
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
            artikel: []
        };
    },
    // watch adalah akan menjalan getUser jika ada perubahan pada URL
    watch: {
        $route: "getArtikel"
    },
    // created secara otomatis akan dijalan apabila pages sudah selesai di render
    created() {
        this.getArtikel();
        Fire.$on("RefreshData", () => {
            this.getArtikel();
        });
    },

    methods: {
        getArtikel() {
            axios.get("/api/artikel").then(res => {
                this.artikel = res.data;

                //  this.guru = responde.data;
            });
        },
        deleteartikel(kode) {
            Swal.fire({
                title: "Hapus Data?",
                text: "Data yang dihapus akan hilang.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal"
            }).then(res => {
                if (res.value) {
                    axios.delete("/api/artikel/" + kode).then(res => {
                        Fire.$emit("RefreshData");
                        Toast.fire({
                            icon: "success",
                            title: res.data.message
                        });
                    });
                }
            });
        }
    }
};
</script>
