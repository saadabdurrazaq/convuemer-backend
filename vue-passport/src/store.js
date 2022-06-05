import Vuex from 'vuex'
import cart from '@/modules/cart' 
// import auth from '@/modules/auth'
// import dialog from '@/modules/dialog'
// import region from '@/modules/region'
import VuexPersist from 'vuex-persist'

const vuexPersist = new VuexPersist({ 
  key: 'product-cart',
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
    // auth,
    // dialog,
    // region
  }
})
