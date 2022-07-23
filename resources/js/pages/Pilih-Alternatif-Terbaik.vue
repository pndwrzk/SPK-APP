<template>
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Pilih Alternatif (Guru) Terbaik</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <!-- <li class="breadcrumb-item"><a href="#">Home</a></li> -->

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
                                Pilih Alternatif Terbaik
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
                        <div class="card" v-if="sk">
                            <div class="card-header">
                                <b>
                                    Surat Keputusan hasil pemilihan guru terbaik
                                    periode {{ sk.periode }}
                                </b>
                                <a
                                    :href="
                                        '/surat-keputusan/' +
                                        sk.kode_hasil +
                                        '/export-pdf'
                                    "
                                    target="_blank"
                                    class="btn btn-dark float-right"
                                >
                                    <i class="fas fa-print fa-solid"></i>
                                </a>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-7">
                                        <table>
                                            <tr>
                                                <th>
                                                    Guru Terbaik pada Surat
                                                    Keputusan dengan kode
                                                    {{ sk.kode_suratkeputusan }}
                                                    :
                                                </th>
                                            </tr>
                                        </table>

                                        <table class="table-sm">
                                            <tr>
                                                <th>NIP</th>

                                                <td>:</td>

                                                <td>{{ sk.nip }}</td>
                                            </tr>

                                            <tr>
                                                <th>Nama</th>

                                                <td>:</td>

                                                <td>{{ sk.nama }}</td>
                                            </tr>

                                            <tr>
                                                <th>Nilai SAW</th>

                                                <td>:</td>

                                                <td>{{ sk.nilai_saw }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- v-else -->

                        <div class="card" v-else>
                            <div class="card-header">
                                <strong
                                    >Hasil Penilaian Periode {{ kode }}</strong
                                >
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table
                                        id="datatable"
                                        class="table table-bordered table-striped text-center"
                                    >
                                        <thead class="bg-dark">
                                            <tr>
                                                <th class="align-middle">#</th>

                                                <th class="align-middle">
                                                    Nama
                                                </th>

                                                <th
                                                    class="align-middle"
                                                    v-for="(
                                                        hk, index
                                                    ) in hasil.kriteria"
                                                >
                                                    {{ hk.nama }}
                                                </th>
                                                <th class="align-middle">
                                                    Nilai SAW
                                                </th>
                                                <th class="align-middle">
                                                    Keterangan
                                                </th>
                                                <th
                                                    class="sorting_disabled align-middle"
                                                >
                                                    Pilih Juara
                                                </th>
                                                <!-- <th>jumlah</th> -->
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr
                                                v-for="(
                                                    hg, index
                                                ) in hasil.hasilAkhir"
                                            >
                                                <td class="align-middle">
                                                    {{ index + 1 }}
                                                </td>

                                                <td>
                                                    {{ hg.nama }}
                                                </td>

                                                <td
                                                    class="align-middle"
                                                    v-for="(
                                                        hn, index
                                                    ) in hasil.nilaiAwal"
                                                    v-if="
                                                        hn.kode_guru ==
                                                        hg.kode_guru
                                                    "
                                                >
                                                    {{ hn.nilai }}
                                                </td>
                                                <td
                                                    class="align-middle"
                                                    v-for="(
                                                        ha, index
                                                    ) in hasil.hasilAkhir"
                                                    v-if="
                                                        ha.kode_guru ==
                                                        hg.kode_guru
                                                    "
                                                >
                                                    {{ ha.nilai_saw }}
                                                </td>
                                                <td
                                                    class="align-middle"
                                                    v-for="(
                                                        ha, index
                                                    ) in hasil.hasilAkhir"
                                                    v-if="
                                                        ha.kode_guru ==
                                                        hg.kode_guru
                                                    "
                                                >
                                                    {{ ha.keterangan }}
                                                </td>
                                                <td
                                                    class="align-middle"
                                                    v-for="(
                                                        ha, index
                                                    ) in hasil.hasilAkhir"
                                                    v-if="
                                                        ha.kode_guru ==
                                                        hg.kode_guru
                                                    "
                                                >
                                                    <a
                                                        :href="
                                                            '/surat-keputusan/' +
                                                            ha.kode_hasil +
                                                            '/buat-keputusan'
                                                        "
                                                        class="btn btn-dark btn-sm"
                                                    >
                                                        <!-- <i
                                                            class="fas fa-check fa-solid"
                                                        ></i> -->
                                                        Pilih
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- /.card -->
                        </div>

                        <div class="row my-2 container">
                            <router-link class="text-dark" to="/penilaian">
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
import $ from "jquery";
import "datatables.net-dt/js/dataTables.dataTables.min.js";
import "datatables.net-dt/css/jquery.dataTables.min.css";
export default {
    props: ["kode"],
    data() {
        return {
            // saw: [],
            hasil: {
                kriteria: [],
                guru: [],
                nilaiAwal: [],
                hasilAkhir: [],
            },
            sk: "",
        };
    },
    // watch adalah akan menjalan getUser jika ada perubahan pada URL
    watch: {
        $route: "getSK",
    },
    // created secara otomatis akan dijalan apabila pages sudah selesai di render
    created() {
        this.getSK();
        this.getHasilAkhir();
    },
    mounted() {
        setTimeout(() => {
            $(document).ready(function () {
                $("#datatable").DataTable({
                    searching: false,
                    paging: false,
                    info: false,
                    aoColumnDefs: [
                        {
                            bSortable: false,
                            aTargets: ["sorting_disabled"],
                        },
                    ],
                });
            });
        }, 2000);
    },

    methods: {
        getHasilAkhir() {
            axios.get("/api/hasil-penilaian/" + this.kode).then((res) => {
                this.hasil.kriteria = res.data.kriteria;
                this.hasil.guru = res.data.guru;
                this.hasil.nilaiAwal = res.data.nilai_awal;
                this.hasil.hasilAkhir = res.data.hasil_akhir;
            });
        },
        getSK() {
            axios.get("/api/surat-keputusan/" + this.kode).then((res) => {
                this.sk = res.data[0];
                console.log(this.sk);
            });
        },
    },
};
</script>
