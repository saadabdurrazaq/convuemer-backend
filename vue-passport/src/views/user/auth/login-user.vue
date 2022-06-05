<template>
    <Nav />
    <Breadcrumbs />
    <div class="body-content">
        <div class="container">
            <div class="sign-in-page" style="margin-bottom: 20px">
                <div class="row">
                    <!-- Sign-in -->
                    <div class="col-md-6 col-sm-6 sign-in">
                        <div class="col-md-12 col-sm-12">
                            <h4 class="">Sign in</h4>
                            <p class="">Hello, Welcome to your account.</p>
                            <div class="social-sign-in outer-top-xs">
                                <a href="#" class="facebook-sign-in"
                                    ><i class="fa fa-facebook"></i> Sign In with Facebook</a
                                >
                                <a href="#" class="twitter-sign-in"
                                    ><i class="fa fa-twitter"></i> Sign In with Twitter</a
                                >
                            </div>
                            <br />
                            <div style="display: none" id="errMsg" class="box no-border errMsg">
                                <div class="box-tools">
                                    <p class="alert alert-warning alert-dismissible">
                                        {{ user.error }}
                                        <button
                                            type="button"
                                            @click.prevent="closeMsg"
                                            class="close"
                                            data-hide="alert"
                                            aria-label="Close"
                                        >
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </p>
                                </div>
                            </div>
                            <form
                                role="form"
                                name="loginForm"
                                class="register-form outer-top-xs"
                                @submit.prevent="login"
                            >
                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail1"
                                        >Email Address <span>*</span></label
                                    >
                                    <input
                                        type="email"
                                        class="form-control unicase-form-control text-input"
                                        id="exampleInputEmail1"
                                        placeholder="Enter Email Address"
                                        name="email"
                                        v-model="user.email"
                                        required
                                        autocomplete="email"
                                        autofocus
                                    />
                                    <small class="text-danger" v-if="validation.email">
                                        {{ validation.email[0] }}
                                    </small>
                                </div>
                                <div class="form-group">
                                    <label class="info-title" for="exampleInputPassword1"
                                        >Password <span>*</span></label
                                    >
                                    <input
                                        type="password"
                                        class="form-control unicase-form-control text-input"
                                        id="exampleInputPassword1"
                                        placeholder="Password"
                                        name="password"
                                        v-model="user.password"
                                        required
                                        autocomplete="current-password"
                                    />
                                    <small class="text-danger" v-if="validation.password">
                                        {{ validation.password[0] }}
                                    </small>
                                </div>
                                <div class="radio outer-xs">
                                    <label>
                                        <input
                                            type="radio"
                                            name="optionsRadios"
                                            id="optionsRadios2"
                                            value="option2"
                                        />Remember me!
                                    </label>
                                    <a href="#" class="forgot-password pull-right"
                                        >Forgot your Password?</a
                                    >
                                </div>
                                <button
                                    type="submit" 
                                    @click="submit"
                                    class="btn-upper btn btn-primary checkout-page-button"
                                >
                                    <div
                                        id="loadingCircle"
                                        style="display: none; right: 5%"
                                        class="lds-ring"
                                    >
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                    <div id="loginButtonText">Login</div>
                                </button>
                            </form>
                        </div>
                    </div>
                    <!-- Sign-in -->

                    <!-- create a new account -->
                    <div class="col-md-6 col-sm-6 create-new-account">
                        <div class="col-md-12 col-sm-12" style="margin-bottom: 20px">
                            <h4 class="checkout-subtitle">Create a new account</h4>
                        </div>

                        <form class="register-form outer-top-xs" role="form">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail2"
                                        >Email Address <span>*</span></label
                                    >
                                    <input
                                        type="email"
                                        class="form-control unicase-form-control text-input"
                                        id="exampleInputEmail2"
                                    />
                                </div>

                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail1"
                                        >Phone Number <span>*</span></label
                                    >
                                    <input
                                        type="email"
                                        class="form-control unicase-form-control text-input"
                                        id="exampleInputEmail1"
                                    />
                                </div>

                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail1"
                                        >Confirm Password <span>*</span></label
                                    >
                                    <input
                                        type="email"
                                        class="form-control unicase-form-control text-input"
                                        id="exampleInputEmail1"
                                    />
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail1"
                                        >Name <span>*</span></label
                                    >
                                    <input
                                        type="email"
                                        class="form-control unicase-form-control text-input"
                                        id="exampleInputEmail1"
                                    />
                                </div>

                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail1"
                                        >Password <span>*</span></label
                                    >
                                    <input
                                        type="email"
                                        class="form-control unicase-form-control text-input"
                                        id="exampleInputEmail1"
                                    />
                                </div>
                            </div>

                            <div style="margin-left: 15px; margin-right: 15px" class="form-group">
                                <button
                                    type="submit"
                                    class="
                                        form-control
                                        unicase-form-control
                                        btn-upper btn btn-primary
                                        checkout-page-button
                                    "
                                >
                                    Sign Up
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- create a new account -->
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
import Nav from '../partials/Nav.vue';
import Footer from '../partials/Footer.vue';
import Breadcrumbs from '../partials/Breadcrumbs.vue';
import { reactive, ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios'; 
import '@/assets/frontend/css/loading.css';
import jQuery from 'jquery';
const $ = jQuery;
window.$ = $;

export default {
    beforeCreate: function () {
        document.body.className = 'login';
        document.body.classList.remove('login', 'hold-transition', 'sidebar-mini');
        document.body.classList.add('cnt-home');
    },
    components: {
        Nav,
        Footer,
        Breadcrumbs,
    },
    setup() {
        //inisialisasi vue router on Composition API
        const router = useRouter();

        //state user
        const user = reactive({
            email: '',
            password: '',
            error: '',
        });

        //state validation
        const validation = ref([]);

        //state loginFailed
        const loginFailed = ref(null);
        const token = localStorage.getItem('token-user');
        const body = document.body;

        onMounted(() => {
            let searchParams = new URLSearchParams(window.location.search);
            if (searchParams.has('redirect')) {
                $('#errMsg').show('fast');
                loginFailed.value = true;
                user.error = 'You must login to access the page!';
            } 

            //get data user
            axios.defaults.headers.common.Authorization = `Bearer ${token}`; 
            axios
                .get('http://localhost/my-project/laravue/api/user')
                .then((response) => {
                    console.log(response.data.name);
                    user.value = response.data;

                    document.body.classList.add('hold-transition');
                    document.body.classList.add('sidebar-mini');

                    return router.push({
                        name: 'user-home',
                    });
                })
                .catch((error) => {
                    console.log(error.response.data);

                    body.classList.remove('login', 'hold-transition', 'sidebar-mini');
                    document.body.classList.add('login-page');

                    if (error.response.status === 403) {
                        router.push('/user/login');
                    }
                    return Promise.reject(error);
                });
        });

        function closeMsg() {
            $('#errMsg').hide('slow');
        }

        function submit() {
            var a = document.forms['loginForm']['email'].value;
            var b = document.forms['loginForm']['password'].value;
            var emailReg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;

            if (emailReg.test(a) && b != '') {
                $('#loadingCircle').show();
                $('#loginButtonText').hide();
            }
        }

        //method login
        function login() {
            //define variable
            let email = user.email;
            let password = user.password;

            //send server with axios
            axios
                .post('http://localhost/my-project/laravue/api/user/login', {
                    email,
                    password,
                })
                .then((response) => {
                    if (response.data.success) { 
                        //set token
                        localStorage.setItem('token-user', response.data.token);
                        localStorage.setItem('user-data', JSON.stringify(response.data));

                        let searchParams = new URLSearchParams(window.location.search);
                        if (searchParams.has('redirect')) {
                            return router.push({
                                path: searchParams.get('redirect'),
                            });
                        } else {
                            //redirect ke halaman dashboard
                            return router.push({
                                name: 'user-home',
                            });
                        }
                    } else {
                        $('#loadingCircle').hide();
                        $('#loginButtonText').show();
                        $('#errMsg').show('fast');
                        validation.value = response.data.error;
                        user.error = response.data.error[0];
                        console.log(user.error);
                    }

                    //set state loggedIn to true
                    loginFailed.value = true;
                })
                .catch((error) => {
                    //set validation dari error response
                    console.log(error);
                    validation.value = error.response.data;
                });
        }

        return {
            user, // <-- state user
            validation, // <-- state validation
            loginFailed, // <-- state loggedIn
            login, // <-- method login
            closeMsg,
            submit,
        };
    },
};
</script>

<style>
@import '~@/assets/frontend/css/bootstrap.min.css';
@import '~@/assets/frontend/css/main-blue-green.css';
@import '~@/assets/frontend/css/blue-green.css';
</style>
