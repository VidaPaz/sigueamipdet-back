require('./bootstrap');

import Vue from 'vue';
import router from './routes'
import VueNativeNotification from 'vue-native-notification'
import "vue-snotify/styles/material.css";
import Snotify from 'vue-snotify';
import VueClipboard from 'vue-clipboard2'
Vue.use(VueClipboard)
Vue.use(Snotify);
Vue.component('header-page', require('./components/bitacora/Header'));
Vue.component('left-menu', require('./components/bitacora/LeftMenu'));
Vue.use(VueNativeNotification, {
    requestOnNotify: true
});

const app = new Vue({
    el: '#app',
    router,
    methods: {
        finTurno (){
            axios.post('/api/bitacora/finalizar-turno',{})
                .then(res => {

                    mApp.unblock("body");

                })
                .catch(err =>{
                    mApp.unblock("body")
                });
        }

    }
});



