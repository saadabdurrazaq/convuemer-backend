<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <router-link :to="{ name: 'welcome' }" class="brand-link" href="#">
            <img
                :src="image"
                alt="AdminLTE Logo"
                class="brand-image img-circle elevation-3"
                style="opacity: 0.8"
            />
            <span class="brand-text font-weight-light">Laravue</span>
        </router-link>

        <!-- Sidebar Left -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <template v-if="staffData.data.avatar != null">
                        <img
                            :src="require('@/assets/avatar/fb-male.jpg')"
                            class="img-circle elevation-2"
                            alt="User Image"
                        />
                    </template>
                    <template v-if="staffData.data.avatar == null">
                        <template v-if="staffData.data.gender == 'Male'">
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
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ staffData.data.name }}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul
                    class="nav nav-pills nav-sidebar flex-column"
                    data-widget="treeview"
                    role="menu"
                    data-accordion="false"
                >
                    <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                    <!-- Authentication Links -->
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fab fa-critical-role"></i>
                            <p>Roles</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'staff-management' }" class="nav-link" href="#">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Staffs</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'brand-management' }" class="nav-link" href="#">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Brands</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'categories' }" class="nav-link" href="#">
                            <i class="nav-icon fas fa-object-group"></i>
                            <p>Categories</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'products-index' }" class="nav-link" href="#">
                            <i class="nav-icon fas fa-object-group"></i>
                            <p>Products</p>
                        </router-link>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-school"></i>
                            <p>
                                Fakultas & Prodi
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Daftar Fakultas & Prodi</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Daftar Matkul per Prodi</p>
                                </a>
                            </li>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-copy"></i>
                                    <p>
                                        Master Data
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="" class="nav-link">
                                            <i class="far fa-dot-circle nav-icon"></i>
                                            <p>Fakultas</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="" class="nav-link">
                                            <i class="far fa-dot-circle nav-icon"></i>
                                            <p>Program Studi</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="" class="nav-link">
                                            <i class="far fa-dot-circle nav-icon"></i>
                                            <p>Mata Kuliah</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="" class="nav-link">
                                            <i class="far fa-dot-circle nav-icon"></i>
                                            <p>Semester</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link">
                            <i class="nav-icon fas fa-building"></i>
                            <p>Denah & Tempat</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link">
                            <i class="nav-icon fas fa-info"></i>
                            <p>About Us</p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Master Data
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Fasilitas</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Gedung</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Lantai</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Ruangan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Kelas</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Kantor</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Master Data -->
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</template>

<script>
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';
import image from 'admin-lte/dist/img/AdminLTELogo.png';

export default {
    data: function () {
        return {
            image: image,
        };
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
            staffData, // <-- state user
        };
    },
};
</script>
