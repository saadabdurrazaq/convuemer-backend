<template>
    <div class="wrapper">
        <Nav />
        <Sidebar />
        <div class="content-wrapper">
            <div class="content-header">
                <div class="content">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">Dashboard</div>
                                    <div class="card-body">
                                        Selamat datang <strong>{{ staffData.data.name }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Footer />
    </div>
</template>

<script>
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';
import Nav from './partials/Nav.vue';
import Sidebar from './partials/Sidebar.vue';
import Footer from './partials/Footer.vue';

export default {
    beforeCreate: function () {
        document.body.className = 'home-staff';
    },
    components: {
        Nav,
        Sidebar,
        Footer,
    },
    setup() {
        //state token
        const token = localStorage.getItem('token-staff');
        let staffData = JSON.parse(localStorage.getItem('staff-data'));

        //inisialisasi vue router on Composition API
        const router = useRouter();

        //mounted properti
        onMounted(() => {
            //check Token exist
            if (!token) {
                return router.push({
                    name: 'staff-login',
                });
            }
        });

        return {
            token, // <-- state token
            staffData,
        };
    },
};
</script>

<style lang="scss" scoped>
@import '~admin-lte/dist/css/adminlte.min.css';
body.home-staff {
    background: lightgray !important;
}
</style>
