import store from '../store'

const ShippingAddresses = () => import('../views/user/partials/ShippingAddresses.vue')

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
        path: '/user/register', 
        name: 'user-register',
        component: () => import( /* webpackChunkName: "register" */ '@/views/user/auth/register-user.vue')
    },
    {
        path: '/user/login',
        name: 'user-login',
        component: () => import( /* webpackChunkName: "login" */ '@/views/user/auth/login-user.vue'),
        meta: {
            breadcrumb: [  
                { name: 'Home', link: '/', home: 'home' },
                { name: 'Login' }
            ],
            pageTitle: "Login" 
        },
        beforeEnter: (to, from, next) => {
            if (!store.getters['auth/guest']) {  
                next('/user/home'); // when user already login and trying to access login page. 
            }
            next();
        }
    },
    {
        path: '/user/home',
        name: 'user-home',
        component: () => import( /* webpackChunkName: "dashboard" */ '@/views/user/home.vue'),
        beforeEnter: (to, from, next) => {
            if (store.getters['auth/guest']) {
                next({
                    path: '/user/login',
                    query: { redirect: to.fullPath }
                })
            } else {
                next(); 
            }
        },
        children: [
            {
              path: '/user/shipping-addresses',
              name: 'user-shipping-addresses',
              component: ShippingAddresses,
            },
        ]
    },
    {
        path: '/cart',  
        name: 'cart',
        component: () => import('@/views/user/cart.vue'),
        meta: {
            breadcrumb: [ 
                { name: 'Home', link: '/', home: 'home' },
                { name: 'Cart' }
            ],
            pageTitle: "Cart"
        },
        beforeEnter: (to, from, next) => {
            if (!store.getters['auth/guest']) {
                next();
            } else {
                next({
                    path: '/user/login',
                    query: { redirect: to.fullPath }
                })
            }
        }
    },
    {
        path: '/user/checkout',  
        name: 'checkout',
        component: () => import('@/views/user/checkout.vue'),
        meta: {
            breadcrumb: [
                { name: 'Home', link: '/', home: 'home' },
                { name: 'Checkout' }
            ],
            pageTitle: "Checkout"
        },
        beforeEnter: (to, from, next) => {
            if (!store.getters['auth/guest']) {
                next();
            } else {
                next({
                    path: '/user/login',
                    query: { redirect: to.fullPath }
                })
            }
        }
    },
    {
        path: '/user/buy-checkout',  
        name: 'buy-checkout',
        component: () => import('@/views/user/buy-checkout.vue'),
        meta: {
            breadcrumb: [
                { name: 'Home', link: '/', home: 'home' },
                { name: 'Checkout' }
            ],
            pageTitle: "Checkout"
        },
        beforeEnter: (to, from, next) => {
            if (!store.getters['auth/guest']) {
                next();
            } else {
                next({
                    path: '/user/login',
                    query: { redirect: to.fullPath }
                })
            }
        }
    },
    {
        path: '/user/orders',  
        name: 'orders',
        component: () => import('@/views/user/orders.vue'), 
        meta: {
            breadcrumb: [
                { name: 'Home', link: 'home', home: 'home' },
                { name: 'Products', link: '/staff/products/index', home: 'index' },
                { name: 'Show', active: 'active' }
            ],
            pageTitle: "Show Product"
        },
        beforeEnter: (to, from, next) => {
            if (!store.getters['auth/guest']) {
                next(); // if token-user is exist, then bring user to orders page
            } else {
                next({
                    path: '/user/login',
                    query: { redirect: to.fullPath }
                })
            }
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
]

export default frontendRoutes;