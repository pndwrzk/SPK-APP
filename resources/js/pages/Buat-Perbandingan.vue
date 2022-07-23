<template>
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Perbandingan Kriteria</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <router-link to="/dashboard">
                                    Dashboard
                                </router-link>
                            </li>

                            <li class="breadcrumb-item active">
                                Tambah Perbandingan Kriteria
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- /.container-fluid -->
        </section>

        <!-- Main content -->

        <section class="content">
            <div class="container-fluid" v-if="bariskolom.length == 0">
                <div class="callout callout-info">
                    <h5>
                        <i class="fas fa-info"></i>
                        Info:
                    </h5>
                    Data Kriteria tidak tersedia, silahkan menambahkan data
                    <router-link to="/kriteria" class="text-primary">
                        Kriteria
                    </router-link>
                    terlebih dahulu
                </div>
            </div>

            <div class="container-fluid" v-else>
                <div class="card" id="btnClick">
                    <div class="card-header">
                        <h3 class="card-title">
                            <strong>
                                Skala Matrik Perbandingan Berpasangan
                            </strong>
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
                        <table class="table table-bordered table-striped">
                            <thead class="thead-white">
                                <tr>
                                    <th>Intensitas Kepentingan</th>

                                    <th>Definisi</th>

                                    <th>Penjelasan</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <th>1</th>

                                    <td>Sama Penting</td>

                                    <td>
                                        Kedua aktifitas menyumbangkan sama pada
                                        tujuan
                                    </td>
                                </tr>

                                <tr>
                                    <th>3</th>

                                    <td>
                                        Agak lebih penting yang satu atas
                                        lainnya
                                    </td>

                                    <td>
                                        Pengalaman dan keputusan menunjukkan
                                        kesukaan atas satu aktifitas lebih dari
                                        yang lain
                                    </td>
                                </tr>

                                <tr>
                                    <th>5</th>

                                    <td>cukup penting</td>

                                    <td>
                                        Pengalaman dan keputusan menunjukkan
                                        kesukaan atas satu aktifitas lebih dari
                                        yang lain
                                    </td>
                                </tr>

                                <tr>
                                    <th>7</th>

                                    <td>Sangat penting</td>

                                    <td>
                                        Pengalaman dan keputusan menunjukkan
                                        kesukaan atas satu aktifitas lebih dari
                                        yang lain
                                    </td>
                                </tr>

                                <tr>
                                    <th>9</th>

                                    <td>kepentingan yang ekstrim</td>

                                    <td>
                                        Bukti menyukai satu aktifitas atas yang
                                        lain sangat kuat
                                    </td>
                                </tr>

                                <tr>
                                    <th>2,4,6,8</th>

                                    <td>
                                        nilai tengah diantara dua nilai
                                        keputusan yang berdekatan
                                    </td>

                                    <td>Bila kompromi dibutuhkan</td>
                                </tr>

                                <tr>
                                    <th>berbalikan</th>

                                    <td>
                                        jika aktifitas i mempunyai nilai yang
                                        lebih tinggi dari aktifitas j maka j
                                        mempunyai nilai berbalikan ketika
                                        dibandingkan dengan
                                    </td>

                                    <td></td>
                                </tr>

                                <tr>
                                    <th>rasio</th>

                                    <td>
                                        rasio yang didapat langsung dari
                                        pengukuran
                                    </td>

                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- /.card-body -->
                </div>

                <!-- <div class="card">
                    <div class="col-8 m-3">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"
                                >Tanggal</label
                            >
                            <div class="col-sm-10">
                                <input
                                    type="date"
                                    class="form-control"
                                    v-bind:class="{
                                        'is-invalid': errors.tanggal
                                    }"
                                    v-model="form.tanggal"
                                    id="inputtanggal"
                                />
                                <div
                                    v-if="errors.tanggal"
                                    v-bind:class="{
                                        'invalid-feedback': errors.tanggal
                                    }"
                                >
                                    {{ errors.tanggal[0] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->

                <div class="card">
                    <div class="table-responsive">
                        <form @submit.prevent="submitBarisKolom()">
                            <table
                                class="table table-borderles table-striped text-center"
                            >
                                <thead class="thead-white">
                                    <tr>
                                        <th>Kriteria</th>

                                        <th>Perbandingan</th>

                                        <th>Kriteria</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="(bk, index) in bariskolom">
                                        <th>{{ bk.baris }}</th>

                                        <td v-if="bk.baris == bk.kolom">
                                            <div class="input-group mb-3">
                                                <input
                                                    type="number"
                                                    name="baris[]"
                                                    class="form-control text-center bg-white"
                                                    min="1"
                                                    max="9"
                                                    value="1"
                                                    readonly
                                                    style="width: 20px"
                                                />

                                                <div
                                                    class="input-group-prepend"
                                                >
                                                    <span
                                                        class="input-group-text"
                                                    >
                                                        Banding
                                                    </span>
                                                </div>

                                                <input
                                                    type="number"
                                                    name="kolom[]"
                                                    class="form-control text-center bg-white"
                                                    value="1"
                                                    min="1"
                                                    max="9"
                                                    readonly
                                                    style="width: 20px"
                                                />
                                            </div>
                                        </td>

                                        <td v-else>
                                            <div class="input-group mb-3">
                                                <input
                                                    type="number"
                                                    name="baris[]"
                                                    class="form-control text-center"
                                                    style="width: 20px"
                                                    min="1"
                                                    max="9"
                                                />

                                                <div
                                                    class="input-group-prepend"
                                                >
                                                    <span
                                                        class="input-group-text"
                                                    >
                                                        Banding
                                                    </span>
                                                </div>

                                                <input
                                                    type="number"
                                                    name="kolom[]"
                                                    class="form-control text-center"
                                                    style="width: 20px"
                                                    min="1"
                                                    max="9"
                                                />
                                            </div>
                                        </td>

                                        <th>{{ bk.kolom }}</th>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="p-4">
                                <button
                                    type="submit"
                                    class="btn btn-dark"
                                    style="width: 100%"
                                    :disabled="disabled"
                                >
                                    <i
                                        v-show="loading"
                                        class="fa fa-spinner fa-spin"
                                    ></i>
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- <div class="row my-2 container" v-if="cekPerbandingan != 0">
                    <router-link class="text-dark" to="/perbandingan/hasil">
                        <i class="fas fa-chevron-left"></i>

                        <strong>Kembali</strong>
                    </router-link>
                </div> -->

                <!-- <div class="row my-2 ml-2">
                    <router-link class=" text-dark" to="/ahp"
                        ><i class="fas fa-chevron-left"></i>
                        <strong>Kembali</strong></router-link
                    >
                </div> -->
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
            loading: false,
            disabled: false,
            bariskolom: [],
            form: {
                baris: [],
                kolom: [],
            },
            cekPerbandingan: "",

            // cardClass: "card"
        };
    },
    // watch adalah akan menjalan getUser jika ada perubahan pada URL
    watch: {
        $route: "getBarisKolom",
    },
    // created secara otomatis akan dijalan apabila pages sudah selesai di render
    mounted() {
        setTimeout(() => {
            document.querySelector(".btn-tool").click();
        }, 2000);
        this.getBarisKolom();
        this.getPerbandingan();
    },

    methods: {
        getBarisKolom() {
            axios.get("/api/kriteria-bariskolom").then((res) => {
                this.bariskolom = res.data;

                //  this.guru = responde.data;
            });
        },
        getPerbandingan() {
            axios.get("/api/perbandingan-kriteria").then((res) => {
                if (res.data != 0) {
                    this.$router.push("/perbandingan/hasil");
                }
            });
        },
        submitBarisKolom() {
            this.loading = true;
            this.disabled = true;
            var inputBaris = document.getElementsByName("baris[]");
            var inputKolom = document.getElementsByName("kolom[]");
            for (let i = 0; i < inputBaris.length; i++) {
                this.form.baris[i] = inputBaris[i].value;
            }
            for (let j = 0; j < inputKolom.length; j++) {
                this.form.kolom[j] = inputKolom[j].value;
            }

            axios
                .post("/api/simpan-perbandingan", this.form)
                .then((res) => {
                    Toast.fire({
                        icon: "success",
                        title: res.data.message,
                    });
                    this.$router.push("/perbandingan/hasil");
                })
                .catch((e) => {
                    // this.errors.tanggal = e.response.data.message.tanggal;
                    this.loading = false;
                    this.disabled = false;
                    Toast.fire({
                        icon: "warning",
                        title: "Perbandingan Antar Kriteria Harus Terisi Lengkap",
                    });
                });
        },
    },
};
</script>
