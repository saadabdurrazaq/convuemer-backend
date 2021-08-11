import { frm, HasErr, AlertErr } from 'vform'

// insert all your axios logic here

export const Form = frm
export const HasError = HasErr
export const AlertError = AlertErr

export default {
    install(Vue) {
        Vue.prototype.$Form = frm
        Vue.prototype.$HasError = HasErr
        Vue.prototype.$AlertError = AlertErr
    }
}