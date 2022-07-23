<template>

    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">

        <!-- Content Header (Page header) -->

        <section class="content-header">

            <div class="container-fluid">

                <div class="row mb-2">

                    <div class="col-sm-6">

                        <h1>Edit Artikel</h1>

                    </div>

                    <div class="col-sm-6">

                        <ol class="breadcrumb float-sm-right">

                            <li class="breadcrumb-item">

                                <router-link to="/dashboard">
                                     Dashboard
                                </router-link>

                            </li>

                            <li class="breadcrumb-item">

                                <router-link to="/artikel">Artikel</router-link>

                            </li>

                            <li class="breadcrumb-item active">Edit Artikel</li>

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
                                     Nama Penerbit
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
                                    for="inputNama"
                                    class="col-sm-2 col-form-label"
                                >
                                     Link Penerbit
                                </label>

                                <div class="col-sm-10">

                                    <input
                                        type="text"
                                        class="form-control"
                                        v-bind:class="{
                                            'is-invalid': errors.link
                                        }"
                                        v-model="form.link"
                                        id="inputlink"
                                        placeholder="link Lengkap"
                                    />

                                    <div
                                        v-if="errors.link"
                                        v-bind:class="{
                                            'invalid-feedback': errors.link
                                        }"
                                    >
                                         {{ errors.link[0] }}
                                    </div>

                                </div>

                            </div>

                            <div class="form-group row">

                                <label
                                    for="inputtanggal"
                                    class="col-sm-2 col-form-label"
                                >
                                     Tanggal Terbit
                                </label>

                                <div class="col-sm-10">

                                    <input
                                        type="date"
                                        class="form-control"
                                        v-bind:class="{
                                            'is-invalid': errors.tanggal
                                        }"
                                        v-model="form.tanggal"
                                        id="inputtanggal"
                                        placeholder="tanggal"
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

                            <div class="form-group row">

                                <label
                                    for="inputjudul"
                                    class="col-sm-2 col-form-label"
                                >
                                     Judul
                                </label>

                                <div class="col-sm-10">

                                    <input
                                        type="text"
                                        class="form-control"
                                        v-bind:class="{
                                            'is-invalid': errors.judul
                                        }"
                                        v-model="form.judul"
                                        id="inputjudul"
                                        placeholder="Judul"
                                    />

                                    <div
                                        v-if="errors.judul"
                                        v-bind:class="{
                                            'invalid-feedback': errors.judul
                                        }"
                                    >
                                         {{ errors.judul[0] }}
                                    </div>

                                </div>

                            </div>

                            <div class="form-group row">

                                <label
                                    for="inputartikel"
                                    class="col-sm-2 col-form-label"
                                >
                                     Artikel
                                </label>

                                <div class="col-sm-10">

                                    <tinymce
                                        id="d1"
                                        :other_options="tinyOptions"
                                        v-bind:class="{
                                            'is-invalid': errors.artikel
                                        }"
                                        v-model="form.artikel"
                                    ></tinymce>

                                    <div
                                        v-if="errors.artikel"
                                        v-bind:class="{
                                            'invalid-feedback': errors.artikel
                                        }"
                                    >
                                         {{ errors.artikel[0] }}
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

                            <router-link class=" text-dark" to="/artikel">

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
                artikel: "",
                link: "",
                judul: "",
                tanggal: ""
            },
            errors: {},
            tinyOptions: {
                height: 500
            }
        };
    },

    created() {
        this.getartikel();
    },

    methods: {
        getartikel() {
            axios.get("/api/artikel/" + this.kode).then(response => {
                this.form.judul = response.data.judul;
                this.form.nama = response.data.penerbit;
                this.form.tanggal = response.data.tanggal_terbit;
                this.form.link = response.data.link;
                this.form.artikel = response.data.konten;
            });
        },
        handleSubmit() {
            this.loading = true;
            this.disabled = true;
            axios
                .put("/api/artikel/" + this.kode, this.form)
                .then(res => {
                    if (res.status == 200) {
                        Toast.fire({
                            icon: "success",
                            title: res.data.message
                        });
                        this.$router.push("/artikel");
                    }
                })
                .catch(e => {
                    this.loading = false;
                    this.disabled = false;
                    if (e.response.data.status == 422)
                        this.errors = e.response.data.message;
                });
        }
    }
};
</script>

