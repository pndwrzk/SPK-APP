<template>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Detail Artikel</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <router-link to="/dashboard"
                                    >Dashboard</router-link
                                >
                            </li>
                            <li class="breadcrumb-item">
                                <router-link to="/artikel">Artikel</router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                Detail Alternatif
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
                <div class="card col-lg-8 col-sm-12 mb-5">
                    <div class="card-body">
                        <table class="table-sm">
                            <tr>
                                <th>Penerbit</th>
                                <td>:</td>
                                <td>
                                    <a v-bind:href="detailartikel.link">{{
                                        detailartikel.penerbit
                                    }}</a>
                                </td>
                            </tr>
                            <tr>
                                <th>Tanggal Terbit</th>
                                <td>:</td>
                                <td>{{ detailartikel.tanggal_terbit }}</td>
                            </tr>
                            <tr>
                                <th>Judul</th>
                                <td>:</td>
                                <td>{{ detailartikel.judul }}</td>
                            </tr>
                            <tr>
                                <th>Artikel</th>
                                <td>:</td>
                                <td>{{ detailartikel.konten }}</td>
                            </tr>
                        </table>

                        <div class="row mt-4 ">
                            <router-link class=" text-dark" to="/artikel"
                                ><i class="fas fa-chevron-left"></i>
                                <strong>Kembali</strong></router-link
                            >
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
    // nama props harus sesuai dengan nama parameter
    props: ["kode"],
    data() {
        return {
            detailartikel: {}
        };
    },
    // created secara otomatis akan dijalan apabila pages sudah selesai di render
    created() {
        this.getartikel();
    },

    methods: {
        getartikel() {
            axios.get("/api/artikel/" + this.kode).then(response => {
                this.detailartikel = response.data;
            });
        }
    }
};
</script>
