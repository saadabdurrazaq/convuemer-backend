const routes = [
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
                { name: 'Home', link: '/staff/home', home: 'home' },
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
                { name: 'Home', link: '/staff/home', home: 'home' },
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
                { name: 'Home', link: '/staff/home', home: 'home' },
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
                { name: 'Home', link: '/staff/home', home: 'home' },
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
                { name: 'Home', link: '/staff/home', home: 'home' },
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
                { name: 'Home', link: '/staff/home', home: 'home' },
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
                { name: 'Home', link: '/staff/home', home: 'home' },
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
                { name: 'Home', link: '/staff/home', home: 'home' },
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
                { name: 'Home', link: '/staff/home', home: 'home' },
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
                { name: 'Home', link: '/staff/home', home: 'home' },
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
                { name: 'Home', link: '/staff/home', home: 'home' },
                { name: 'Products', link: 'index', home: 'index' },
                { name: 'Create', active: 'active' }
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
                { name: 'Home', link: '/staff/home', home: 'home' },
                { name: 'Products', link: '/staff/products/index', home: 'index' },
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
    {
        path: '/staff/products/trash',
        name: 'products-trash',
        component: () => import('@/views/staff/products/trash.vue'),
        meta: {
            requiresAuth: true,
            breadcrumb: [
                { name: 'Home', link: '/staff/home', home: 'home' },
                { name: 'Products', link: 'index', home: 'index' },
                { name: 'trash', active: 'active' }
            ],
            pageTitle: "Trash Products"
        },
        beforeEnter: (to, from, next) => {
            if (!localStorage.getItem('token-staff')) {
                next('/staff/login');
            }
            next();
        }
    },
    {
        path: '/staff/sliders/index',
        name: 'sliders-index',
        component: () => import('@/views/staff/sliders/index.vue'),
        meta: {
            requiresAuth: true,
            breadcrumb: [
                { name: 'Home', link: '/staff/home', home: 'home' },
                { name: 'Sliders' },
                //{ name: 'index', active: 'active' }
            ],
            pageTitle: "Sliders"
        },
        beforeEnter: (to, from, next) => {
            if (!localStorage.getItem('token-staff')) {
                next('/staff/login');
            }
            next();
        }
    },
    {
        path: '/staff/sliders/trash',
        name: 'sliders-trash',
        component: () => import('@/views/staff/sliders/trash.vue'),
        meta: {
            requiresAuth: true,
            breadcrumb: [
                { name: 'Home', link: '/staff/home', home: 'home' },
                { name: 'sliders', link: 'index', home: 'index' },
                { name: 'trash', active: 'active' }
            ],
            pageTitle: "sliders"
        },
        beforeEnter: (to, from, next) => {
            if (!localStorage.getItem('token-staff')) {
                next('/staff/login');
            }
            next();
        }
    },
    {
        path: '/staff/roles/index',
        name: 'roles-index',
        component: () => import('@/views/staff/roles/index.vue'),
        meta: {
            requiresAuth: true,
            breadcrumb: [
                { name: 'Home', link: '/staff/home', home: 'home' },
                { name: 'Roles', link: 'index', home: 'index' },
            ],
            pageTitle: "Roles"
        },
        beforeEnter: (to, from, next) => {
            if (!localStorage.getItem('token-staff')) {
                next('/staff/login');
            }
            next();
        }
    },
    {
        path: '/staff/roles/create',
        name: 'roles-create',
        component: () => import('@/views/staff/roles/create.vue'),
        meta: {
            requiresAuth: true,
            breadcrumb: [
                { name: 'Home', link: '/staff/home', home: 'home' },
                { name: 'Roles', link: '/staff/roles/index', home: 'index' },
                { name: 'Create', active: 'active' }
            ],
            pageTitle: "Create Roles"
        },
        beforeEnter: (to, from, next) => {
            if (!localStorage.getItem('token-staff')) {
                next('/staff/login');
            }
            next();
        }
    },
    {
        path: '/staff/roles/edit/:id',
        name: 'roles-edit',
        component: () => import('@/views/staff/roles/edit.vue'),
        meta: {
            requiresAuth: true,
            breadcrumb: [
                { name: 'Home', link: '/staff/home', home: 'home' },
                { name: 'Roles', link: '/staff/roles/index', home: 'index' },
                { name: 'Edit', active: 'active' }
            ],
            pageTitle: "Edit Role"
        },
        beforeEnter: (to, from, next) => {
            if (!localStorage.getItem('token-staff')) {
                next('/staff/login');
            }
            next();
        }
    },
    {
        path: '/staff/orders/index',
        name: 'orders-index',
        component: () => import('@/views/staff/orders/index.vue'),
        meta: {
            requiresAuth: true,
            breadcrumb: [
                { name: 'Home', link: '/staff/home', home: 'home' },
                { name: 'Orders', link: 'index', home: 'index' },
            ],
            pageTitle: "Orders"
        },
        beforeEnter: (to, from, next) => {
            if (!localStorage.getItem('token-staff')) {
                next('/staff/login');
            }
            next();
        }
    },
]

export default routes