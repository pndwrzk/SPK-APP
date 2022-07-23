<template>

    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">

        <!-- Content Header (Page header) -->

        <section class="content-header">

            <div class="container-fluid">

                <div class="row mb-2">

                    <div class="col-sm-6">

                        <h1>Edit Alternatif ( Guru )</h1>

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
                                 Edit Alternatif
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

                <div class="card col-lg-10 col-sm-12">

                    <div class="card-body">

                        <form
                            class="form-horizontal"
                            method="POST"
                            @submit.prevent="handleUpdate"
                        >

                            <div class="form-group row">

                                <label
                                    for="inputnip"
                                    class="col-sm-2 col-form-label"
                                >
                                     NIP
                                </label>

                                <div class="col-sm-10">

                                    <input
                                        type="text"
                                        class="form-control"
                                        v-bind:class="{
                                            'is-invalid': errors.nip
                                        }"
                                        v-model="form.nip"
                                        id="inputnip"
                                        placeholder="NIP"
                                    />

                                    <div
                                        v-if="errors.nip"
                                        v-bind:class="{
                                            'invalid-feedback': errors.nip
                                        }"
                                    >
                                         {{ errors.nip[0] }}
                                    </div>

                                </div>

                            </div>

                            <div class="form-group row">

                                <label
                                    for="inputNama"
                                    class="col-sm-2 col-form-label"
                                >
                                     Nama
                                </label>

                                <div class="col-sm-10">

                                    <input
                                        type="text"
                                        class="form-control"
                                        v-bind:class="{
                                            'is-invalid': errors.nama
                                        }"
                                        v-model="form.nama"
                                        id="inputNama"
                                        placeholder="Nama Lengkap"
                                    />

                                    <div
                                        v-if="errors.nama"
                                        v-bind:class="{
                                            'invalid-feedback': errors.nama
                                        }"
                                    >
                                         {{ errors.nama[0] }}
                                    </div>

                                </div>

                            </div>

                            <div class="form-group row">

                                <label
                                    for="inputjenis_kelamin"
                                    class="col-sm-2 col-form-label"
                                >
                                     Jenis Kelamin
                                </label>

                                <div class="col-sm-10">

                                    <select
                                        class="form-control"
                                        v-bind:class="{
                                            'is-invalid': errors.jenis_kelamin
                                        }"
                                        v-model="form.jenis_kelamin"
                                        id="inputjenis_kelamin"
                                    >

                                        <option value="Laki-laki">
                                             Laki-laki
                                        </option>

                                        <option value="Perempuan">
                                             Perempuan
                                        </option>

                                    </select>

                                    <div
                                        v-if="errors.jenis_kelamin"
                                        v-bind:class="{
                                            'invalid-feedback':
                                                errors.jenis_kelamin
                                        }"
                                    >
                                         {{ errors.jenis_kelamin[0] }}
                                    </div>

                                </div>

                            </div>

                            <div class="form-group row">

                                <label
                                    for="inputtempat_lahir"
                                    class="col-sm-2 col-form-label"
                                >
                                     Tempat Lahir
                                </label>

                                <div class="col-sm-10">

                                    <input
                                        type="text"
                                        class="form-control"
                                        v-bind:class="{
                                            'is-invalid': errors.tempat_lahir
                                        }"
                                        v-model="form.tempat_lahir"
                                        id="inputtempat_lahir"
                                        placeholder="Tempat Lahir"
                                    />

                                    <div
                                        v-if="errors.tempat_lahir"
                                        v-bind:class="{
                                            'invalid-feedback':
                                                errors.tempat_lahir
                                        }"
                                    >
                                         {{ errors.tempat_lahir[0] }}
                                    </div>

                                </div>

                            </div>

                            <div class="form-group row">

                                <label
                                    for="inputtanggal_lahir"
                                    class="col-sm-2 col-form-label"
                                >
                                     Tanggal Lahir
                                </label>

                                <div class="col-sm-10">

                                    <input
                                        type="date"
                                        class="form-control"
                                        v-bind:class="{
                                            'is-invalid': errors.tanggal_lahir
                                        }"
                                        v-model="form.tanggal_lahir"
                                        id="inputtanggal_lahir"
                                        placeholder="tanggal_lahir"
                                    />

                                    <div
                                        v-if="errors.tanggal_lahir"
                                        v-bind:class="{
                                            'invalid-feedback':
                                                errors.tanggal_lahir
                                        }"
                                    >
                                         {{ errors.tanggal_lahir[0] }}
                                    </div>

                                </div>

                            </div>

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

                        <div class="row mt-5">

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
    props: ["kode"],
    data() {
        return {
            loading: false,
            disabled: false,
            form: {
                nama: "",
                alamat: "",
                jenis_kelamin: "",
                tempat_lahir: "",
                tanggal_lahir: "",
                nip: ""
            },
            errors: {}
        };
    },
    created() {
        this.getAlternatif();
    },

    methods: {
        getAlternatif() {
            axios.get("/api/alternatif/" + this.kode).then(response => {
                this.form.nama = response.data.nama;
                this.form.nip = response.data.nip;
                this.form.jenis_kelamin = response.data.jenis_kelamin;
                this.form.tempat_lahir = response.data.tempat_lahir;
                this.form.tanggal_lahir = response.data.tanggal_lahir;
            });
        },
        handleUpdate() {
            this.loading = true;
            this.disabled = true;
            axios
                .put("/api/alternatif/" + this.kode, this.form)
                .then(response => {
                    if (response.status == 200) {
                        Toast.fire({
                            icon: "success",
                            title: response.data.message
                        });

                        this.$router.push("/alternatif");
                    }
                })
                .catch(e => {
                    this.loading = false;
                    this.disabled = false;
                    if (e.response.status == 422)
                        this.errors = e.response.data.message;
                });
        }
    }
};
</script>

