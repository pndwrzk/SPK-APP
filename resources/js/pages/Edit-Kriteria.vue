<template>

    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">

        <!-- Content Header (Page header) -->

        <section class="content-header">

            <div class="container-fluid">

                <div class="row mb-2">

                    <div class="col-sm-6">

                        <h1>Edit Kriteria</h1>

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
                                 Edit Kriteria
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
                                        placeholder="Nama"
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
                                    for="inputatribut"
                                    class="col-sm-2 col-form-label"
                                >
                                     Atribut
                                </label>

                                <div class="col-sm-10">

                                    <select
                                        class="form-control"
                                        v-bind:class="{
                                            'is-invalid': errors.atribut
                                        }"
                                        id="inputatribut"
                                    >

                                        <option
                                            value="benefit"
                                            v-if="form.atribut === 'benefit'"
                                            selected
                                        >
                                             benefit
                                        </option>

                                        <option value="benefit" v-else>
                                             benefit
                                        </option>

                                        <option
                                            value="cost"
                                            v-if="form.atribut === 'cost'"
                                            selected
                                        >
                                             cost
                                        </option>

                                        <option v-else value="cost">
                                             cost
                                        </option>

                                    </select>

                                    <div
                                        v-if="errors.atribut"
                                        v-bind:class="{
                                            'invalid-feedback': errors.atribut
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
                                            'is-invalid': errors.bobot
                                        }"
                                        v-model="form.bobot"
                                        id="inputBobot"
                                        placeholder="Bobot"
                                    />

                                    <div
                                        v-if="errors.bobot"
                                        v-bind:class="{
                                            'invalid-feedback': errors.bobot
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

                            <router-link class=" text-dark" to="/kriteria">

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
                bobot: "",
                atribut: "",
                bobot: ""
            },
            errors: {}
        };
    },
    created() {
        this.getKriteria();
    },

    methods: {
        getKriteria() {
            axios.get("/api/kriteria/" + this.kode).then(response => {
                this.form.nama = response.data.nama;
                this.form.bobot = response.data.bobot;
                this.form.atribut = response.data.atribut;
            });
        },
        handleUpdate() {
            this.loading = true;
            this.disabled = true;
            this.form.atribut = document.getElementById("inputatribut").value;

            axios
                .put("/api/kriteria/" + this.kode, this.form)
                .then(response => {
                    if (response.status == 200) {
                        Toast.fire({
                            icon: "success",
                            title: response.data.message
                        });

                        this.$router.push("/kriteria");
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

