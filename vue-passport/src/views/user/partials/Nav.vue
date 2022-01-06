<template>
    <header class="header-style-1">
        <!-- ============================================== TOP MENU ============================================== -->
        <div class="top-bar animate-dropdown">
            <div class="container">
                <div class="header-top-inner">
                    <div class="cnt-account">
                        <ul class="list-unstyled">
                            <li>
                                <a href="#"><i class="icon fa fa-user"></i>My Account</a>
                            </li>
                            <li>
                                <a href="#"><i class="icon fa fa-heart"></i>Wishlist</a>
                            </li>
                            <li>
                                <a href="#"><i class="icon fa fa-shopping-cart"></i>My Cart</a>
                            </li>
                            <li>
                                <a href="#"><i class="icon fa fa-check"></i>Checkout</a>
                            </li>
                            <li>
                                <router-link :to="{ name: 'user-login' }" class="nav-link" href="#"
                                    ><i class="icon fa fa-lock"></i>Login</router-link
                                >
                            </li>
                        </ul>
                    </div>
                    <!-- /.cnt-account -->

                    <div class="cnt-block">
                        <ul class="list-unstyled list-inline">
                            <li class="dropdown dropdown-small">
                                <a
                                    href="#"
                                    class="dropdown-toggle"
                                    data-hover="dropdown"
                                    data-toggle="dropdown"
                                    ><span class="value">USD </span><b class="caret"></b
                                ></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">USD</a></li>
                                    <li><a href="#">INR</a></li>
                                    <li><a href="#">GBP</a></li>
                                </ul>
                            </li>
                            <li class="dropdown dropdown-small">
                                <a
                                    href="#"
                                    class="dropdown-toggle"
                                    data-hover="dropdown"
                                    data-toggle="dropdown"
                                    ><span class="value">English </span><b class="caret"></b
                                ></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">English</a></li>
                                    <li><a href="#">French</a></li>
                                    <li><a href="#">German</a></li>
                                </ul>
                            </li>
                        </ul>
                        <!-- /.list-unstyled -->
                    </div>
                    <!-- /.cnt-cart -->
                    <div class="clearfix"></div>
                </div>
                <!-- /.header-top-inner -->
            </div>
            <!-- /.container -->
        </div>
        <!-- /.header-top -->
        <!-- ============================================== TOP MENU : END ============================================== -->
        <div class="main-header">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-3 logo-holder">
                        <!-- ============================================================= LOGO ============================================================= -->
                        <div class="logo">
                            <a href="home.html">
                                <img
                                    :src="require('@/assets/frontend/images/logo.png')"
                                    alt="logo"
                                />
                            </a>
                        </div>
                        <!-- /.logo -->
                        <!-- ============================================================= LOGO : END ============================================================= -->
                    </div>
                    <!-- /.logo-holder -->

                    <div class="col-xs-12 col-sm-12 col-md-7 top-search-holder">
                        <!-- /.contact-row -->
                        <!-- ============================================================= SEARCH AREA ============================================================= -->
                        <div class="search-area">
                            <form>
                                <div class="control-group">
                                    <ul class="categories-filter animate-dropdown">
                                        <li class="dropdown">
                                            <a
                                                class="dropdown-toggle"
                                                data-toggle="dropdown"
                                                href="category.html"
                                                >Categories <b class="caret"></b
                                            ></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li class="menu-header">Computer</li>
                                                <li role="presentation">
                                                    <a
                                                        role="menuitem"
                                                        tabindex="-1"
                                                        href="category.html"
                                                        >- Clothing</a
                                                    >
                                                </li>
                                                <li role="presentation">
                                                    <a
                                                        role="menuitem"
                                                        tabindex="-1"
                                                        href="category.html"
                                                        >- Electronics</a
                                                    >
                                                </li>
                                                <li role="presentation">
                                                    <a
                                                        role="menuitem"
                                                        tabindex="-1"
                                                        href="category.html"
                                                        >- Shoes</a
                                                    >
                                                </li>
                                                <li role="presentation">
                                                    <a
                                                        role="menuitem"
                                                        tabindex="-1"
                                                        href="category.html"
                                                        >- Watches</a
                                                    >
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <input class="search-field" placeholder="Search here..." />
                                    <a class="search-button" href="#"></a>
                                </div>
                            </form>
                        </div>
                        <!-- /.search-area -->
                        <!-- ============================================================= SEARCH AREA : END ============================================================= -->
                    </div>
                    <!-- /.top-search-holder -->

                    <div class="col-xs-12 col-sm-12 col-md-2 animate-dropdown top-cart-row">
                        <!-- ============================================================= SHOPPING CART DROPDOWN ============================================================= -->

                        <div class="dropdown dropdown-cart">
                            <a href="#" class="dropdown-toggle lnk-cart" data-toggle="dropdown">
                                <div class="items-cart-inner">
                                    <div class="basket">
                                        <i class="glyphicon glyphicon-shopping-cart"></i>
                                    </div>
                                    <div class="basket-item-count">
                                        <span class="count">2</span>
                                    </div>
                                    <div class="total-price-basket">
                                        <span class="lbl">cart -</span>
                                        <span class="total-price">
                                            <span class="sign">$</span
                                            ><span class="value">600.00</span>
                                        </span>
                                    </div>
                                </div>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <div class="cart-item product-summary">
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <div class="image">
                                                    <a href="detail.html"
                                                        ><img src="assets/images/cart.jpg" alt=""
                                                    /></a>
                                                </div>
                                            </div>
                                            <div class="col-xs-7">
                                                <h3 class="name">
                                                    <a href="index.php?page-detail"
                                                        >Simple Product</a
                                                    >
                                                </h3>
                                                <div class="price">$600.00</div>
                                            </div>
                                            <div class="col-xs-1 action">
                                                <a href="#"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.cart-item -->
                                    <div class="clearfix"></div>
                                    <hr />
                                    <div class="clearfix cart-total">
                                        <div class="pull-right">
                                            <span class="text">Sub Total :</span
                                            ><span class="price">$600.00</span>
                                        </div>
                                        <div class="clearfix"></div>
                                        <a
                                            href="checkout.html"
                                            class="btn btn-upper btn-primary btn-block m-t-20"
                                            >Checkout</a
                                        >
                                    </div>
                                    <!-- /.cart-total-->
                                </li>
                            </ul>
                            <!-- /.dropdown-menu-->
                        </div>
                        <!-- /.dropdown-cart -->

                        <!-- ============================================================= SHOPPING CART DROPDOWN : END============================================================= -->
                    </div>
                    <!-- /.top-cart-row -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container -->
        </div>
        <!-- /.main-header -->

        <!-- ============================================== NAVBAR ============================================== -->
        <div class="header-nav animate-dropdown">
            <div class="container">
                <div class="yamm navbar navbar-default" role="navigation">
                    <div class="navbar-header">
                        <button
                            data-target="#mc-horizontal-menu-collapse"
                            data-toggle="collapse"
                            class="navbar-toggle collapsed"
                            type="button"
                        >
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span> <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="nav-bg-class">
                        <div class="navbar-collapse collapse" id="mc-horizontal-menu-collapse">
                            <div class="nav-outer">
                                <ul class="nav navbar-nav">
                                    <li class="active dropdown yamm-fw">
                                        <a
                                            href="home.html"
                                            data-hover="dropdown"
                                            class="dropdown-toggle"
                                            data-toggle="dropdown"
                                            >Home</a
                                        >
                                    </li>
                                    <li
                                        class="dropdown yamm mega-menu"
                                        v-for="data_menu in data_menus"
                                        :key="data_menu.id"
                                    >
                                        <a
                                            href="home.html"
                                            data-hover="dropdown"
                                            class="dropdown-toggle"
                                            data-toggle="dropdown"
                                            >{{ data_menu.category_name }}</a
                                        >
                                        <ul class="dropdown-menu container">
                                            <li>
                                                <div class="yamm-content">
                                                    <div class="row">
                                                        <div
                                                            class="
                                                                col-xs-12 col-sm-6 col-md-2 col-menu
                                                            "
                                                            v-for="sub_cat in data_menu.sub_category"
                                                            :key="sub_cat.id"
                                                        >
                                                            <h2 class="title">
                                                                {{ sub_cat.subcategory_name }}
                                                            </h2>

                                                            <ul
                                                                class="links"
                                                                v-for="(
                                                                    sub_sub_cat, index
                                                                ) in sub_cat.sub_sub_category"
                                                                :key="sub_sub_cat.id"
                                                            >
                                                                <li
                                                                    :style="[
                                                                        index ==
                                                                        sub_cat.sub_sub_category
                                                                            .length -
                                                                            1
                                                                            ? {
                                                                                  marginBottom:
                                                                                      '20px',
                                                                              }
                                                                            : {
                                                                                  marginBottom: 0,
                                                                              },
                                                                    ]"
                                                                >
                                                                    <a href="#">{{
                                                                        sub_sub_cat.subsubcategory_name
                                                                    }}</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- /.col -->

                                                        <!-- /.yamm-content -->
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropdown navbar-right special-menu">
                                        <a href="#">Todays offer</a>
                                    </li>
                                </ul>
                                <!-- /.navbar-nav -->
                                <div class="clearfix"></div>
                            </div>
                            <!-- /.nav-outer -->
                        </div>
                        <!-- /.navbar-collapse -->
                    </div>
                    <!-- /.nav-bg-class -->
                </div>
                <!-- /.navbar-default -->
            </div>
            <!-- /.container-class -->
        </div>
        <!-- /.header-nav -->
        <!-- ============================================== NAVBAR : END ============================================== -->
    </header>
</template>

<script>
import jQuery from 'jquery';
const $ = jQuery;
window.$ = $;
import 'jquery/dist/jquery.js';
import 'bootstrap-hover-dropdown/bootstrap-hover-dropdown.js';

export default {
    data() {
        return {
            data_menus: [],
        };
    },
    methods: {
        showData() {
            this.axios
                .get('api/mega-menu/get-menu-data', {})
                .then((response) => {
                    let responseData = response.data;
                    this.data_menus = responseData.mega_menu;
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => {
                    $('.dropdown-toggle').dropdownHover();
                });
        },
    },
    created() {
        this.showData();
    },
    mounted() {},
};
</script>

<style></style>
