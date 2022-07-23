<template>
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Laporan Penilaian Alternatif (Guru)</h1>
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
                                Laporan Penilaian Alternatif
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
                                    <div class="" v-if="penilaian.length == 0">
                                        <h5>
                                            <i class="fas fa-info"></i>
                                            Info:
                                        </h5>
                                        Penilaian alternatif Belum Pernah
                                        Dilakukan
                                    </div>

                                    <div v-else>
                                        <form
                                            class="form-horizontal"
                                            method="POST"
                                            @submit.prevent="handleSubmit"
                                        >
                                            <label for="inputjenis_kelamin">
                                                Pilih Periode
                                            </label>
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <div class="form-group">
                                                        <select
                                                            class="form-control"
                                                            id="inputperiode"
                                                            v-model="
                                                                form.periode
                                                            "
                                                        >
                                                            <option
                                                                disabled
                                                                value=""
                                                            >
                                                                --Pilih--
                                                            </option>
                                                            <option
                                                                v-for="(
                                                                    pnl, index
                                                                ) in penilaian"
                                                            >
                                                                {{
                                                                    pnl.periode
                                                                }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <button
                                                        type="submit"
                                                        class="btn btn-dark"
                                                    >
                                                        Preview
                                                    </button>

                                                    <a
                                                        @click.prevent="
                                                            resetPeriode()
                                                        "
                                                        class="btn btn-outline-dark ml-2"
                                                    >
                                                        <i
                                                            class="fas fa-undo"
                                                        ></i
                                                    ></a>
                                                </div>
                                            </div>
                                        </form>
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

        <section class="content" v-if="hasil.hasilAkhir.length != 0">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <b
                            >Hasil Penilaian Alternatif Periode
                            {{ form.periode }}</b
                        >

                        <a
                            :href="
                                '/laporan-penilaian/' +
                                form.periode +
                                '/export-pdf'
                            "
                            class="btn btn-dark float-right"
                            target="_blank"
                        >
                            <i class="fas fa-print"></i>
                        </a>
                    </div>

                    <div class="card-body">
                        <table
                            class="table table-bordered table-striped text-center"
                        >
                            <thead class="thead-white">
                                <tr>
                                    <th>#</th>

                                    <th>Nama</th>

                                    <th v-for="(hk, index) in hasil.kriteria">
                                        {{ hk.nama }}
                                    </th>
                                    <th>Nilai SAW</th>

                                    <!-- <th>jumlah</th> -->
                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="(hg, index) in hasil.guru">
                                    <td>
                                        {{ index + 1 }}
                                    </td>

                                    <td>
                                        {{ hg.nama }}
                                    </td>

                                    <td
                                        v-for="(hn, index) in hasil.nilaiAwal"
                                        v-if="hn.kode_guru == hg.kode_guru"
                                    >
                                        {{ hn.nilai }}
                                    </td>
                                    <td
                                        v-for="(ha, index) in hasil.hasilAkhir"
                                        v-if="ha.kode_guru == hg.kode_guru"
                                    >
                                        {{ ha.nilai_saw }}
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

            form: {
                periode: "",
            },
            hasil: {
                kriteria: [],
                guru: [],
                nilaiAwal: [],
                hasilAkhir: [],
            },
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
        handleSubmit() {
            axios
                .get("/api/hasil-penilaian/" + this.form.periode)
                .then((res) => {
                    this.hasil.kriteria = res.data.kriteria;
                    this.hasil.guru = res.data.guru;
                    this.hasil.nilaiAwal = res.data.nilai_awal;
                    this.hasil.hasilAkhir = res.data.hasil_akhir;
                });
        },
        resetPeriode() {
            this.form.periode = "";
            this.hasil.kriteria = "";
            this.hasil.guru = "";
            this.hasil.nilaiAwal = "";
            this.hasil.hasilAkhir = "";
        },
    },
};
</script>
