//import vue router
import { createRouter, createWebHistory } from 'vue-router'; // initiate route config

//define a routes
const routes = [
    {
        path: '/',
        name: 'welcome',
        component: () => import( /* webpackChunkName: "login" */ '@/views/user/Welcome.vue') // This part is integrated with C:\xampp\htdocs\my-project\laravue\vue-passport\public\index.html
    },
    {
        path: '/user/register',
        name: 'user-register',
        component: () => import( /* webpackChunkName: "register" */ '@/views/user/auth/register-user.vue')
    },
    {
        path: '/user/login',
        name: 'user-login',
        component: () => import( /* webpackChunkName: "login" */ '@/views/user/auth/login-user.vue'),
        beforeEnter: (to, from, next) => {
            if (localStorage.getItem('token-user')) {
                next('/user/home');
            }
            next();
        }
    },
    {
        path: '/user/change-password',
        name: 'user-change-password',
        component: () => import( /* webpackChunkName: "login" */ '@/views/user/ChangePassword.vue'),
        beforeEnter: (to, from, next) => {
            if (!localStorage.getItem('token-user')) {
                next('/user/login');
            }
            next();
        }
    },
    {
        path: '/user/home',
        name: 'user-home',
        component: () => import( /* webpackChunkName: "dashboard" */ '@/views/user/home.vue'),
        beforeEnter: (to, from, next) => {
            if (localStorage.getItem('token-user')) {
                next();
            } else {
                next('/user/login');
            }
            next();
        }
    },
    {
        path: '/staff/login',
        name: 'staff-login',
        component: () => import( /* webpackChunkName: "login" */ '@/views/staff/auth/login-staff.vue'),
        beforeEnter: (to, from, next) => {
            if (localStorage.getItem('token-staff')) {
                next('/staff/home');
            }
            next();
        }
    },
    {
        path: '/staff/home',
        name: 'staff-home',
        component: () => import( /* webpackChunkName: "dashboard" */ '@/views/staff/home.vue'),
        beforeEnter: (to, from, next) => {
            if (!localStorage.getItem('token-staff')) {
                next('/staff/login');
            }
            next();
        }
    },
    {
        path: '/staff/address',
        name: 'staff-address',
        component: () => import( /* webpackChunkName: "dashboard" */ '@/views/staff/address.vue'),
        beforeEnter: (to, from, next) => {
            if (!localStorage.getItem('token-staff')) {
                next('/staff/login');
            }
            next();
        }
    },
    {
        path: '/staff/profile',
        name: 'staff-profile',
        component: () => import( /* webpackChunkName: "dashboard" */ '@/views/staff/profile.vue'),
        beforeEnter: (to, from, next) => {
            if (!localStorage.getItem('token-staff')) {
                next('/staff/login');
            }
            next();
        }
    },
    {
        path: '/staff/staff-management',
        name: 'staff-management',
        component: () => import('@/views/staff/staff-management.vue'),
        meta: {
            requiresAuth: true,
            breadcrumb: [
                { name: 'Home', link: 'home', home: 'home' },
                { name: 'Staff Management' },
                //{ name: 'index', active: 'active' }
            ],
            pageTitle: "Staff Management"
        },
        beforeEnter: (to, from, next) => {
            if (!localStorage.getItem('token-staff')) {
                next('/staff/login');
            }
            next();
        }
    },
    {
        path: '/staff/brand-management/index',
        name: 'brand-management',
        component: () => import('@/views/staff/brands/brand-management.vue'),
        meta: {
            requiresAuth: true,
            breadcrumb: [
                { name: 'Home', link: 'home', home: 'home' },
                { name: 'Brand Management' },
                //{ name: 'index', active: 'active' }
            ],
            pageTitle: "Brand Management"
        },
        beforeEnter: (to, from, next) => {
            if (!localStorage.getItem('token-staff')) {
                next('/staff/login');
            }
            next();
        }
    },
    {
        path: '/staff/brand-management/trash',
        name: 'brand-management-trash',
        component: () => import('@/views/staff/brands/trash.vue'),
        meta: {
            requiresAuth: true,
            breadcrumb: [
                { name: 'Home', link: 'home', home: 'home' },
                { name: 'Brand Management', link: 'index', home: 'index' },
                { name: 'trash', active: 'active' }
            ],
            pageTitle: "Brand Management"
        },
        beforeEnter: (to, from, next) => {
            if (!localStorage.getItem('token-staff')) {
                next('/staff/login');
            }
            next();
        }
    },
    {
        path: '/staff/categories/index',
        name: 'categories',
        component: () => import('@/views/staff/categories/categories.vue'),
        meta: {
            requiresAuth: true,
            breadcrumb: [
                { name: 'Home', link: 'home', home: 'home' },
                { name: 'Categories' },
                //{ name: 'index', active: 'active' }
            ],
            pageTitle: "Categories"
        },
        beforeEnter: (to, from, next) => {
            if (!localStorage.getItem('token-staff')) {
                next('/staff/login');
            }
            next();
        }
    },
    {
        path: '/staff/categories/trash',
        name: 'categories-trash',
        component: () => import('@/views/staff/categories/trash.vue'),
        meta: {
            requiresAuth: true,
            breadcrumb: [
                { name: 'Home', link: 'home', home: 'home' },
                { name: 'Categories', link: 'index', home: 'index' },
                { name: 'trash', active: 'active' }
            ],
            pageTitle: "Categories"
        },
        beforeEnter: (to, from, next) => {
            if (!localStorage.getItem('token-staff')) {
                next('/staff/login');
            }
            next();
        }
    },
    {
        path: '/staff/sub-categories/index',
        name: 'sub-categories',
        component: () => import('@/views/staff/sub-categories/sub-categories.vue'),
        meta: {
            requiresAuth: true,
            breadcrumb: [
                { name: 'Home', link: 'home', home: 'home' },
                { name: 'Sub Categories' },
                //{ name: 'index', active: 'active' }
            ],
            pageTitle: "Sub Categories"
        },
        beforeEnter: (to, from, next) => {
            if (!localStorage.getItem('token-staff')) {
                next('/staff/login');
            }
            next();
        }
    },
    {
        path: '/staff/sub-categories/trash',
        name: 'sub-categories-trash',
        component: () => import('@/views/staff/sub-categories/trash.vue'),
        meta: {
            requiresAuth: true,
            breadcrumb: [
                { name: 'Home', link: 'home', home: 'home' },
                { name: 'Sub Categories', link: 'index', home: 'index' },
                { name: 'trash', active: 'active' }
            ],
            pageTitle: "Sub Categories"
        },
        beforeEnter: (to, from, next) => {
            if (!localStorage.getItem('token-staff')) {
                next('/staff/login');
            }
            next();
        }
    },
    {
        path: '/staff/sub-sub-categories/index',
        name: 'sub-sub-categories',
        component: () => import('@/views/staff/sub-sub-categories/sub-sub-categories.vue'),
        meta: {
            requiresAuth: true,
            breadcrumb: [
                { name: 'Home', link: 'home', home: 'home' },
                { name: 'Sub Sub Categories' },
                //{ name: 'index', active: 'active' }
            ],
            pageTitle: "Sub Sub Categories"
        },
        beforeEnter: (to, from, next) => {
            if (!localStorage.getItem('token-staff')) {
                next('/staff/login');
            }
            next();
        }
    },
    {
        path: '/staff/sub-sub-categories/trash',
        name: 'sub-sub-categories-trash',
        component: () => import('@/views/staff/sub-sub-categories/trash.vue'),
        meta: {
            requiresAuth: true,
            breadcrumb: [
                { name: 'Home', link: 'home', home: 'home' },
                { name: 'Sub Sub Categories', link: 'index', home: 'index' },
                { name: 'trash', active: 'active' }
            ],
            pageTitle: "Sub Sub Categories"
        },
        beforeEnter: (to, from, next) => {
            if (!localStorage.getItem('token-staff')) {
                next('/staff/login');
            }
            next();
        }
    },
    {
        path: '/staff/products/index',
        name: 'products-index',
        component: () => import('@/views/staff/products/index.vue'),
        meta: {
            requiresAuth: true,
            breadcrumb: [
                { name: 'Home', link: 'home', home: 'home' },
                { name: 'Products', link: 'index', home: 'index' },
            ],
            pageTitle: "Products"
        },
        beforeEnter: (to, from, next) => {
            if (!localStorage.getItem('token-staff')) {
                next('/staff/login');
            }
            next();
        }
    },
    {
        path: '/staff/products/create',
        name: 'products-create',
        component: () => import('@/views/staff/products/create.vue'),
        meta: {
            requiresAuth: true,
            breadcrumb: [
                { name: 'Home', link: 'home', home: 'home' },
                { name: 'Products', link: 'index', home: 'index' },
                { name: 'create', active: 'active' }
            ],
            pageTitle: "Create Product"
        },
        beforeEnter: (to, from, next) => {
            if (!localStorage.getItem('token-staff')) {
                next('/staff/login');
            }
            next();
        }
    },
    {
        path: '/staff/products/edit/:id',
        name: 'products-edit',
        component: () => import('@/views/staff/products/edit.vue'),
        meta: {
            requiresAuth: true,
            breadcrumb: [
                { name: 'Home', link: 'home', home: 'home' },
                { name: 'Products', link: 'index', home: 'index' },
                { name: 'Edit', active: 'active' }
            ],
            pageTitle: "Edit Product"
        },
        beforeEnter: (to, from, next) => {
            if (!localStorage.getItem('token-staff')) {
                next('/staff/login');
            }
            next();
        }
    },
]

//create router
const router = createRouter({
    history: createWebHistory(),
    routes  // config routes
})

export default router