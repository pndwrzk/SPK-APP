<template>

    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">

        <!-- Content Header (Page header) -->

        <section class="content-header">

            <div class="container-fluid">

                <div class="row mb-2">

                    <div class="col-sm-6">

                        <h1>Detail Alternatif ( Guru )</h1>

                    </div>

                    <div class="col-sm-6">

                        <ol class="breadcrumb float-sm-right">

                            <li class="breadcrumb-item">

                                <router-link to="/dashboard">
                                     Dashboard
                                </router-link>

                            </li>

                            <li class="breadcrumb-item">

                                <router-link to="/alternatif">
                                     Alternatif
                                </router-link>

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

                                <th>Kode</th>

                                <td>:</td>

                                <td>{{ detailAlternatif.kode_guru }}</td>

                            </tr>

                            <tr>

                                <th>NIP</th>

                                <td>:</td>

                                <td> {{ detailAlternatif.nip }} </td>

                            </tr>

                            <tr>

                                <th>Nama</th>

                                <td>:</td>

                                <td>{{ detailAlternatif.nama }}</td>

                            </tr>

                            <tr>

                                <th>Jenis Kelamin</th>

                                <td>:</td>

                                <td>{{ detailAlternatif.jenis_kelamin }}</td>

                            </tr>

                            <tr>

                                <th>Tempat Lahir</th>

                                <td>:</td>

                                <td>{{ detailAlternatif.tempat_lahir }}</td>

                            </tr>

                            <tr>

                                <th>Tanggal Lahir</th>

                                <td>:</td>

                                <td>{{ detailAlternatif.tanggal_lahir }}</td>

                            </tr>

                        </table>

                        <div class="row mt-4 ">

                            <router-link class=" text-dark" to="/alternatif">

                                <i class="fas fa-chevron-left"></i>

                                <strong>Kembali</strong>

                            </router-link>

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
            detailAlternatif: {}
        };
    },
    // created secara otomatis akan dijalan apabila pages sudah selesai di render
    created() {
        this.getguru();
    },

    methods: {
        getguru() {
            axios.get("/api/alternatif/" + this.kode).then(response => {
                this.detailAlternatif = response.data;
            });
        }
    }
};
</script>

