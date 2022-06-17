<template>
    <div class="login-box">
        <div class="login-logo">
            <a href="#">User Login</a>
        </div>

        <div style="display: none" id="errMsg" class="box no-border">
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

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form class="user" id="loginForm" name="loginForm" @submit.prevent="login">
                    <div class="input-group mb-3">
                        <input
                            type="email"
                            class="form-control"
                            id="exampleInputEmail"
                            placeholder="Enter Email Address"
                            name="email"
                            v-model="user.email"
                            required
                            autocomplete="email"
                            autofocus
                        />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input
                            type="password"
                            id="exampleInputPassword"
                            class="form-control"
                            placeholder="Password"
                            name="password"
                            v-model="user.password"
                            required
                            autocomplete="current-password"
                        />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa fa-lock"></span>
                            </div>
                        </div>
                        <small class="text-danger" v-if="validation.password">
                            {{ validation.password[0] }}
                        </small>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" name="remember" id="remember" />
                                <label for="remember"> &nbsp; Remember Me </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" @click="submit" class="btn btn-primary btn-block">
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
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <div class="social-auth-links text-center mb-3">
                    <p>- OR -</p>
                    <a href="#" class="btn btn-block btn-primary"
                        ><i class="fa fa-facebook mr-2"></i> Sign in using Facebook</a
                    >
                    <a href="#" class="btn btn-block btn-danger"
                        ><i class="fa fa-google-plus mr-2"></i> Sign in using Google+</a
                    >
                </div>
                <!-- /.social-auth-links -->

                <router-link to="/register" class="text-center">Create an Account!</router-link
                ><br />
                <router-link to="/forget" class="text-center">Forget Password</router-link><br />
                <a href="#" class="text-center">Register a new membership</a>
            </div>
        </div>
        <!-- /.login-box-body -->
    </div>
</template>

<script>
import 'admin-lte/dist/css/adminlte.min.css'; // conflict with frontend theme
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import { Form } from 'vform';
import '@/assets/css/custom.css';
import jQuery from 'jquery';
const $ = jQuery;
window.$ = $;

export default {
    beforeCreate: function () {
        document.body.className = 'staff';
        document.body.classList.remove('login', 'hold-transition', 'sidebar-mini');
        document.body.classList.add('login-page');
    },
    setup() {
        //inisialisasi vue router on Composition API
        const router = useRouter();

        //state user
        const user = new Form({
            email: '',
            password: '',
            error: '',  
        });

        //state validation
        const validation = ref([]);

        //state loginFailed
        const loginFailed = ref(null);

        const token = localStorage.getItem('token-staff');

        onMounted(() => {
            //get data user
            axios.defaults.headers.common.Authorization = `Bearer ${token}`;
            axios
                .get('api/staff')
                .then((response) => {
                    console.log(response.data.name);
                    user.value = response.data;
                    localStorage.setItem('token', response.data.token);

                    document.body.classList.add('hold-transition');
                    document.body.classList.add('sidebar-mini');

                    return router.push({
                        name: 'staff-home',
                    });
                })
                .catch((error) => {
                    console.log(error.response.data);

                    document.body.classList.remove('login', 'hold-transition', 'sidebar-mini');
                    document.body.classList.add('login-page');

                    if (error.response.status === 403) {
                        router.push('/staff/login');
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
            this.user
                .post('api/staff/login', {})
                .then((response) => {
                    if (response.data.success) {
                        //set token
                        localStorage.setItem('token-staff', response.data.token);
                        localStorage.setItem('staff-data', JSON.stringify(response.data));

                        //redirect ke halaman dashboard
                        return router.push({
                            name: 'staff-home',
                        });
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
body.staff {
    background: lightgray !important;
}
</style>
