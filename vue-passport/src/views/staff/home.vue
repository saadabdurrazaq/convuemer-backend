<template>
    <div class="wrapper">
        <Nav />
        <Sidebar />
        <div class="content-wrapper">
            <div class="content-header">
                <div class="content">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">Dashboard</div>
                                    <div class="card-body">
                                        Selamat datang <strong>{{ staffData.data.name }}</strong>
                                        <div class="speech-to-txt" @click="startSpeechToTxt">
                                            Speech to txt
                                        </div>
                                        <p>{{ transcription_ }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Footer />
    </div>
</template>

<script>
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
    data() {
        return {
            staffData: '',
            runtimeTranscription_: '',
            transcription_: [],
            lang_: 'en-EN',
        };
    },
    methods: {
        checkAuth() {  
            // state token
            const token = localStorage.getItem('token-staff');
            let staffData = JSON.parse(localStorage.getItem('staff-data'));
            this.staffData = staffData;

            //inisialisasi vue router on Composition API
            const router = useRouter();

            if (!token) {
                return router.push({
                    name: 'staff-login',
                });
            }
        },
        startSpeechToTxt() {
            // initialisation of voicereco
            window.SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            const recognition = new window.SpeechRecognition();
            recognition.lang = this.lang_;
            recognition.interimResults = true;

            // event current voice reco word
            recognition.addEventListener('result', (event) => {
                var text = Array.from(event.results)
                    .map((result) => result[0])
                    .map((result) => result.transcript)
                    .join('');
                this.runtimeTranscription_ = text;
            });
            
            // end of transcription
            recognition.addEventListener('end', () => {
                this.transcription_.push(this.runtimeTranscription_);
                this.runtimeTranscription_ = '';
                recognition.stop();
            });
            recognition.start();
        },
    },
    created() {
        this.checkAuth();
    },
    mounted() {},
};
</script>

<style lang="scss" scoped>
@import '~admin-lte/dist/css/adminlte.min.css';
body.home-staff {
    background: lightgray !important;
}
</style>
