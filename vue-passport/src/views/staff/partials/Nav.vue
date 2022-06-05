<template>
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <router-link :to="{ name: 'welcome' }" class="nav-link" href="#"
                    >Laravue</router-link
                >
            </li>
        </ul> 

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-comments"></i>
                    <span class="badge badge-danger navbar-badge">3</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="" alt="User Avatar" class="img-size-50 mr-3 img-circle" />
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    Brad Diesel
                                    <span class="float-right text-sm text-danger"
                                        ><i class="fas fa-star"></i
                                    ></span>
                                </h3>
                                <p class="text-sm">Call me whenever you can...</p>
                                <p class="text-sm text-muted">
                                    <i class="far fa-clock mr-1"></i> 4 Hours Ago
                                </p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="" alt="User Avatar" class="img-size-50 img-circle mr-3" />
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    John Pierce
                                    <span class="float-right text-sm text-muted"
                                        ><i class="fas fa-star"></i
                                    ></span>
                                </h3>
                                <p class="text-sm">I got your message bro</p>
                                <p class="text-sm text-muted">
                                    <i class="far fa-clock mr-1"></i> 4 Hours Ago
                                </p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="" alt="User Avatar" class="img-size-50 img-circle mr-3" />
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    Nora Silvester
                                    <span class="float-right text-sm text-warning"
                                        ><i class="fas fa-star"></i
                                    ></span>
                                </h3>
                                <p class="text-sm">The subject goes here</p>
                                <p class="text-sm text-muted">
                                    <i class="far fa-clock mr-1"></i> 4 Hours Ago
                                </p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                </div>
            </li>
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
            <li class="nav-item dropdown user user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <!-- avatar -->
                    <template v-if="user.avatar != null">
                        <img
                            :src="require('@/assets/avatar/fb-male.jpg')"
                            class="img-circle elevation-2"
                            alt="User Image"
                            style="
                                width: 32px;
                                height: 32px;
                                position: absolute;
                                left: 5px;
                                bottom: 5px;
                                border-radius: 50%;
                            "
                        />
                    </template>
                    <template v-if="user.avatar == null">
                        <template v-if="user.gender == 'Male'">
                            <img
                                :src="require('@/assets/avatar/fb-male.jpg')"
                                class="img-circle elevation-2"
                                alt="User Image"
                                style="
                                    width: 32px;
                                    height: 32px;
                                    position: absolute;
                                    left: 5px;
                                    bottom: 5px;
                                    border-radius: 50%;
                                "
                            />
                        </template>
                        <template v-else>
                            <img
                                :src="require('@/assets/avatar/fb-male.jpg')"
                                class="img-circle elevation-2"
                                alt="User Image"
                                style="
                                    width: 32px;
                                    height: 32px;
                                    position: absolute;
                                    left: 5px;
                                    bottom: 5px;
                                    border-radius: 50%;
                                "
                            />
                        </template>
                    </template>
                    <span class="hidden-xs"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <!-- User image -->
                    <li class="user-header bg-primary">
                        <template v-if="user.avatar != null">
                            <img
                                :src="require('@/assets/avatar/fb-male.jpg')"
                                class="img-circle elevation-2"
                                alt="User Image"
                            />
                        </template>
                        <template v-if="user.avatar == null">
                            <template v-if="user.gender == 'Male'">
                                <img
                                    :src="require('@/assets/avatar/fb-male.jpg')"
                                    class="img-circle elevation-2"
                                    alt="User Image"
                                />
                            </template>
                            <template v-else>
                                <img
                                    :src="require('@/assets/avatar/fb-male.jpg')"
                                    class="img-circle elevation-2"
                                    alt="User Image"
                                />
                            </template>
                        </template>
                        <p>
                            {{ user.name }} -
                            <small>Member since Nov. 2012</small>
                        </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-left" style="float: left">
                            <router-link
                                :to="{ name: 'staff-profile' }"
                                class="btn btn-default btn-flat"
                                href="#"
                                >Profile</router-link
                            >
                        </div>
                        <div class="pull-right" style="float: right">
                            <a @click.prevent="logout" class="btn btn-default btn-flat">Logout </a>
                        </div>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"
                    ><i class="fas fa-th-large"></i
                ></a>
            </li>
        </ul>
    </nav>
</template>

<script>
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

export default {
    setup() {
        //state token
        const token = localStorage.getItem('token-staff');

        //inisialisasi vue router on Composition API
        const router = useRouter();

        //state user
        const user = ref('');

        //mounted properti
        onMounted(() => {
            //check Token exist
            if (!token) {
                return router.push({
                    name: 'staff-login',
                });
            }

            //get data user
            axios.defaults.headers.common.Authorization = `Bearer ${token}`;
            axios
                .get('http://localhost/my-project/laravue/api/staff')
                .then((response) => {
                    console.log(response.data.name);
                    user.value = response.data;
                })
                .catch((error) => {
                    console.log(error.response.data);
                });
        });

        //method logout
        function logout() {
            //logout
            axios.defaults.headers.common.Authorization = `Bearer ${token}`;
            axios
                .post('http://localhost/my-project/laravue/api/staff/logout')
                .then((response) => {
                    if (response.data.success) { 
                        //remove localStorage
                        localStorage.removeItem('token-staff');
                        localStorage.removeItem('staff-data');

                        //redirect ke halaman login-staff
                        return router.push({
                            name: 'staff-login',
                        });
                    }
                })
                .catch((error) => {
                    console.log(error.response.data);
                });
        }

        return {
            token, // <-- state token
            user, // <-- state user
            logout,
        };
    },
    methods: {},
};
</script>

<style>
body {
    background: lightgray !important;
}
</style>
