<template>
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a
                    class="nav-link"
                    data-widget="pushmenu"
                    href="#"
                    role="button"
                    ><i class="fa fa-bars"></i
                ></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li>
                <div class="dropdown">
                    <a
                        class="btn  dropdown-toggle"
                        type="button"
                        id="dropdownMenu2"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                    >
                        {{ userLogin.nama }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        <router-link
                            to="/profile-saya"
                            class="dropdown-item"
                            type="button"
                        >
                            Profile Saya
                        </router-link>
                        <router-link
                            to="/ubah-password"
                            class="dropdown-item"
                            type="button"
                        >
                            Ubah Password
                        </router-link>
                        <a href="/logout" class="dropdown-item ">Logout</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a
                    class="nav-link"
                    data-widget="fullscreen"
                    href="#"
                    role="button"
                >
                    <i class="fa fa-arrows-alt"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->
</template>

<script>
export default {
    data() {
        return {
            userLogin: ""
        };
    },

    created() {
        this.getUserLogin();
    },
    methods: {
        getUserLogin() {
            var userLogin = document.getElementById("userlogin").value;
            axios.get("/api/user/" + userLogin).then(res => {
                this.userLogin = res.data;

                //  this.karyawan = responde.data;
            });
        }
    }
};
</script>
