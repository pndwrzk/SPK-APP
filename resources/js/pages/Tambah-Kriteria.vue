<template>
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Tambah Kriteria</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <router-link to="/dashboard">
                                    Dashboard
                                </router-link>
                            </li>

                            <li class="breadcrumb-item">
                                <router-link to="/kriteria">
                                    Kriteria
                                </router-link>
                            </li>

                            <li class="breadcrumb-item active">
                                Tambah Kriteria
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
                            @submit.prevent="handleSubmit"
                        >
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
                                            'is-invalid': errors.nama,
                                        }"
                                        v-model="form.nama"
                                        id="inputNama"
                                        placeholder="Nama"
                                    />

                                    <div
                                        v-if="errors.nama"
                                        v-bind:class="{
                                            'invalid-feedback': errors.nama,
                                        }"
                                    >
                                        {{ errors.nama[0] }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label
                                    for="inputatribut"
                                    class="col-sm-2 col-form-label"
                                >
                                    Atribut
                                </label>

                                <div class="col-sm-10">
                                    <select
                                        class="form-control"
                                        v-bind:class="{
                                            'is-invalid': errors.atribut,
                                        }"
                                        v-model="form.atribut"
                                        id="inputatribut"
                                    >
                                        <option disabled value="">
                                            --Pilih--
                                        </option>
                                        <option value="benefit">benefit</option>

                                        <option value="cost">cost</option>
                                    </select>

                                    <div
                                        v-if="errors.atribut"
                                        v-bind:class="{
                                            'invalid-feedback': errors.atribut,
                                        }"
                                    >
                                        {{ errors.atribut[0] }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label
                                    for="inputBobot"
                                    class="col-sm-2 col-form-label"
                                >
                                    Bobot
                                </label>

                                <div class="col-sm-10">
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-bind:class="{
                                            'is-invalid': errors.bobot,
                                        }"
                                        v-model="form.bobot"
                                        id="inputBobot"
                                        placeholder="Bobot"
                                    />

                                    <div
                                        v-if="errors.bobot"
                                        v-bind:class="{
                                            'invalid-feedback': errors.bobot,
                                        }"
                                    >
                                        {{ errors.bobot[0] }}
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
                            <router-link class="text-dark" to="/kriteria">
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
    data() {
        return {
            loading: false,
            disabled: false,
            form: {
                nama: "",
                atribut: "",
                bobot: "",
            },
            errors: {},
        };
    },

    created() {},

    methods: {
        handleSubmit() {
            this.loading = true;
            this.disabled = true;
            axios
                .post("/api/kriteria", this.form)
                .then((res) => {
                    if (res.status == 200) {
                        Toast.fire({
                            icon: "success",
                            title: res.data.message,
                        });

                        this.$router.push("/kriteria");
                    }
                })
                .catch((e) => {
                    this.loading = false;
                    this.disabled = false;
                    if (e.response.status === 422) {
                        this.errors = e.response.data.message;
                    }
                });
        },
    },
};
</script>
