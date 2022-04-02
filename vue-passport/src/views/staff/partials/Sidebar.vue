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
            <router-link :to="{ name: 'staff-home' }" class="nav-link" href="#">
              <i class="nav-icon fa fa-home"></i>
              <p>Home</p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="{ name: 'roles-index' }" class="nav-link" href="#">
              <i class="nav-icon fab fa-critical-role"></i>
              <p>Roles</p>
            </router-link>
          </li>
          <li class="nav-item"  v-if="viewStaffs !== null">
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
          <li class="nav-item" v-if="viewProducts !== null">
            <router-link :to="{ name: 'products-index' }" class="nav-link" href="#">
              <i class="nav-icon fas fa-object-group"></i>
              <p>Products</p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="{ name: 'sliders-index' }" class="nav-link" href="#">
              <i class="nav-icon fas fa-object-group"></i>
              <p>Sliders</p>
            </router-link>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-school"></i>
              <p>
                Another Menu
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Another Child Menu</p>
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
                      <p>Menu</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Menu</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Menu</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Menu</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
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
                <router-link :to="{ name: 'staff-address' }" class="nav-link" href="#">
                  <i class="nav-icon fas fa-object-group"></i>
                  <p>Address</p>
                </router-link>
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
import { useRouter } from 'vue-router';
import image from 'admin-lte/dist/img/AdminLTELogo.png';

export default {
  data: function () {
    return {
      image: image,
      staffData: '',
      viewProducts: null,
      viewStaffs: null
    };
  },
  methods: { 
    checkAuth() {
      //state token
      const token = localStorage.getItem('token-staff');
      let staffData = JSON.parse(localStorage.getItem('staff-data'));
      this.staffData = staffData;

      const router = useRouter();
      if (!token) {
        return router.push({
          name: 'staff-login',
        });
      }

      this.checkPermissions();
    },
    checkPermissions(permissionName) {
      const token = localStorage.getItem('token-staff');
      this.axios.defaults.headers.common.Authorization = `Bearer ${token}`;
      this.axios
        .get('api/staff/roles/permissions/' + permissionName)
        .then((response) => {
            if(permissionName === 'View Products') {
                this.viewProducts = response.data.staff;
            }

            if(permissionName === 'View Staffs') {
                this.viewStaffs = response.data.staff;
            }
          
        })
        .catch((error) => {
          console.log(error);
        })
        .finally(() => {
          //
        });
    }
  },
  beforeMount(){
    this.checkPermissions('View Products');
    this.checkPermissions('View Staffs');
  },
  created() {
    this.checkAuth();
  },
  mounted() {},
};
</script>
