import cart from './modules/cart';
import compare from './modules/compare';
import gridList from './modules/gridList';
import exampleLength from "./modules/exampleLength";

window.addEventListener('DOMContentLoaded', function() {
    compare();
    cart();
    gridList();
    exampleLength();
});
