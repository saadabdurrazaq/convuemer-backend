<template>
    <!-- ============================================== PRODUCT SLIDER ============================================== -->
    <div id="product-tabs-slider" class="scroll-tabs outer-top-vs wow fadeInUp">
        <div class="more-info-tab clearfix">
            <h3 class="new-product-title pull-left" style="margin-left: 3px">Featured Products</h3>
        </div>
        <div class="thumbnails-wrapper">
            <!-- agile here -->
            <agile
                class="thumbnails"
                ref="thumbnails"
                :options="options"
                :key="productSliders.length"
            >
                <div
                    class="slide slide--thumbniail"
                    v-for="slider in productSliders"
                    :key="slider.id"
                >
                    <div class="product-image">
                        <div
                            class="image"
                            :set="(images = JSON.parse(slider.images))"
                            :key="images[0].key"
                        >
                            <img
                                :src="`${BASE_URL}/storage/app/public/products/${images[0].caption}`"
                                alt=""
                            />
                        </div>
                        <!-- /.image -->
                    </div>
                    <!-- /.product-image -->

                    <div class="description">
                        <h4>
                            <router-link
                                :to="{
                                    name: 'product-show',
                                    params: { id: slider.id, slug: slider.product_slug },
                                }"
                                ><span class="name">{{
                                    slider.product_name.substring(0, 20)
                                }}</span>
                                <br /><br />
                                <span class="price"
                                    >Rp. {{ slider.price.toLocaleString('id') }}</span
                                >
                            </router-link>
                        </h4>
                        <!-- /.product-price -->
                    </div>
                    <!-- /.product-info -->
                    <!-- /.cart -->
                </div>
                <!-- class="slide" -->
                <template v-slot:prevButton><i class="fas fa-chevron-left"></i></template>
                <template v-slot:nextButton><i class="fas fa-chevron-right"></i></template>
            </agile>
            <!-- end agile here -->
        </div>
    </div>
    <!-- ============================================== END PRODUCT SLIDER ============================================== -->
</template>

<script>
/*import jQuery from 'jquery';
const $ = jQuery;
window.$ = $;*/
import { VueAgile } from 'vue-agile'; // npm install vue-agile
import { BASE_URL } from '@/assets/js/base-url.js';

export default {
    beforeCreate: function () {
        document.body.className = 'welcome';
        document.body.classList.remove('login', 'hold-transition', 'sidebar-mini');
        document.body.classList.add('cnt-home');
    },

    components: {
        agile: VueAgile,
    },

    data() {
        return {
            BASE_URL: BASE_URL,
            productSliders: [],
            slide: 0,
            sliding: null,
            options: {
                autoplay: true,
                centerMode: true,
                dots: false,
                navButtons: false, 
                slidesToShow: 3,
                responsive: [
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 4,
                        },
                    },

                    {
                        breakpoint: 1000,
                        settings: {
                            navButtons: true,
                        },
                    },
                ],
            },
        };
    },

    methods: {
        initCarousel() {
            this.sliding = true;
        },
        endSlide() {
            this.sliding = false;
        },
        showData() {
            this.axios
                .get('api/product-sliders/show-featured-products', {})
                .then((response) => {
                    let responseData = response.data;
                    this.productSliders = responseData.products;
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => {
                    //
                });
        },
    },
    watch: {
        // It will reload the request page.
        $route() {
            this.$router.go();
        },
    },
    created() {
        this.showData();
    },
    mounted() {},
};
</script>

<style>
.thumbnails-wrapper {
    margin-left: 15px;
    margin-right: 15px;
    margin-top: 20px;
}
.thumbnails {
    top: 50%;
}
.agile__nav-button {
    border: none;
    color: #888;
    cursor: pointer;
    font-size: 14px;
    top: -45px;
    transition-duration: 0.3s;
}
.thumbnails .agile__nav-button {
    position: absolute;
    transform: translateY(-50%);
}
.thumbnails .agile__nav-button--prev {
    right: 35px;
}
.thumbnails .agile__nav-button--next {
    right: 5px;
}
.thumbnails .fa-chevron-right {
    padding-top: 5px;
    padding-bottom: 5px;
    padding-left: 7px;
    padding-right: 7px;
    background: #dddddd;
}
.thumbnails .fa-chevron-left {
    padding-top: 5px;
    padding-bottom: 5px;
    padding-left: 7px;
    padding-right: 7px;
    background: #dddddd;
}
.agile__nav-button:hover {
    color: #888;
}
.agile__dot {
    margin: 0 10px;
}
.agile__dot button {
    background-color: #eee;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    display: block;
    height: 10px;
    font-size: 0;
    line-height: 0;
    margin: 0;
    padding: 0;
    transition-duration: 0.3s;
    width: 10px;
}
.agile__dot--current button,
.agile__dot:hover button {
    background-color: #888;
}
.slide--thumbniail {
    cursor: pointer;
    height: 100px;
    padding: 0 7px;
    transition: opacity 0.3s;
}
.slide--thumbniail:hover {
    opacity: 0.75;
}
.slide {
    align-items: center;
    box-sizing: border-box;
    color: #fff;
    height: 300px;
}
.slide img {
    height: 189px;
    -o-object-fit: cover;
    object-fit: cover;
    -o-object-position: center;
    object-position: center;
    width: 189px;
    width: 100%;
}
.name {
    color: #555;
    font-size: 15px;
    font-family: 'Open Sans', sans-serif;
}
.price {
    color: black;
}
.slide .description {
    text-align: center;
}
</style>
