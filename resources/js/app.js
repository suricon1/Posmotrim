require('./bootstrap');

require('./slick.min');
require('./jquery.meanmenu.min');
require('./jquery.scrollUp.min');
require('./plugins');
require('./main');

import cart from './modules/cart';
import compare from './modules/compare';
import gridList from './modules/gridList';

window.addEventListener('DOMContentLoaded', function() {
    cart();
    compare();
    gridList();
});




/*  Vue  */
// window.Vue = require('vue');
// import store from '../js/store/index';
//
// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
//
// const app = new Vue({
//     el: '#app',
//     store
// });

/*  End Vue  */
