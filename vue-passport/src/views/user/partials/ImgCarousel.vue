<template>
    <agile class="slider" :key="sliders.length" :options="options">
        <div v-for="slider in sliders" :key="slider.id">
            <div
                class="thing"
                :style="{
                    backgroundImage: `url(${BASE_URL}/storage/app/public/sliders/${slider.slider_image})`,
                }"
            >
                <div class="container-fluid">
                    <div class="data bg-color vertical-center text-left">
                        <div class="slider-header fadeInDown-1">{{ slider.slider_header }}</div>
                        <div class="big-text fadeInDown-1">
                            {{ slider.title }}
                        </div>
                        <div class="excerpt fadeInDown-2 hidden-xs">
                            <span>{{ slider.description }}</span>
                        </div>
                        <div class="button-holder fadeInDown-3">
                            <a
                                :href="slider.link"
                                class="btn-lg btn btn-uppercase shop-now-button"
                                >{{ slider.button_text }}</a
                            > 
                        </div>
                    </div>
                    <!-- /.data -->
                </div>
                <!-- /.container-fluid -->
            </div>
        </div>
        <template v-slot:prevButton><i class="fas fa-chevron-left"></i></template>
        <template v-slot:nextButton><i class="fas fa-chevron-right"></i></template>
    </agile>
</template>

<script>
import { BASE_URL } from '@/assets/js/base-url.js';
import jQuery from 'jquery';
import { VueAgile } from 'vue-agile'; // npm install vue-agile
const $ = jQuery;
window.$ = $;

export default {
    name: 'ImgCarousel',
    components: {
        agile: VueAgile,
    },
    data() {
        return {
            BASE_URL: BASE_URL,
            sliders: [],
            slide: 0,
            sliding: null,
            options: {
                autoplay: true,
                centerMode: true,
                dots: true,
                navButtons: true,
                slidesToShow: 1,
                pauseOnHover: true,
                pauseOnDotsHover: true,
                fade: false,
                timing: 'ease-in',
                speed: 2500,
                responsive: [
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 1,
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
                .get('api/sliders/show', {})
                .then((response) => {
                    let responseData = response.data;
                    this.sliders = responseData.sliders.data;
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => {
                    //
                });
        },
    },
    created() {
        this.showData();
    },
    mounted() {},
};
</script>
<style>
.slider .agile__nav-button {
    background: transparent;
    border: none;
    color: #fff;
    cursor: pointer;
    font-size: 24px;
    height: 100%;
    position: absolute;
    top: 0px;
    transition-duration: 0.3s;
    width: 80px;
}
.slider .agile__nav-button:hover {
    /*background-color: rgba(0, 0, 0, 0.5);*/
    opacity: 1;
}
.slider .agile__nav-button--prev {
    left: 0;
}
.slider .agile__nav-button--next {
    right: 0;
}
.slider .agile__dots {
    bottom: 10px;
    left: 50%;
    position: absolute;
    transform: translateX(-50%);
}
.slider .agile__dot {
    margin: 0 10px;
}
.slider .agile__dot button {
    background-color: transparent;
    border: 1px solid #fff;
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
.slider .agile__dot--current button,
.agile__dot:hover button {
    background-color: #fff;
}
.slide {
    display: block;
    height: 370px;
    -o-object-fit: cover;
    object-fit: cover;
    width: 100%;
}

.data {
    display: table-cell;
    width: 50%;
}
.data.vertical-center {
    vertical-align: middle;
    padding-bottom: 3vh;
}
.data.vertical-top {
    vertical-align: top;
    padding-top: 8vh;
}
.data.vertical-bottom {
    vertical-align: bottom;
    padding-bottom: 14vh;
}
.data.text-center {
    padding-left: 10%;
    padding-right: 10%;
}
.data.text-left {
    padding-right: 20%;
    padding-left: 2%;
}
.data.text-right {
    padding-left: 20%;
}

.thing {
    background-color: #ffffff;
    background-position: center 55%;
    background-size: cover;
    height: 370px;
}
.thing .data {
    color: #636363;
    position: absolute;
    top: 24%;
    z-index: 100;
    padding-right: 8%;
    margin-left: 5%;
}
.thing .data .slider-header {
    font-family: 'Montserrat', sans-serif;
    font-size: 14px;
    font-weight: bold;
    text-transform: uppercase;
}

.thing .data .big-text {
    font-size: 42px;
    line-height: 50px;
    text-transform: uppercase;
    font-family: 'Montserrat', sans-serif;
    padding: 0px 25px;
    background: #bbbbbb;
    color: #fff;
    font-weight: 700;
    letter-spacing: -1px;
}
.thing .data .big-text .highlight {
    color: #f1c40f;
}
.excerpt {
    width: 80%;
}
.thing .data .excerpt,
.thing .data .small {
    font-size: 14px;
    /*line-height: 50px;*/
    margin-top: 10px;
    font-family: 'Open Sans', sans-serif;
    font-weight: 500;
    padding-left: 23px;
    background: rgba(0, 0, 0, 0);
    color: #fff;
}
.thing .data .excerpt span,
.thing .data .small span {
    background: none repeat scroll 0 0 #bbbbbb;
    -moz-box-shadow: -1.4em 0 0 #bbbbbb, 1.4em 0 0 #bbbbbb;
    -webkit-box-shadow: -1.4em 0 0 #bbbbbb, 1.4em 0 0 #bbbbbb;
    box-shadow: -1.4em 0 0 #bbbbbb, 1.4em 0 0 #bbbbbb;
    line-height: 336%;
    padding: 5px 0;
    display: inline;
}
.thing .data .button-holder {
    margin: 20px 0 0;
}
.thing .data.bg-color {
    padding-right: 3%;
}
.thing .data.bg-color .big-text {
    background: rgba(0, 0, 0, 0);
    padding: 0px;
    color: #000;
}
.thing .data.bg-color .excerpt,
.thing .data.bg-color .small {
    background: rgba(0, 0, 0, 0);
    padding: 0px;
    color: #000;
    margin-top: 0px;
}
.thing .data.bg-color .excerpt span,
.thing .data.bg-color .small span {
    background: rgba(0, 0, 0, 0);
    -moz-box-shadow: none;
    -webkit-box-shadow: none;
    box-shadow: none;
    display: block;
    line-height: 24px;
}
</style>
