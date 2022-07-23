<template>

    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">

        <!-- Content Header (Page header) -->

        <section class="content-header">

            <div class="container-fluid">

                <div class="row mb-2">

                    <div class="col-sm-6">

                        <h1>Profile Saya</h1>

                    </div>

                    <div class="col-sm-6">

                        <ol class="breadcrumb float-sm-right">

                            <li class="breadcrumb-item">

                                <router-link to="/dashboard">
                                     Dashboard
                                </router-link>

                            </li>

                            <li class="breadcrumb-item active">Profile Saya</li>

                        </ol>

                    </div>

                </div>

            </div>

            <!-- /.container-fluid -->

        </section>

        <!-- Main content -->

        <section class="content">

            <div class="container-fluid">

                <div class="card col-lg-8 col-sm-12 mb-5">

                    <div class="card-body">

                        <div class="row">

                            <div class="col-7">

                                <table class="table-sm">

                                    <tr>

                                        <th>Kode</th>

                                        <td>:</td>

                                        <td>{{ userLogin.kode_user }}</td>

                                    </tr>

                                    <tr>

                                        <th>Nama</th>

                                        <td>:</td>

                                        <td>{{ userLogin.nama }}</td>

                                    </tr>

                                    <tr>

                                        <th>Email</th>

                                        <td>:</td>

                                        <td>{{ userLogin.email }}</td>

                                    </tr>

                                    <tr>

                                        <th>Telepon</th>

                                        <td>:</td>

                                        <td>{{ userLogin.telepon }}</td>

                                    </tr>

                                </table>

                            </div>

                            <div class="col-5">

                                <router-link
                                    to="/profile-saya/ubah"
                                    class="btn btn-dark btn-sm float-right"
                                >
                                     Ubah
                                </router-link>

                            </div>

                        </div>

                        <div class="row mt-4 ">

                            <router-link class=" text-dark" to="/dashboard">

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
            userLogin: []
        };
    },
    // watch adalah akan menjalan getUser jika ada perubahan pada URL
    watch: {
        $route: "getUserLogin"
    },
    // created secara otomatis akan dijalan apabila pages sudah selesai di render
    mounted() {
        this.getUserLogin();
    },

    methods: {
        getUserLogin() {
            let kode = document.getElementById("userlogin").value;

            axios.get("/api/user/" + kode).then(res => {
                this.userLogin = res.data;
            });
        }
    }
};
</script>

