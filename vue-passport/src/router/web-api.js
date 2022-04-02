//import vue router
import { createRouter, createWebHistory } from 'vue-router'; // initiate route config
import BackendRoutes from './BackendRoutes.js'
import FrontendRoutes from './FrontendRoutes.js'

const route404 = [
    {
        path: "/:catchAll(.*)", 
        name: "NotFound",
        component: function () {
            var urlPath = window.location.pathname;
            if(urlPath.includes("staff")){
              return import( /* webpackChunkName: "dashboard" */ '@/views/staff/404.vue')
            }
            else{
              return import( /* webpackChunkName: "login" */ '@/views/user/404.vue')
            }
        }  
    },
]

//create router
const routerBackendAndFrontend = createRouter({
    history: createWebHistory(),
    routes: [
        ...BackendRoutes,
        ...FrontendRoutes,
        ...route404
    ]
})

export default routerBackendAndFrontend
