<template>
  <div class="wrapper">
    <Nav />
    <Sidebar />
    <div class="content-wrapper">
      <div class="content-header">
        <div class="content">
          <!-- begin the element -->
          <section class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header p-2">
                      <ul class="nav nav-pills" id="myTab">
                        <li class="nav-item">
                          <a
                            class="nav-link active"
                            id="fetchActivity"
                            href="#activity"
                            data-toggle="tab"
                            >Activity</a
                          >
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="fetchDetail" href="#detail" data-toggle="tab"
                            >Detail</a
                          >
                        </li>
                        <li class="nav-item">
                          <a
                            class="nav-link"
                            id="fetchChangepassword"
                            href="#changepassword"
                            data-toggle="tab"
                            >Change Password</a
                          >
                        </li>
                      </ul>
                    </div>
                    <!-- /.card-header -->
                  </div>
                  <!-- /.nav-tabs-custom -->
                </div>
                <div class="col-md-3">
                  <!-- Profile Image -->
                  <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                      <div class="text-center">
                        <template v-if="staffData.data.avatar != null">
                          <img
                            :src="require('@/assets/avatar/fb-male.jpg')"
                            class="profile-user-img img-fluid img-circle"
                            alt="User Image"
                          />
                        </template>
                        <template v-if="staffData.data.avatar == null">
                          <template v-if="staffData.data.gender == 'Male'">
                            <img
                              :src="require('@/assets/avatar/fb-male.jpg')"
                              class="profile-user-img img-fluid img-circle"
                              alt="User Image"
                            />
                          </template>
                          <template v-else>
                            <img
                              :src="require('@/assets/avatar/fb-male.jpg')"
                              class="profile-user-img img-fluid img-circle"
                              alt="User Image"
                            />
                          </template>
                        </template>
                      </div>

                      <h3 class="profile-username text-center"></h3>

                      <p class="text-muted text-center"></p>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                  <div class="card card-info card-outline">
                    <div class="card-header">
                      <h3 class="card-title">General Information</h3>

                      <div class="card-tools">
                        <button
                          type="button"
                          class="btn btn-tool"
                          data-card-widget="collapse"
                          title="Collapse"
                        >
                          <i class="fas fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="form-group">
                        <label for="inputEstimatedBudget">Estimated budget</label>
                        <input type="number" id="inputEstimatedBudget" class="form-control" />
                      </div>
                      <div class="form-group">
                        <label for="inputSpentBudget">Total amount spent</label>
                        <input type="number" id="inputSpentBudget" class="form-control" />
                      </div>
                      <div class="form-group">
                        <label for="inputEstimatedDuration">Estimated project duration</label>
                        <input type="number" id="inputEstimatedDuration" class="form-control" />
                      </div>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
          </section>
          <!-- end the element -->
        </div>
        <!-- content -->
      </div>
    </div>
    <Footer />
  </div>
</template>

<script>
import 'admin-lte/dist/css/adminlte.min.css' // conflict with frontend theme
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

<style scoped>
body.home-staff {
  background: lightgray !important;
}
</style>
