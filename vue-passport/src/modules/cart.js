// define state
export default {
    namespaced: true,
    state: {
      carts : [],
    },
    // mutation is the only way to change state synchronously
    // the key and table field column must be same
    mutations: {
      insert: (state, payload) => { // payload is just a parameter, we use payload to fill the object 
        state.carts.push({
            id: payload.id,
            url_id: payload.url_id,
            url: payload.url,
            product_name: payload.product_name,
            cover: payload.cover,
            price: payload.price,
            product_key: payload.product_key,
            available_stock: payload.available_stock,
            weight: payload.weight,
            product_weight: payload.product_weight,
            metric_mass: payload.metric_mass,
            product_type: payload.product_type,
            quantity: 1
        })
      }, 
      update: (state, payload) => {
        let idx = state.carts.indexOf(payload);
        state.carts.splice(idx, 1, { 
            id: payload.id,
            url_id: payload.url_id,
            url: payload.url,
            product_name: payload.product_name,
            cover: payload.cover,
            price: payload.price,
            product_key: payload.product_key,
            available_stock: payload.available_stock,
            weight: payload.weight, 
            product_weight: payload.product_weight,
            metric_mass: payload.metric_mass,
            product_type: payload.product_type,
            quantity: payload.quantity,
        });
        if(payload.quantity <= 0){
            state.carts.splice(idx,1) 
        }
      },
      delete: (state, payload) => {
        let idx = state.carts.indexOf(payload);
        state.carts.splice(idx, 1)
      },
      set: (state, payload) => {
        state.carts = payload
      },
    },
    // actions is the only way to change state asynchronously
    actions: {
      // In order to access mutation, we need to add methods below 
      add: ({state, commit}, payload) => {
        let cartItem = state.carts.find(item => item.id === payload.id) // check if the inputted data is exist in the carts
        if(!cartItem){ // if data is not exist then run mutation insert
            commit('insert', payload) // insert refer to insert method inside mutation
        }
        else{
            cartItem.quantity++
            commit('update', cartItem)
        }
      },
      remove: ({state, commit}, payload) => {
        let cartItem = state.carts.find(item => item.id === payload.id)
        if(cartItem){
          cartItem.quantity--
          commit('update', cartItem)
        }
      }, 
      delete: ({state, commit}, payload) => {
        let cartItem = state.carts.find(item => item.id === payload.id)
        commit('delete', cartItem)
      }, 
      set: ({commit}, payload) => {
        commit('set', payload)
      },
    },
    // getters is used to access state. With getters, we can process it's data first before we access it. 
    // If we need to call state from another components we can use this.$store.getters['cart/carts']. namespaced must be declared with value true to avoid collision between each modules. 
    getters: {
      // show indicator in cart header
      carts  : state => state.carts,
      count  : (state) => {
        return state.carts.length 
      },
      totalPrice: (state) => {
        let total = 0
        state.carts.forEach(function(cart) {
            total += cart.price * cart.quantity
        })
        return total
      },
      totalQuantity: (state) => {
        let total = 0
        state.carts.forEach(function(cart) {
            total += cart.quantity
        })
        return total
      },
      totalWeight: (state) => {
        let total = 0
        state.carts.forEach(function(cart) {
            total += cart.weight
        })
        return total
      }
    }
  }