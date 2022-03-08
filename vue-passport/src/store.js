import Vuex from 'vuex'
import cart from '@/modules/cart' 
import alert from '@/modules/alert'
// import auth from '@/modules/auth'
// import dialog from '@/modules/dialog'
// import region from '@/modules/region'
import VuexPersist from 'vuex-persist'

const vuexPersist = new VuexPersist({ 
  key: 'my-app',
  storage: localStorage
})

export default new Vuex.Store({
  plugins: [vuexPersist.plugin],
  state: {
    prevUrl: '',
    payment: [] 
  },
  mutations: {
    setPrevUrl: (state, value) => {
      state.prevUrl = value
    },
    setPayment: (state, value) => {
      state.payment = value
    },
  },
  actions: {
    setPrevUrl: ({commit}, value) => {
      commit('setPrevUrl', value)
    },
    setPayment: ({commit}, value) => {
      commit('setPayment', value)
    },
  },
  getters: {
    prevUrl: state => state.prevUrl,
    payment: state => state.payment,
  },
  modules: {
    cart,
    alert,
    // auth,
    // dialog,
    // region
  }
})
