require("./bootstrap");

import Vue from "vue";

// import vue router
import VueRouter from "vue-router";
Vue.use(VueRouter);

import tinymce from "vue-tinymce-editor";
Vue.component("tinymce", tinymce);

import ReadMore from "vue-read-more";
Vue.use(ReadMore);

import VueSession from "vue-session";
Vue.use(VueSession);
Vue.config.productionTip = false;

import VueNoty from "vuejs-noty";
Vue.use(VueNoty);
import "vuejs-noty/dist/vuejs-noty.css";

let Fire = new Vue();
window.Fire = Fire;

import Swal from "sweetalert2";
window.Swal = Swal;
const Toast = Swal.mixin({
    toast: true,
    animation: false,
    position: "top",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
});
window.Toast = Toast;

Vue.component(
    "example-component",
    require("./components/ExampleComponent.vue").default
);
Vue.component(
    "preloader-component",
    require("./components/PreloaderComponent.vue").default
);
Vue.component(
    "sidebar-component",
    require("./components/SideBarComponent.vue").default
);
Vue.component(
    "navbar-component",
    require("./components/NavbarComponent.vue").default
);
Vue.component(
    "footer-component",
    require("./components/FooterComponent.vue").default
);
Vue.component(
    "controlsidebar-component",
    require("./components/ControlSideBarComponent.vue").default
);

import Dashboard from "./pages/Dashboard.vue";
import Alternatif from "./pages/Alternatif.vue";
import Kriteria from "./pages/Kriteria.vue";
import detailAlternatif from "./pages/Detail-Alternatif.vue";
import tambahAlternatif from "./pages/Tambah-Alternatif.vue";
import editAlternatif from "./pages/Edit-Alternatif.vue";
import tambahKriteria from "./pages/Tambah-Kriteria.vue";
import editKriteria from "./pages/Edit-Kriteria.vue";
import Penilaian from "./pages/Penilaian.vue";
import tambahpenilaian from "./pages/Tambah-Penilaian.vue";
import hasilPenilaian from "./pages/Hasil-Penilaian.vue";
import profileSaya from "./pages/Profile-Saya.vue";
import NotFound from "./pages/NotFound.vue";
import ubahPassword from "./pages/Ubah-Password.vue";
import ubahProfile from "./pages/Ubah-Profile.vue";
import buatPerbandingan from "./pages/Buat-Perbandingan.vue";
import hasilPerbandingan from "./pages/Hasil-Perbandingan.vue";
import suratKeputusan from "./pages/Surat-Keputusan.vue";
import artikel from "./pages/Artikel.vue";
import tambahArtikel from "./pages/Tambah-Artikel.vue";
import detailArtikel from "./pages/Detail-Artikel.vue";
import editArtikel from "./pages/Edit-Artikel.vue";
import pilihAlternatifTerbaik from "./pages/Pilih-Alternatif-Terbaik.vue";
import laporanPenilaianAlternatif from "./pages/Laporan-Penilaian-Alternatif.vue";
import laporanPerangkinganAlternatif from "./pages/Laporan-Perangkingan-Alternatif.vue";

const routes = [
    {
        path: "/dashboard",
        component: Dashboard,
        name: "dashboard",
    },
    {
        path: "/alternatif",
        component: Alternatif,
        name: "alternatif",
    },
    {
        path: "/alternatif/:kode/detail",
        component: detailAlternatif,
        name: "detail-alternatif",
        props: true,
    },
    {
        path: "/alternatif/tambah",
        component: tambahAlternatif,
        name: "tambah-alternatif",
    },
    {
        path: "/alternatif/:kode/edit",
        component: editAlternatif,
        name: "edit-alternatif",
        props: true,
    },
    {
        path: "/kriteria",
        component: Kriteria,
        name: "kriteria",
    },
    {
        path: "/kriteria/tambah",
        component: tambahKriteria,
        name: "tambah-kriteria",
    },
    {
        path: "/kriteria/:kode/edit",
        component: editKriteria,
        name: "edit-kriteria",
        props: true,
    },
    {
        path: "/penilaian",
        component: Penilaian,
        name: "penilaian",
    },
    {
        path: "/penilaian/tambah",
        component: tambahpenilaian,
        name: "tambah-penilaian",
    },
    {
        path: "/penilaian/:kode/hasil",
        component: hasilPenilaian,
        name: "hasil-penilaian",
        props: true,
    },

    {
        path: "/profile-saya",
        component: profileSaya,
        name: "profile-saya",
    },

    {
        path: "/ubah-password",
        component: ubahPassword,
        name: "ubah-password",
    },
    {
        path: "/profile-saya/ubah",
        component: ubahProfile,
        name: "ubah-profile",
    },

    {
        path: "/perbandingan/buat",
        component: buatPerbandingan,
        name: "buat-perbandingan",
    },
    {
        path: "/perbandingan/hasil",
        component: hasilPerbandingan,
        name: "hasil-perbandingan",
    },
    {
        path: "/penilaian/:kode/pilih-alternatif-terbaik",
        component: pilihAlternatifTerbaik,
        name: "pilih-alternatif-terbaik",
        props: true,
    },
    {
        path: "/surat-keputusan",
        component: suratKeputusan,
        name: "surat-keputusan",
    },
    {
        path: "/artikel",
        component: artikel,
        name: "artikel",
    },

    {
        path: "/artikel/tambah",
        component: tambahArtikel,
        name: "tambah-artikel",
    },
    {
        path: "/artikel/:kode",
        component: detailArtikel,
        name: "detail-artikel",
        props: true,
    },
    {
        path: "/artikel/:kode/edit",
        component: editArtikel,
        name: "edit-artikel",
        props: true,
    },

    {
        path: "/laporan-penilaian-alternatif",
        component: laporanPenilaianAlternatif,
        name: "laporan-penilaian-alternatif",
    },
    {
        path: "/laporan-perangkingan-alternatif",
        component: laporanPerangkinganAlternatif,
        name: "laporan-perangkingan-alternatif",
    },

    {
        path: "*",
        component: NotFound,
    },
];

const router = new VueRouter({
    linkActiveClass: "aktif",
    mode: "history",
    routes,

    // base: 'http://127.0.0.1:8000/',
});

const app = new Vue({
    el: "#app",
    router,
    data: {
        className: "test",
    },
});
