<template>
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Ubah Profile</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <!-- <li class="breadcrumb-item"><a href="#">Home</a></li> -->

                            <li class="breadcrumb-item">
                                <router-link to="dashboard">
                                    Dashboard
                                </router-link>
                            </li>

                            <li class="breadcrumb-item">
                                <router-link to="profile-saya">
                                    Profile Saya
                                </router-link>
                            </li>

                            <li class="breadcrumb-item active">Ubah Profile</li>
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
                                        id="inputnama"
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
                                    for="inputbobot"
                                    class="col-sm-2 col-form-label"
                                >
                                    Email
                                </label>

                                <div class="col-sm-10 input-group">
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-bind:class="{
                                            'is-invalid': errors.email,
                                        }"
                                        v-model="form.email"
                                        id="inputemail"
                                    />

                                    <div
                                        v-if="errors.email"
                                        v-bind:class="{
                                            'invalid-feedback': errors.email,
                                        }"
                                    >
                                        {{ errors.email[0] }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label
                                    for="inputatribut"
                                    class="col-sm-2 col-form-label"
                                >
                                    No Telepon
                                </label>

                                <div class="col-sm-10">
                                    <input
                                        type="number"
                                        class="form-control"
                                        v-bind:class="{
                                            'is-invalid': errors.telepon,
                                        }"
                                        v-model="form.telepon"
                                        id="inputtelepon"
                                    />

                                    <div
                                        v-if="errors.telepon"
                                        v-bind:class="{
                                            'invalid-feedback': errors.telepon,
                                        }"
                                    >
                                        {{ errors.telepon[0] }}
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
                            <router-link class="text-dark" to="/profile-saya">
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
                email: "",
                telepon: "",
                kode_user: "",
            },
            errors: {},
            failed: "",
        };
    },

    mounted() {
        this.getUser();
    },

    methods: {
        getUser() {
            let kode = document.getElementById("userlogin").value;

            axios.get("/api/user/" + kode).then((res) => {
                this.form.nama = res.data.nama;
                this.form.email = res.data.email;
                this.form.telepon = res.data.telepon;
                this.form.kode_user = kode;
            });
        },
        handleUpdate() {
            this.loading = true;
            this.disabled = true;
            axios
                .put("/api/user/", this.form)
                .then((res) => {
                    if (res.status == 200) {
                        Toast.fire({
                            icon: "success",
                            title: res.data.message,
                        });
                        this.$router.push("/profile-saya");
                    }
                })
                .catch((e) => {
                    this.loading = false;
                    this.disabled = false;
                    if (e.response.status == 422)
                        this.errors = e.response.data.message;
                });
        },
    },
};
</script>
