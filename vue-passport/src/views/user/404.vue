<template v-if="isLoggedIn">
    <Nav />
    <div class="body-content outer-top-xs">
        <div class="container">
            <div class="x-page inner-bottom-sm">
                <div class="row"> 
                    <div class="col-md-12 x-text text-center">
                        <h1>404</h1>
                        <p>We are sorry, the page you've requested is not available.</p>
                        <form role="form" class="outer-top-vs outer-bottom-xs">
                            <input placeholder="Search" autocomplete="off" />
                            <button class="btn-default le-button">Go</button>
                        </form>
                        <a href="home.html"><i class="fa fa-home"></i> Go To Homepage</a>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.sigin-in-->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.body-content -->
    <Footer />
</template>

<script>
import jQuery from 'jquery';
const $ = jQuery;
window.$ = $;
import { useRouter } from 'vue-router';
import axios from 'axios';
import Nav from './partials/Nav.vue';
import Footer from './partials/Footer.vue';

export default {
    beforeCreate: function () {
        document.body.className = 'home-user';
    },
    components: {
        Nav,
        Footer,
    },
    data() {
        return {
            user: '',
        };
    },
    methods: {
        checkAuth() {
            // state token
            const token = localStorage.getItem('token-user');

            const router = useRouter();
            if (!token) {
                return router.push({
                    name: 'user-login',
                });
            }

            //get data user
            axios.defaults.headers.common.Authorization = `Bearer ${token}`;
            axios
                .get('http://localhost/my-project/laravue/api/user')
                .then((response) => {
                    console.log(response.data.name);
                    this.user = response.data;
                })
                .catch((error) => {
                    console.log(error.response.data);
                    if (error.response.status === 403) {
                        router.push('/user/login');
                    }
                    return Promise.reject(error);
                });
        },
        logout() {
            const token = localStorage.getItem('token-user');

            //logout
            axios.defaults.headers.common.Authorization = `Bearer ${token}`;
            axios
                .post('http://localhost/my-project/laravue/api/user/logout')
                .then((response) => {
                    if (response.data.success) {
                        //remove localStorage
                        localStorage.removeItem('token');

                        //redirect ke halaman login-user
                        const router = useRouter();
                        return router.push({
                            name: 'user-login',
                        });
                    }
                })
                .catch((error) => {
                    console.log(error.response.data);
                });
        },
    },
    beforeMount() {},
    created() {},
    mounted() {},
};
</script>

<style>
@import '~@/assets/frontend/css/bootstrap.min.css';
@import '~@/assets/frontend/css/main.css';
@import '~@/assets/frontend/css/animate.min.css';
@import '~@/assets/frontend/css/blue.css';
@import '~@/assets/frontend/css/bootstrap-select.min.css';
@import '~@/assets/frontend/css/bootstrap.min.css';
@import '~@/assets/frontend/css/font-awesome.css';
@import '~@/assets/frontend/css/lightbox.css';
@import '~@/assets/frontend/css/loading.css';
@import '~@/assets/frontend/css/main.css';
@import '~@/assets/frontend/css/owl.carousel.css';
@import '~@/assets/frontend/css/owl.transitions.css';
@import '~@/assets/frontend/css/rateit.css';
</style>
