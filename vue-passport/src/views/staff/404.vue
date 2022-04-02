<template>
    <div class="wrapper">
        <Nav />
        <Sidebar />
        <div class="content-wrapper">
            <div class="content-header">
                <div class="content">
                    <section class="content">
                        <div class="error-page">
                            <h2 class="headline text-warning">404</h2>

                            <div class="error-content">
                                <h3>
                                    <i class="fas fa-exclamation-triangle text-warning"></i> Oops!
                                    Page not found.
                                </h3>

                                <p>
                                    We could not find the page you were looking for. Meanwhile, you
                                    may <a href="../../index.html">return to dashboard</a> or try
                                    using the search form.
                                </p>

                                <form class="search-form">
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            name="search"
                                            class="form-control"
                                            placeholder="Search"
                                        />

                                        <div class="input-group-append">
                                            <button
                                                type="submit"
                                                name="submit"
                                                class="btn btn-warning"
                                            >
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.input-group -->
                                </form>
                            </div>
                            <!-- /.error-content -->
                        </div>
                        <!-- /.error-page -->
                    </section>
                </div>
            </div>
        </div>
        <Footer />
    </div>
</template>

<script>
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
    data() {
        return {
            staffData: '',
        };
    },
    methods: {
        checkAuth() {
            // state token
            const token = localStorage.getItem('token-staff');
            let staffData = JSON.parse(localStorage.getItem('staff-data'));
            this.staffData = staffData;
            //inisialisasi vue router on Composition API
            const router = useRouter();
            if (!token) {
                return router.push({
                    name: 'staff-login',
                });
            }
        },
    },
    created() {
        this.checkAuth();
    },
    mounted() {},
};
</script>

<style lang="scss" scoped>
@import '~admin-lte/dist/css/adminlte.min.css';
body.home-staff {
    background: lightgray !important;
}
</style>
