<template>
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Ubah Password</h1>
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
                                Ubah Password
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
                    <div
                        class="alert alert-danger alert-dismissible fade show mt-3 mx-3"
                        role="alert"
                        v-if="failed"
                    >
                        {{ failed }}
                        <button
                            type="button"
                            class="close"
                            data-dismiss="alert"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

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
                                    Password
                                </label>

                                <div class="col-sm-10">
                                    <input
                                        type="password"
                                        class="form-control"
                                        v-bind:class="{
                                            'is-invalid': errors.password,
                                        }"
                                        v-model="form.password"
                                        id="inputpassword"
                                    />

                                    <div
                                        v-if="errors.password"
                                        v-bind:class="{
                                            'invalid-feedback': errors.password,
                                        }"
                                    >
                                        {{ errors.password[0] }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label
                                    for="inputbobot"
                                    class="col-sm-2 col-form-label"
                                >
                                    Password Baru
                                </label>

                                <div class="col-sm-10 input-group">
                                    <input
                                        type="password"
                                        class="form-control"
                                        v-bind:class="{
                                            'is-invalid': errors.passwordBaru,
                                        }"
                                        v-model="form.passwordBaru"
                                        id="inputpasswordBaru"
                                    />

                                    <div
                                        v-if="errors.passwordBaru"
                                        v-bind:class="{
                                            'invalid-feedback':
                                                errors.passwordBaru,
                                        }"
                                    >
                                        {{ errors.passwordBaru[0] }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label
                                    for="inputatribut"
                                    class="col-sm-2 col-form-label"
                                >
                                    Ulangi Password Baru
                                </label>

                                <div class="col-sm-10">
                                    <input
                                        type="password"
                                        class="form-control"
                                        v-bind:class="{
                                            'is-invalid':
                                                errors.ulangPasswordBaru,
                                        }"
                                        v-model="form.ulangPasswordBaru"
                                        id="inputulangPasswordBaru"
                                    />

                                    <div
                                        v-if="errors.ulangPasswordBaru"
                                        v-bind:class="{
                                            'invalid-feedback':
                                                errors.ulangPasswordBaru,
                                        }"
                                    >
                                        {{ errors.ulangPasswordBaru[0] }}
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
                            <router-link class="text-dark" to="/dashboard">
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
                password: "",
                passwordBaru: "",
                ulangPasswordBaru: "",
                kode_user: "",
            },
            errors: {},
            failed: "",
        };
    },

    methods: {
        handleSubmit() {
            this.loading = true;
            this.disabled = true;
            this.form.kode_user = document.getElementById("userlogin").value;
            axios
                .post("/api/ubahpassword", this.form)
                .then((res) => {
                    if (res.status == 200) {
                        Toast.fire({
                            icon: "success",
                            title: res.data.message,
                        });
                        window.location.href = "/logout";
                    }
                })
                .catch((e) => {
                    this.loading = false;
                    this.disabled = false;
                    if (e.response.data.status == 422)
                        if (e.response.data.failed) {
                            this.failed = e.response.data.failed;
                            this.errors = [];
                        } else {
                            this.errors = e.response.data.message;
                        }
                });
        },
    },
};
</script>
