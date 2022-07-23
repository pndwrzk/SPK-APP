<template>
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ "Hasil Penilaian Periode " + kode }}</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <router-link to="/dashboard">
                                    Dashboard
                                </router-link>
                            </li>

                            <li class="breadcrumb-item">
                                <router-link to="/penilaian">
                                    Penilaian
                                </router-link>
                            </li>

                            <li class="breadcrumb-item active">
                                Hasil Penilaian
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
                <div class="table-responsive">
                    <!-- Default box -->

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <strong>Nilai Guru Pada Setiap Kriteria</strong>
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
                                        <th>#</th>

                                        <th>Nama</th>

                                        <th
                                            v-for="(
                                                hk, index
                                            ) in hasil.kriteria"
                                        >
                                            {{ hk.nama }}
                                        </th>

                                        <!-- <th>jumlah</th> -->
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="(hg, index) in hasil.guru">
                                        <td>{{ index + 1 }}</td>

                                        <td>{{ hg.nama }}</td>

                                        <td
                                            v-for="(
                                                hn, index
                                            ) in hasil.nilaiAwal"
                                            v-if="hn.kode_guru == hg.kode_guru"
                                        >
                                            {{ hn.nilai }}
                                        </td>

                                        <!-- <td
                                            v-for="(hj, index) in hasil.jumlah"
                                            v-if="hj.kode_guru == hg.kode_guru"
                                        >
                                            {{ hj.jumlah }}
                                        </td> -->
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- /.card-body -->
                    </div>

                    <!-- /.card -->

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <strong>Matriks Normalisasi</strong>
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
                                        <th>#</th>

                                        <th>Nama</th>

                                        <th
                                            v-for="(
                                                hk, index
                                            ) in hasil.kriteria"
                                        >
                                            {{ hk.nama }}
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="(hg, index) in hasil.guru">
                                        <td>{{ index + 1 }}</td>

                                        <td>{{ hg.nama }}</td>

                                        <td
                                            v-for="(
                                                hn, index
                                            ) in hasil.nilaiMatriks"
                                            v-if="hn.kode_guru == hg.kode_guru"
                                        >
                                            {{ hn.nilai }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th colspan="2">Bobot</th>

                                        <th
                                            v-for="(
                                                hk, index
                                            ) in hasil.kriteria"
                                        >
                                            {{ hk.bobot }}
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- /.card-body -->
                    </div>

                    <!-- /.card -->

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <strong>Perangkingan</strong>
                            </h3>

                            <!-- <div class="card-tools">
                                <button
                                    type="button"
                                    class="btn btn-tool"
                                    data-card-widget="collapse"
                                    title="Collapse"
                                >
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div> -->
                        </div>

                        <div class="card-body">
                            <table
                                class="table table-bordered table-striped text-center"
                            >
                                <thead class="thead-white">
                                    <tr>
                                        <th>#</th>

                                        <th>Nama</th>

                                        <!-- <th>Total Poin</th> -->

                                        <th>Nilai SAW</th>

                                        <th>Keterangan</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="(hh, index) in hasil.hasilAkhir">
                                        <td>{{ index + 1 }}</td>

                                        <td>{{ hh.nama }}</td>

                                        <!-- <td>{{ hh.jumlah }}</td> -->

                                        <td>{{ hh.nilai_saw }}</td>

                                        <td>{{ hh.keterangan }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- /.card-body -->
                    </div>

                    <!-- /.card -->
                </div>

                <div class="row mb-2 container">
                    <router-link class="text-dark" to="/Penilaian">
                        <i class="fas fa-chevron-left"></i>

                        <strong>Kembali</strong>
                    </router-link>
                </div>
            </div>
        </section>

        <!-- /.content -->
    </div>

    <!-- /.content-wrapper -->
</template>

<script>
export default {
    props: ["kode"],
    data() {
        return {
            hasil: {
                kriteria: [],
                guru: [],
                nilaiAwal: [],
                hasilMatriks: [],
                hasilAkhir: [],
            },
        };
    },
    // watch adalah akan menjalan getUser jika ada perubahan pada URL
    watch: {
        $route: "getHasilPenilaian",
    },
    // created secara otomatis akan dijalan apabila pages sudah selesai di render
    mounted() {
        this.getHasilPenilaian();
    },

    methods: {
        getHasilPenilaian() {
            axios.get("/api/hasil-penilaian/" + this.kode).then((res) => {
                this.hasil.kriteria = res.data.kriteria;
                this.hasil.guru = res.data.guru;
                this.hasil.nilaiAwal = res.data.nilai_awal;
                this.hasil.nilaiMatriks = res.data.nilai_matriks;
                this.hasil.hasilAkhir = res.data.hasil_akhir;
            });
        },
    },
};
</script>
