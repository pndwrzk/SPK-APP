<template>
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Penilaian Alternatif (Guru)</h1>
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
                                    Daftar Penilaian Alternatif
                                </router-link>
                            </li>

                            <li class="breadcrumb-item active">
                                Penilaian Alternatif
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
                <div class="card">
                    <div class="col-8 m-3">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                Periode
                            </label>

                            <div class="col-sm-10">
                                <datepicker
                                    placeholder="Silahkan pilih periode tahun penilaian"
                                    :bootstrap-styling="true"
                                    minimum-view="year"
                                    name="datepicker"
                                    format="yyyy"
                                    v-model="waktu"
                                    v-bind:class="{
                                        'is-invalid': errors.tahun_penilaian,
                                    }"
                                ></datepicker>

                                <div
                                    v-if="errors.tahun_penilaian"
                                    v-bind:class="{
                                        'invalid-feedback':
                                            errors.tahun_penilaian,
                                    }"
                                >
                                    {{ errors.tahun_penilaian[0] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--  -->

                <div class="card">
                    <div class="card-header">
                        <strong>
                            Penilaian Guru dengan menggunakan metode SAW
                        </strong>
                    </div>

                    <div class="card-body">
                        <p v-if="errors.matriks" class="text-danger text-sm">
                            *{{ errors.matriks }}
                        </p>

                        <div class="table-responsive">
                            <!-- <div class="my-3">
                          <span class="text-sm text-danger">*Silahkan mengisi form kolom di bawah ini</span>
                        </div> -->

                            <form @submit.prevent="getFormValues()">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>

                                            <th
                                                class="text-center"
                                                v-for="(kr, index) in kriteria"
                                            >
                                                {{ kr.nama }}
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr v-for="(al, index) in alternatif">
                                            <td>{{ al.nama }}</td>

                                            <td
                                                v-for="(kr, index) in kriteria"
                                                :key="index"
                                            >
                                                <input
                                                    type="number"
                                                    id="name"
                                                    class="text-center form-matrix"
                                                    min="0"
                                                    name="array[]"
                                                />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <button
                                    type="submit"
                                    class="btn btn-dark mt-3 float-right"
                                    :disabled="disabled"
                                >
                                    <i
                                        v-show="loading"
                                        class="fa fa-spinner fa-spin"
                                    ></i>
                                    Simpan
                                </button>
                            </form>

                            <div class="row mt-4">
                                <router-link class="text-dark" to="/Penilaian">
                                    <i class="fas fa-chevron-left"></i>

                                    <strong>Kembali</strong>
                                </router-link>
                            </div>
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
import Datepicker from "vuejs-datepicker";
export default {
    components: {
        Datepicker,
    },
    data() {
        return {
            loading: false,
            disabled: false,
            kriteria: [],
            alternatif: [],
            bobot: [],
            waktu: " ",
            form: {
                matriks: [],
                kriteria: [],
                alternatif: [],
                tahun_penilaian: "",
            },
            errors: {
                tahun_penilaian: "",
                matriks: "",
            },
        };
    },
    // watch adalah akan menjalan getUser jika ada perubahan pada URL
    watch: {
        $route: "getColumnMatriks",
    },
    // created secara otomatis akan dijalan apabila pages sudah selesai di render
    mounted() {
        this.getColumnMatriks();
    },

    methods: {
        getColumnMatriks() {
            axios.get("/api/get-column-matriks").then((res) => {
                this.kriteria = res.data.kriteria;
                this.alternatif = res.data.alternatif;
                this.bobot = res.data.bobot;

                //  this.guru = responde.data;
            });
        },

        getFormValues() {
            this.loading = true;
            this.disabled = true;
            var input = document.getElementsByName("array[]");
            for (
                let i = 0;
                i < this.kriteria.length * this.alternatif.length;
                i++
            ) {
                this.form.matriks[i] = input[i].value;
            }
            this.form.kriteria = this.kriteria;
            this.form.alternatif = this.alternatif;
            // this.form.tahun_penilaian = parseInt(this.waktu.getFullYear());
            if (this.waktu !== " ") {
                this.form.tahun_penilaian = parseInt(this.waktu.getFullYear());
            }

            axios
                .post("/api/simpan-matriks", this.form)
                .then((res) => {
                    Toast.fire({
                        icon: "success",
                        title: res.data.message,
                    });
                    this.$router.push(
                        "/penilaian/" + res.data.periode + "/hasil"
                    );
                })
                .catch((e) => {
                    this.loading = false;
                    this.disabled = false;
                    if (e.response.status == 500) {
                        this.errors.matriks =
                            "Form matriks penilaian tidak boleh kosong";
                    }

                    this.errors.tahun_penilaian =
                        e.response.data.message.tahun_penilaian;
                });
        },
    },
};
</script>
