const frontendRoutes = [
    {
        path: '/',
        name: 'welcome',
        component: () => import( /* webpackChunkName: "login" */ '@/views/user/Welcome.vue') // This part is integrated with C:\xampp\htdocs\my-project\laravue\vue-passport\public\index.html
    },
    {
        path: '/product/:id/:slug',  
        name: 'product-show',
        component: () => import('@/views/user/products/show.vue'),
        meta: {
            breadcrumb: [
                { name: 'Home', link: 'home', home: 'home' },
                { name: 'Products', link: '/staff/products/index', home: 'index' },
                { name: 'Show', active: 'active' }
            ],
            pageTitle: "Show Product"
        }
    },
    {
        path: '/cart',  
        name: 'cart',
        component: () => import('@/views/user/cart.vue'),
        meta: {
            breadcrumb: [
                { name: 'Home', link: 'home', home: 'home' },
                { name: 'Products', link: '/staff/products/index', home: 'index' },
                { name: 'Show', active: 'active' }
            ],
            pageTitle: "Show Product"
        }
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
]

export default frontendRoutes;