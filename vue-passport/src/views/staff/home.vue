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
                    <div class="speech-to-txt" @click="greeting">Speech to txt</div>
                    <p>{{ transcription_ }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- chat box -->
      <div class="fabs">
        <div class="card card-primary direct-chat direct-chat-primary chat">
          <div class="chat_header">
            <div class="chat_option">
              <div class="header_img">
                <img
                  src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAMDAwMDAwQEBAQFBQUFBQcHBgYHBwsICQgJCAsRCwwLCwwLEQ8SDw4PEg8bFRMTFRsfGhkaHyYiIiYwLTA+PlQBAwMDAwMDBAQEBAUFBQUFBwcGBgcHCwgJCAkICxELDAsLDAsRDxIPDg8SDxsVExMVGx8aGRofJiIiJjAtMD4+VP/CABEIADwAPAMBIgACEQEDEQH/xAAcAAEAAQUBAQAAAAAAAAAAAAAABgEDBAUHAgn/2gAIAQEAAAAA+lYAj8cy5ndHO8VNN0IFrk62gjEYudH9iLQPN6lec+0VmtG038L9UpWh/8QAFAEBAAAAAAAAAAAAAAAAAAAAAP/aAAgBAhAAAAAAAP/EABQBAQAAAAAAAAAAAAAAAAAAAAD/2gAIAQMQAAAAAAD/xAAuEAABAwMACAUEAwAAAAAAAAABAgMEAAURBhASEyAhQVEiMmKRwSNxcoExQqH/2gAIAQEAAT8A14PHdbuuMvcMY2wPGs88Z6ClT5qzlUh0n8qjXmawoFay8jqlfwaZebkNIdbOUrGRwCpxJmySf53qtdgJNu+zq+G7N7u4yPUoK9xrsyC3bWfUVL9zw6QxiS1IA5Y2F/Gpplb7qGkeZasCkNpabQhPlQkJH64CMDJ5DvWkk+Gu3uRm3wp5ak42Dkp2TnJNC4S2hhyPvT0Wg4z9xVqmuN3SNJl/TabUcITzxkY2j3piRHkjLLrbg9Ks1gjVL0nnvLVuAllHTllf7Jp+VKknLz7jn5K+KAAGNY8JykkHuDg0xe7rG5JkqUB/VY2x/tR9LkBvEmMsud2/KfeumrtXSu9dKFZNf//EABQRAQAAAAAAAAAAAAAAAAAAAED/2gAIAQIBAT8AB//EABQRAQAAAAAAAAAAAAAAAAAAAED/2gAIAQMBAT8AB//Z"
                />
              </div>
              <span id="chat_head">Jane Doe</span> <br />
              <span class="agent">Agent</span> <span class="online">(Online)</span>
              <span id="chat_fullscreen_loader" class="chat_fullscreen_loader"
                ><i class="fullscreen zmdi zmdi-window-maximize"></i
              ></span>
            </div>
          </div>
          <div class="chat_body" id="msgs" style="height: 300px">
            <!-- chat list -->
          </div>
          <div id="chat_form" class="chat_converse chat_form">
            <a id="chat_fourth_screen" class="fab"><i class="zmdi zmdi-arrow-right"></i></a>
            <span class="chat_msg_item chat_msg_item_admin">
              <div class="chat_avatar">
                <img
                  src="http://res.cloudinary.com/dqvwa7vpe/image/upload/v1496415051/avatar_ma6vug.jpg"
                />
              </div>
              Hey there! Any question?</span
            >
            <span class="chat_msg_item chat_msg_item_user"> Hello!</span>
            <span class="status">20m ago</span>
            <span class="chat_msg_item chat_msg_item_admin">
              <div class="chat_avatar">
                <img
                  src="http://res.cloudinary.com/dqvwa7vpe/image/upload/v1496415051/avatar_ma6vug.jpg"
                />
              </div>
              Agent typically replies in a few hours. Don't miss their reply.
              <div>
                <br />
                <form class="get-notified">
                  <label for="chat_log_email">Get notified by email</label>
                  <input id="chat_log_email" placeholder="Enter your email" />
                  <i class="zmdi zmdi-chevron-right"></i>
                </form></div
            ></span>
            <span class="chat_msg_item chat_msg_item_admin">
              <div class="chat_avatar">
                <img
                  src="http://res.cloudinary.com/dqvwa7vpe/image/upload/v1496415051/avatar_ma6vug.jpg"
                />
              </div>
              Send message to agent.
              <div>
                <form class="message_form">
                  <input placeholder="Your email" />
                  <input placeholder="Technical issue" />
                  <textarea rows="4" placeholder="Your message"></textarea>
                  <button>Send</button>
                </form>
              </div></span
            >
          </div>
          <div class="fab_field">
            <a id="fab_send" @click.stop.prevent="microphoneClick()" class="fab"
              ><i class="fa fa-microphone icon-to-change"></i
            ></a>
            <textarea
              id="chatSend"
              name="chat_message"
              :placeholder="placeholderValue"
              class="chat_field chat_message"
              disabled
            ></textarea>
          </div>
        </div>
        <a id="prime" class="fab" @click.stop.prevent="toggleFab()"
          ><i class="prime zmdi zmdi-comment-outline"></i
        ></a>
      </div>
      <!-- end chat box -->
    </div>
    <Footer />
  </div>
</template>

<script>
import jQuery from 'jquery';
const $ = jQuery;
window.$ = $;
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
      lang_: 'id-ID',
      synth: window.speechSynthesis,
      voiceList: [],
      greetingSpeech: new window.SpeechSynthesisUtterance(),
      placeholderValue: 'Send a voice!',
      isClicked: false,
      currentRec: '',
      botVoice: '',
      userVoice: '',
      chatList: [],
      indexChatUser: 0,
      indexChatBot: 0,
      countOpenFab: 0,
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
    toggleFab() {
      $('.prime').toggleClass('zmdi-comment-outline');
      $('.prime').toggleClass('zmdi-close');
      $('.prime').toggleClass('is-active');
      $('.prime').toggleClass('is-visible');
      $('#prime').toggleClass('is-float');
      $('.chat').toggleClass('is-visible');
      $('.fab').toggleClass('is-visible');
      this.hideChat(0);

      // if user open the chat
      this.countOpenFab = this.countOpenFab+1;
      if ($('.is-visible').is(':hidden') && this.countOpenFab === 1) { // show greeting only at the first time
        this.greeting();
      } else {
        // if user close the chat, stop window.speechSynthesis(synth.cancel()) and also stop SpeechRecognition()(const recognition)
        this.synth.cancel();
      }
    },
    hideChat(hide) {
      switch (hide) {
        case 0:
          $('#chat_converse').css('display', 'none');
          $('#chat_body').css('display', 'none');
          $('#chat_form').css('display', 'none');
          $('.chat_login').css('display', 'block');
          $('.chat_fullscreen_loader').css('display', 'none');
          $('#chat_fullscreen').css('display', 'none');
          break;
        case 1:
          $('#chat_converse').css('display', 'block');
          $('#chat_body').css('display', 'none');
          $('#chat_form').css('display', 'none');
          $('.chat_login').css('display', 'none');
          $('.chat_fullscreen_loader').css('display', 'block');
          break;
        case 2:
          $('#chat_converse').css('display', 'none');
          $('#chat_body').css('display', 'block');
          $('#chat_form').css('display', 'none');
          $('.chat_login').css('display', 'none');
          $('.chat_fullscreen_loader').css('display', 'block');
          break;
        case 3:
          $('#chat_converse').css('display', 'none');
          $('#chat_body').css('display', 'none');
          $('#chat_form').css('display', 'block');
          $('.chat_login').css('display', 'none');
          $('.chat_fullscreen_loader').css('display', 'block');
          break;
        case 4:
          $('#chat_converse').css('display', 'none');
          $('#chat_body').css('display', 'none');
          $('#chat_form').css('display', 'none');
          $('.chat_login').css('display', 'none');
          $('.chat_fullscreen_loader').css('display', 'block');
          $('#chat_fullscreen').css('display', 'block');
          break;
      }
    },
    greeting() {
      this.voiceList = this.synth.getVoices();
      this.synth.onvoiceschanged = () => {
        this.voiceList = this.synth.getVoices();
      };
      this.greetingSpeech.text = `Selamat datang bla bla bla. Silahkan tentukan pilihan Anda!`;
      this.botVoice = this.greetingSpeech.text;
      this.greetingSpeech.voice = this.voiceList[11];
      this.synth.speak(this.greetingSpeech);

      // Show greeting in a chatbox
      $('.greeting').remove();
      $('.chat_body').append('<div class="direct-chat-msg chat-default" style="width: 80%; margin-left: 5px; text-align: left;"></div>'); // add new element (direct-chat-msg) inside chat_body
      $('.chat-default').append(
        "<img class='direct-chat-img' src='data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAMDAwMDAwQEBAQFBQUFBQcHBgYHBwsICQgJCAsRCwwLCwwLEQ8SDw4PEg8bFRMTFRsfGhkaHyYiIiYwLTA+PlQBAwMDAwMDBAQEBAUFBQUFBwcGBgcHCwgJCAkICxELDAsLDAsRDxIPDg8SDxsVExMVGx8aGRofJiIiJjAtMD4+VP/CABEIADwAPAMBIgACEQEDEQH/xAAcAAEAAQUBAQAAAAAAAAAAAAAABgEDBAUHAgn/2gAIAQEAAAAA+lYAj8cy5ndHO8VNN0IFrk62gjEYudH9iLQPN6lec+0VmtG038L9UpWh/8QAFAEBAAAAAAAAAAAAAAAAAAAAAP/aAAgBAhAAAAAAAP/EABQBAQAAAAAAAAAAAAAAAAAAAAD/2gAIAQMQAAAAAAD/xAAuEAABAwMACAUEAwAAAAAAAAABAgMEAAURBhASEyAhQVEiMmKRwSNxcoExQqH/2gAIAQEAAT8A14PHdbuuMvcMY2wPGs88Z6ClT5qzlUh0n8qjXmawoFay8jqlfwaZebkNIdbOUrGRwCpxJmySf53qtdgJNu+zq+G7N7u4yPUoK9xrsyC3bWfUVL9zw6QxiS1IA5Y2F/Gpplb7qGkeZasCkNpabQhPlQkJH64CMDJ5DvWkk+Gu3uRm3wp5ak42Dkp2TnJNC4S2hhyPvT0Wg4z9xVqmuN3SNJl/TabUcITzxkY2j3piRHkjLLrbg9Ks1gjVL0nnvLVuAllHTllf7Jp+VKknLz7jn5K+KAAGNY8JykkHuDg0xe7rG5JkqUB/VY2x/tR9LkBvEmMsud2/KfeumrtXSu9dKFZNf//EABQRAQAAAAAAAAAAAAAAAAAAAED/2gAIAQIBAT8AB//EABQRAQAAAAAAAAAAAAAAAAAAAED/2gAIAQMBAT8AB//Z'/>"
      );
      $('.chat-default').append('<div class="direct-chat-text greeting"></div>');
      let msg = $('.greeting');
      msg.text(this.greetingSpeech.text);

      // if user speak, start proceed its voice
      if (this.isClicked === true) {
        var self = this;
        this.greetingSpeech.onend = function () {
          self.startSpeechToTxt();
        };
      }
    },
    microphoneClick() {
      if (this.placeholderValue === 'Send a voice!') {
        this.synth.cancel();
        this.isClicked = true;
        this.placeholderValue = 'Listening... Please wait!';
        $('#fab_send').css({ 'background-color': '#42A5F5' });
        $('.icon-to-change').css({ color: 'white' });
        this.startSpeechToTxt();
      } else {
        $('#fab_send').css({ 'background-color': 'white' });
        $('.icon-to-change').css({ color: '#42A5F5' });
        this.placeholderValue = 'Send a voice!';
        this.synth.cancel();
        this.currentRec.stop();
      }
    },
    startSpeechToTxt() {
      console.log('listening...');
      var self = this;

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

      this.currentRec = recognition;

      // end of transcription
      recognition.addEventListener('end', () => {
        this.transcription_ = [];
        this.transcription_.push(this.runtimeTranscription_);

        this.userVoice = this.transcription_[0];

        if (this.transcription_[0] !== '') {
          // open link in the same tab and in the same browser
          // window.location.replace('http://localhost/elven/pa-tulungagung/?s=' + this.transcription_[0]);

          // show voice reply
          this.voiceList = this.synth.getVoices();
          this.synth.onvoiceschanged = () => {
            this.voiceList = this.synth.getVoices();
          };
          this.greetingSpeech.text = `${this.transcription_[0]}`;
          this.greetingSpeech.voice = this.voiceList[11];

          if (this.transcription_[0] !== 'cerai talak') {
            this.placeholderValue = '';
            $('#fab_send').css({ 'background-color': 'white' });
            $('.icon-to-change').css({ color: '#42A5F5' });

            this.showUserVoiceAsText(this.transcription_[0]);
            this.showBotVoiceAsText('Maaf, pilihan Anda tidak tersedia, silahkan pilih opsi lain!');

            // show bot voice 
            this.greetingSpeech.text =
              'Maaf, pilihan Anda tidak tersedia, silahkan pilih opsi lain!';
            this.synth.speak(this.greetingSpeech);
            this.greetingSpeech.onend = function () {
              self.microphoneClick();
            };
          } else {
            this.greetingSpeech.text = 'Anda ingin cerai talak? Kami akan segera memprosesnya.';
            this.synth.speak(this.greetingSpeech);
            recognition.stop();
            this.greetingSpeech.onend = function () {
              self.synth.cancel();
            };

            this.placeholderValue = 'Send a voice!';
            $('#fab_send').css({ 'background-color': 'white' });
            $('.icon-to-change').css({ color: '#42A5F5' });

            this.showUserVoiceAsText(this.transcription_[0]);
            this.showBotVoiceAsText(this.greetingSpeech.text);
          }
        } else if (this.transcription_[0] === '') {
          this.greetingSpeech.text = 'Maaf, kami tidak mendengar suara Anda. Silahkan coba lagi!';
          this.synth.speak(this.greetingSpeech);
          recognition.stop();
          this.greetingSpeech.onend = function () {
            self.synth.cancel();
          };
          this.placeholderValue = 'Send a voice!';
          $('#fab_send').css({ 'background-color': 'white' });
          $('.icon-to-change').css({ color: '#42A5F5' });
        }

        this.runtimeTranscription_ = '';
        recognition.stop();
      });
      recognition.start();
    },
    showUserVoiceAsText(transcript) {
      this.indexChatUser = this.indexChatUser+1;
      $('.chat_body').append(`<div class='direct-chat-msg right user-chat-${this.indexChatUser+1}' style="width: 98%; text-align: left;"></div>`); 
      $(`.user-chat-${this.indexChatUser+1}`).append(
        "<img class='direct-chat-img' src='data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAMDAwMDAwQEBAQFBQUFBQcHBgYHBwsICQgJCAsRCwwLCwwLEQ8SDw4PEg8bFRMTFRsfGhkaHyYiIiYwLTA+PlQBAwMDAwMDBAQEBAUFBQUFBwcGBgcHCwgJCAkICxELDAsLDAsRDxIPDg8SDxsVExMVGx8aGRofJiIiJjAtMD4+VP/CABEIADwAPAMBIgACEQEDEQH/xAAcAAEAAQUBAQAAAAAAAAAAAAAABgEDBAUHAgn/2gAIAQEAAAAA+lYAj8cy5ndHO8VNN0IFrk62gjEYudH9iLQPN6lec+0VmtG038L9UpWh/8QAFAEBAAAAAAAAAAAAAAAAAAAAAP/aAAgBAhAAAAAAAP/EABQBAQAAAAAAAAAAAAAAAAAAAAD/2gAIAQMQAAAAAAD/xAAuEAABAwMACAUEAwAAAAAAAAABAgMEAAURBhASEyAhQVEiMmKRwSNxcoExQqH/2gAIAQEAAT8A14PHdbuuMvcMY2wPGs88Z6ClT5qzlUh0n8qjXmawoFay8jqlfwaZebkNIdbOUrGRwCpxJmySf53qtdgJNu+zq+G7N7u4yPUoK9xrsyC3bWfUVL9zw6QxiS1IA5Y2F/Gpplb7qGkeZasCkNpabQhPlQkJH64CMDJ5DvWkk+Gu3uRm3wp5ak42Dkp2TnJNC4S2hhyPvT0Wg4z9xVqmuN3SNJl/TabUcITzxkY2j3piRHkjLLrbg9Ks1gjVL0nnvLVuAllHTllf7Jp+VKknLz7jn5K+KAAGNY8JykkHuDg0xe7rG5JkqUB/VY2x/tR9LkBvEmMsud2/KfeumrtXSu9dKFZNf//EABQRAQAAAAAAAAAAAAAAAAAAAED/2gAIAQIBAT8AB//EABQRAQAAAAAAAAAAAAAAAAAAAED/2gAIAQMBAT8AB//Z'/>"
      );
      $(`.user-chat-${this.indexChatUser+1}`).append(`<div class="direct-chat-text user-text" style="margin-left:55px;">${transcript}</div>`);   
    },
    showBotVoiceAsText(transcript) {
      this.indexChatBot = this.indexChatBot+1;
      $('.chat_body').append(`<div class='direct-chat-msg chat-default-${this.indexChatBot+1}' style="width: 80%; margin-left: 5px; text-align: left;"></div>`); // add new element (direct-chat-msg) inside chat_body
      $(`.chat-default-${this.indexChatBot+1}`).append(
        "<img class='direct-chat-img' src='data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAMDAwMDAwQEBAQFBQUFBQcHBgYHBwsICQgJCAsRCwwLCwwLEQ8SDw4PEg8bFRMTFRsfGhkaHyYiIiYwLTA+PlQBAwMDAwMDBAQEBAUFBQUFBwcGBgcHCwgJCAkICxELDAsLDAsRDxIPDg8SDxsVExMVGx8aGRofJiIiJjAtMD4+VP/CABEIADwAPAMBIgACEQEDEQH/xAAcAAEAAQUBAQAAAAAAAAAAAAAABgEDBAUHAgn/2gAIAQEAAAAA+lYAj8cy5ndHO8VNN0IFrk62gjEYudH9iLQPN6lec+0VmtG038L9UpWh/8QAFAEBAAAAAAAAAAAAAAAAAAAAAP/aAAgBAhAAAAAAAP/EABQBAQAAAAAAAAAAAAAAAAAAAAD/2gAIAQMQAAAAAAD/xAAuEAABAwMACAUEAwAAAAAAAAABAgMEAAURBhASEyAhQVEiMmKRwSNxcoExQqH/2gAIAQEAAT8A14PHdbuuMvcMY2wPGs88Z6ClT5qzlUh0n8qjXmawoFay8jqlfwaZebkNIdbOUrGRwCpxJmySf53qtdgJNu+zq+G7N7u4yPUoK9xrsyC3bWfUVL9zw6QxiS1IA5Y2F/Gpplb7qGkeZasCkNpabQhPlQkJH64CMDJ5DvWkk+Gu3uRm3wp5ak42Dkp2TnJNC4S2hhyPvT0Wg4z9xVqmuN3SNJl/TabUcITzxkY2j3piRHkjLLrbg9Ks1gjVL0nnvLVuAllHTllf7Jp+VKknLz7jn5K+KAAGNY8JykkHuDg0xe7rG5JkqUB/VY2x/tR9LkBvEmMsud2/KfeumrtXSu9dKFZNf//EABQRAQAAAAAAAAAAAAAAAAAAAED/2gAIAQIBAT8AB//EABQRAQAAAAAAAAAAAAAAAAAAAED/2gAIAQMBAT8AB//Z'/>"
      );
      $(`.chat-default-${this.indexChatBot+1}`).append(`<div class="direct-chat-text bot-voice">${transcript}</div>`);
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
/*
  There is a conflict between adminlte.min.css and docs.md-iconic-font.min.css that called in public/index.html so, the navbar height must be reverted
*/
.navbar {
  min-height: revert;
}
body.home-staff {
  background: lightgray !important;
}
.chat-default {
  width: 80%; margin-left: 5px; text-align: left;
}
.chat-right:before {
  color: #42a5f5;
}
.chat-right {
  background-color: #42a5f5;
  margin-right: -1px;
}

/* Chat box */
.messages {
  padding: 10px;
  margin: 0;
  list-style: none;
  overflow-y: scroll;
  overflow-x: hidden;
  flex-grow: 1;
  border-radius: 4px;
  background: transparent;
  li {
    position: relative;
    clear: both;
    display: inline-block;
    padding: 14px;
    margin: 0 0 20px 0;
    font: 12px/16px 'Noto Sans', sans-serif;
    border-radius: 10px;
    word-wrap: break-word;
    max-width: 81%;
    &:before {
      content: ' ';
      display: inline-block;
      position: absolute;
      top: 0;
      width: 30px;
      height: 30px;
      border-radius: 30px;
      content: '';
      background-size: cover;
    }
    &:after {
      content: ' ';
      display: inline-block;
      position: absolute;
      top: 30px;
      content: '';
      width: 0;
      height: 0;
      border-top: 30px solid black;
    }
  }
  li.other {
    content: ' ';
    animation: show-chat-odd 0.15s 1 ease-in;
    -moz-animation: show-chat-odd 0.15s 1 ease-in;
    -webkit-animation: show-chat-odd 0.15s 1 ease-in;
    float: right;
    color: white;
    text-align: left;
    background-color: #42a5f5;
  }
  li.self {
    content: ' ';
    animation: show-chat-even 0.15s 1 ease-in;
    -moz-animation: show-chat-even 0.15s 1 ease-in;
    -webkit-animation: show-chat-even 0.15s 1 ease-in;
    float: left;
    margin-left: 35px;
    color: black;
    text-align: left;
    background-color: #f3f3f3;
  }
  li.self:before {
    content: ' ';
    display: inline-block;
    left: -35px;
    background-image: url(data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAMDAwMDAwQEBAQFBQUFBQcHBgYHBwsICQgJCAsRCwwLCwwLEQ8SDw4PEg8bFRMTFRsfGhkaHyYiIiYwLTA+PlQBAwMDAwMDBAQEBAUFBQUFBwcGBgcHCwgJCAkICxELDAsLDAsRDxIPDg8SDxsVExMVGx8aGRofJiIiJjAtMD4+VP/CABEIADwAPAMBIgACEQEDEQH/xAAcAAEAAQUBAQAAAAAAAAAAAAAABgEDBAUHAgn/2gAIAQEAAAAA+lYAj8cy5ndHO8VNN0IFrk62gjEYudH9iLQPN6lec+0VmtG038L9UpWh/8QAFAEBAAAAAAAAAAAAAAAAAAAAAP/aAAgBAhAAAAAAAP/EABQBAQAAAAAAAAAAAAAAAAAAAAD/2gAIAQMQAAAAAAD/xAAuEAABAwMACAUEAwAAAAAAAAABAgMEAAURBhASEyAhQVEiMmKRwSNxcoExQqH/2gAIAQEAAT8A14PHdbuuMvcMY2wPGs88Z6ClT5qzlUh0n8qjXmawoFay8jqlfwaZebkNIdbOUrGRwCpxJmySf53qtdgJNu+zq+G7N7u4yPUoK9xrsyC3bWfUVL9zw6QxiS1IA5Y2F/Gpplb7qGkeZasCkNpabQhPlQkJH64CMDJ5DvWkk+Gu3uRm3wp5ak42Dkp2TnJNC4S2hhyPvT0Wg4z9xVqmuN3SNJl/TabUcITzxkY2j3piRHkjLLrbg9Ks1gjVL0nnvLVuAllHTllf7Jp+VKknLz7jn5K+KAAGNY8JykkHuDg0xe7rG5JkqUB/VY2x/tR9LkBvEmMsud2/KfeumrtXSu9dKFZNf//EABQRAQAAAAAAAAAAAAAAAAAAAED/2gAIAQIBAT8AB//EABQRAQAAAAAAAAAAAAAAAAAAAED/2gAIAQMBAT8AB//Z);
  }
}

ul li {
  list-style: none;
}
.fabs {
  bottom: 50px;
  position: fixed;
  margin: 1em;
  right: 0;
  z-index: 998;
}

.fab {
  display: block;
  width: 56px;
  height: 56px;
  border-radius: 50%;
  text-align: center;
  color: #f0f0f0;
  margin: 25px auto 0;
  box-shadow: 0 0 4px rgba(0, 0, 0, 0.14), 0 4px 8px rgba(0, 0, 0, 0.28);
  cursor: pointer;
  -webkit-transition: all 0.1s ease-out;
  transition: all 0.1s ease-out;
  position: relative;
  z-index: 998;
  overflow: hidden;
  background: #42a5f5;
}

.fab > i {
  font-size: 2em;
  line-height: 55px;
  -webkit-transition: all 0.2s ease-out;
  -webkit-transition: all 0.2s ease-in-out;
  transition: all 0.2s ease-in-out;
}

.fab:not(:last-child) {
  width: 0;
  height: 0;
  margin: 20px auto 0;
  opacity: 0;
  visibility: hidden;
  line-height: 40px;
}

.fab:not(:last-child) > i {
  font-size: 1.4em;
  line-height: 40px;
}

.fab:not(:last-child).is-visible {
  width: 40px;
  height: 40px;
  margin: 15px auto 10;
  opacity: 1;
  visibility: visible;
}

.fab:nth-last-child(1) {
  -webkit-transition-delay: 25ms;
  transition-delay: 25ms;
}

.fab:not(:last-child):nth-last-child(2) {
  -webkit-transition-delay: 20ms;
  transition-delay: 20ms;
}

.fab:not(:last-child):nth-last-child(3) {
  -webkit-transition-delay: 40ms;
  transition-delay: 40ms;
}

.fab:not(:last-child):nth-last-child(4) {
  -webkit-transition-delay: 60ms;
  transition-delay: 60ms;
}

.fab:not(:last-child):nth-last-child(5) {
  -webkit-transition-delay: 80ms;
  transition-delay: 80ms;
}

.chat {
  position: fixed;
  right: 85px;
  bottom: 70px;
  width: 400px;
  font-size: 12px;
  line-height: 22px;
  font-family: 'Roboto';
  font-weight: 500;
  -webkit-font-smoothing: antialiased;
  font-smoothing: antialiased;
  opacity: 0;
  box-shadow: 1px 1px 100px 2px rgba(0, 0, 0, 0.22);
  border-radius: 10px;
  -webkit-transition: all 0.2s ease-out;
  -webkit-transition: all 0.2s ease-in-out;
  transition: all 0.2s ease-in-out;
}

.chat_fullscreen {
  position: fixed;
  right: 0px;
  bottom: 0px;
  top: 0px;
}
.chat_header {
  /* margin: 10px; */
  font-size: 13px;
  font-family: 'Roboto';
  font-weight: 500;
  color: #f3f3f3;
  height: 55px;
  background: #42a5f5;
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
  padding-top: 8px;
}
.chat_header2 {
  /* margin: 10px; */
  border-top-left-radius: 0px;
  border-top-right-radius: 0px;
}
.chat_header .span {
  float: right;
}

.chat_fullscreen_loader {
  display: none;
  float: right;
  cursor: pointer;
  /* margin: 10px; */
  font-size: 20px;
  opacity: 0.5;
  /* padding: 20px; */
  margin: -10px 10px;
}

.chat.is-visible {
  opacity: 1;
  -webkit-animation: zoomIn 0.2s cubic-bezier(0.42, 0, 0.58, 1);
  animation: zoomIn 0.2s cubic-bezier(0.42, 0, 0.58, 1);
}
.is-hide {
  opacity: 0;
}

.chat_option {
  float: left;
  font-size: 15px;
  list-style: none;
  position: relative;
  height: 100%;
  width: 100%;
  text-align: relative;
  margin-right: 10px;
  letter-spacing: 0.5px;
  font-weight: 400;
}

.chat_option img {
  border-radius: 50%;
  width: 55px;
  float: left;
  margin: -30px 20px 10px 20px;
  border: 4px solid rgba(0, 0, 0, 0.21);
}

.change_img img {
  width: 35px;
  margin: 0px 20px 0px 20px;
}
.chat_option .agent {
  font-size: 12px;
  font-weight: 300;
}
.chat_option .online {
  opacity: 0.4;
  font-size: 11px;
  font-weight: 300;
}
.chat_color {
  display: block;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  margin: 10px;
  float: left;
}

.chat_body {
  background: #fff;
  width: 100%;

  display: inline-block;
  text-align: center;
  overflow-y: auto;
}
#chat_body {
  height: 450px;
}
.chat_login p,
.chat_body li,
p,
a {
  -webkit-animation: zoomIn 0.5s cubic-bezier(0.42, 0, 0.58, 1);
  animation: zoomIn 0.5s cubic-bezier(0.42, 0, 0.58, 1);
}
.chat_body p {
  padding: 20px;
  color: #888;
}
.chat_body a {
  width: 10%;
  text-align: center;
  border: none;
  box-shadow: none;
  line-height: 40px;
  font-size: 15px;
}

.chat_field {
  position: relative;
  margin: 5px 0 5px 0;
  width: 50%;
  font-family: 'Roboto';
  font-size: 12px;
  line-height: 30px;
  font-weight: 500;
  color: #4b4b4b;
  -webkit-font-smoothing: antialiased;
  font-smoothing: antialiased;
  border: none;
  outline: none;
  display: inline-block;
}

.chat_field.chat_message {
  height: 30px;
  resize: none;
  font-size: 13px;
  font-weight: 400;
}
.chat_category {
  text-align: left;
}

.chat_category {
  margin: 20px;
  background: rgba(0, 0, 0, 0.03);
  padding: 10px;
}

.chat_category ul li {
  width: 80%;
  height: 30px;
  background: #fff;
  padding: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  margin-bottom: 10px;
  border-radius: 3px;
  border: 1px solid #e0e0e0;
  font-size: 13px;
  cursor: pointer;
  line-height: 30px;
  color: #888;
  text-align: center;
}

.chat_category li:hover {
  background: #83c76d;
  color: #fff;
}
.chat_category li.active {
  background: #83c76d;
  color: #fff;
}

.tags {
  margin: 20px;
  bottom: 0px;
  display: block;
  width: 120%;
}
.tags li {
  padding: 5px 10px;
  border-radius: 40px;
  border: 1px solid rgb(3, 117, 208);
  margin: 5px;
  display: inline-block;
  color: rgb(3, 117, 208);
  cursor: pointer;
}
.fab_field {
  width: 100%;
  display: inline-block;
  text-align: center;
  background: #fff;
  border-top: 1px solid #eee;
  border-bottom-right-radius: 10px;
  border-bottom-left-radius: 10px;
}
.fab_field2 {
  bottom: 0px;
  position: absolute;
  border-bottom-right-radius: 0px;
  border-bottom-left-radius: 0px;
  z-index: 999;
}

.fab_field a {
  display: inline-block;
  text-align: center;
}

#fab_camera {
  float: left;
  background: rgba(0, 0, 0, 0);
}

#fab_send {
  float: right;
  background: rgba(0, 0, 0, 0);
}

.fab_field .fab {
  width: 35px;
  height: 35px;
  box-shadow: none;
  margin: 5px;
}

.fab_field .fab > i {
  font-size: 1.6em;
  line-height: 35px;
  color: #bbb;
}
.fab_field .fab > i:hover {
  color: #42a5f5;
}
.chat_conversion {
}

.chat_converse {
  position: relative;
  background: #fff;
  margin: 6px 0 0px 0;
  height: 300px;
  min-height: 0;
  font-size: 12px;
  line-height: 18px;
  overflow-y: auto;
  width: 100%;
  float: right;
  padding-bottom: 100px;
}
.chat_converse2 {
  height: 100%;
  max-height: 800px;
}
.chat_list {
  opacity: 0;
  visibility: hidden;
  height: 0;
}

.chat_list .chat_list_item {
  opacity: 0;
  visibility: hidden;
}

.chat .chat_converse .chat_msg_item {
  position: relative;
  margin: 8px 0 15px 0;
  padding: 8px 10px;
  max-width: 60%;
  display: block;
  word-wrap: break-word;
  border-radius: 3px;
  -webkit-animation: zoomIn 0.5s cubic-bezier(0.42, 0, 0.58, 1);
  animation: zoomIn 0.5s cubic-bezier(0.42, 0, 0.58, 1);
  clear: both;
  z-index: 999;
}
.status {
  margin: 45px -50px 0 0;
  float: right;
  font-size: 11px;
  opacity: 0.3;
}
.status2 {
  margin: -10px 20px 0 0;
  float: right;
  display: block;
  font-size: 11px;
  opacity: 0.3;
}
.chat .chat_converse .chat_msg_item .chat_avatar {
  position: absolute;
  top: 0;
}

.chat .chat_converse .chat_msg_item.chat_msg_item_admin .chat_avatar {
  left: -52px;
  background: rgba(0, 0, 0, 0.03);
}

.chat .chat_converse .chat_msg_item.chat_msg_item_user .chat_avatar {
  right: -52px;
  background: rgba(0, 0, 0, 0.6);
}

.chat .chat_converse .chat_msg_item .chat_avatar,
.chat_avatar img {
  width: 40px;
  height: 40px;
  text-align: center;
  border-radius: 50%;
}

.chat .chat_converse .chat_msg_item.chat_msg_item_admin {
  margin-left: 60px;
  float: left;
  background: rgba(0, 0, 0, 0.03);
  color: #666;
}

.chat .chat_converse .chat_msg_item.chat_msg_item_user {
  margin-right: 20px;
  float: right;
  background: #42a5f5;
  color: #eceff1;
}

.chat .chat_converse .chat_msg_item.chat_msg_item_admin:before {
  content: '';
  position: absolute;
  top: 15px;
  left: -12px;
  z-index: 998;
  border: 6px solid transparent;
  border-right-color: rgba(255, 255, 255, 0.4);
}

.chat_form .get-notified label {
  color: #077ad6;
  font-weight: 600;
  font-size: 11px;
}

input {
  position: relative;
  width: 90%;
  font-family: 'Roboto';
  font-size: 12px;
  line-height: 20px;
  font-weight: 500;
  color: #4b4b4b;
  -webkit-font-smoothing: antialiased;
  font-smoothing: antialiased;
  outline: none;
  background: #fff;
  display: inline-block;
  resize: none;
  padding: 5px;
  border-radius: 3px;
}
.chat_form .get-notified input {
  margin: 2px 0 0 0;
  border: 1px solid #83c76d;
}
.chat_form .get-notified i {
  background: #83c76d;
  width: 30px;
  height: 32px;
  font-size: 18px;
  color: #fff;
  line-height: 30px;
  font-weight: 600;
  text-align: center;
  margin: 2px 0 0 -30px;
  position: absolute;
  border-radius: 3px;
}
.chat_form .message_form {
  margin: 10px 0 0 0;
}
.chat_form .message_form input {
  margin: 5px 0 5px 0;
  border: 1px solid #e0e0e0;
}
.chat_form .message_form textarea {
  margin: 5px 0 5px 0;
  border: 1px solid #e0e0e0;
  position: relative;
  width: 90%;
  font-family: 'Roboto';
  font-size: 12px;
  line-height: 20px;
  font-weight: 500;
  color: #4b4b4b;
  -webkit-font-smoothing: antialiased;
  font-smoothing: antialiased;
  outline: none;
  background: #fff;
  display: inline-block;
  resize: none;
  padding: 5px;
  border-radius: 3px;
}
.chat_form .message_form button {
  margin: 5px 0 5px 0;
  border: 1px solid #e0e0e0;
  position: relative;
  width: 95%;
  font-family: 'Roboto';
  font-size: 12px;
  line-height: 20px;
  font-weight: 500;
  color: #fff;
  -webkit-font-smoothing: antialiased;
  font-smoothing: antialiased;
  outline: none;
  background: #fff;
  display: inline-block;
  resize: none;
  padding: 5px;
  border-radius: 3px;
  background: #83c76d;
  cursor: pointer;
}
strong.chat_time {
  padding: 0 1px 1px 0;
  font-weight: 500;
  font-size: 8px;
  display: block;
}

/*Chatbox scrollbar*/

::-webkit-scrollbar {
  width: 6px;
}

::-webkit-scrollbar-track {
  border-radius: 0;
}

::-webkit-scrollbar-thumb {
  margin: 2px;
  border-radius: 10px;
  background: rgba(0, 0, 0, 0.2);
}
/*Element state*/

.is-active {
  -webkit-transform: rotate(180deg);
  transform: rotate(180deg);
  -webkit-transition: all 1s ease-in-out;
  transition: all 1s ease-in-out;
}

.is-float {
  box-shadow: 0 0 6px rgba(0, 0, 0, 0.16), 0 6px 12px rgba(0, 0, 0, 0.32);
}

.is-loading {
  display: block;
  -webkit-animation: load 1s cubic-bezier(0, 0.99, 1, 0.6) infinite;
  animation: load 1s cubic-bezier(0, 0.99, 1, 0.6) infinite;
}
/*Animation*/

@-webkit-keyframes zoomIn {
  0% {
    -webkit-transform: scale(0);
    transform: scale(0);
    opacity: 0;
  }
  100% {
    -webkit-transform: scale(1);
    transform: scale(1);
    opacity: 1;
  }
}

@keyframes zoomIn {
  0% {
    -webkit-transform: scale(0);
    transform: scale(0);
    opacity: 0;
  }
  100% {
    -webkit-transform: scale(1);
    transform: scale(1);
    opacity: 1;
  }
}

@-webkit-keyframes load {
  0% {
    -webkit-transform: scale(0);
    transform: scale(0);
    opacity: 0;
  }
  50% {
    -webkit-transform: scale(1.5);
    transform: scale(1.5);
    opacity: 1;
  }
  100% {
    -webkit-transform: scale(1);
    transform: scale(1);
    opacity: 0;
  }
}

@keyframes load {
  0% {
    -webkit-transform: scale(0);
    transform: scale(0);
    opacity: 0;
  }
  50% {
    -webkit-transform: scale(1.5);
    transform: scale(1.5);
    opacity: 1;
  }
  100% {
    -webkit-transform: scale(1);
    transform: scale(1);
    opacity: 0;
  }
}
/* SMARTPHONES PORTRAIT */

@media only screen and (min-width: 300px) {
  .chat {
    width: 250px;
  }
}
/* SMARTPHONES LANDSCAPE */

@media only screen and (min-width: 480px) {
  .chat {
    width: 300px;
  }
  .chat_field {
    width: 65%;
  }
}
/* TABLETS PORTRAIT */

@media only screen and (min-width: 768px) {
  .chat {
    width: 300px;
  }
  .chat_field {
    width: 65%;
  }
}
/* TABLET LANDSCAPE / DESKTOP */

@media only screen and (min-width: 1024px) {
  .chat {
    width: 300px;
  }
  .chat_field {
    width: 65%;
  }
}
/*Color Options*/

.blue .fab {
  background: #42a5f5;
  color: #fff;
}

.blue .chat {
  background: #42a5f5;
  color: #999;
}

/* Ripple */

.ink {
  display: block;
  position: absolute;
  background: rgba(38, 50, 56, 0.4);
  border-radius: 100%;
  -moz-transform: scale(0);
  -ms-transform: scale(0);
  webkit-transform: scale(0);
  -webkit-transform: scale(0);
  transform: scale(0);
}
/*animation effect*/

.ink.animate {
  -webkit-animation: ripple 0.5s ease-in-out;
  animation: ripple 0.5s ease-in-out;
}

@-webkit-keyframes ripple {
  /*scale the element to 250% to safely cover the entire link and fade it out*/

  100% {
    opacity: 0;
    -moz-transform: scale(5);
    -ms-transform: scale(5);
    webkit-transform: scale(5);
    -webkit-transform: scale(5);
    transform: scale(5);
  }
}

@keyframes ripple {
  /*scale the element to 250% to safely cover the entire link and fade it out*/

  100% {
    opacity: 0;
    -moz-transform: scale(5);
    -ms-transform: scale(5);
    webkit-transform: scale(5);
    -webkit-transform: scale(5);
    transform: scale(5);
  }
}
::-webkit-input-placeholder {
  /* Chrome */
  color: #bbb;
}
:-ms-input-placeholder {
  /* IE 10+ */
  color: #bbb;
}
::-moz-placeholder {
  /* Firefox 19+ */
  color: #bbb;
}
:-moz-placeholder {
  /* Firefox 4 - 18 */
  color: #bbb;
}
</style>