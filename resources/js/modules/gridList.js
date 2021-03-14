import * as info from './components/informers';
import * as responce from './components/resources';
import cart from '../modules/cart';
import compare from '../modules/compare';

function gridList() {
    const gridLists = document.querySelectorAll('.grid-list');
    gridLists.forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            if (item.classList.contains('active')){
                return;
            }

            const data = {
                grid_list: item.getAttribute("data-grid-list"),
                category: item.getAttribute("data-category"),
                model: item.getAttribute('data-model'),
                page: item.getAttribute('data-page')
            }

            responce.get(item.getAttribute('data-url'), data)
                .then(data => {
                    if (data.succes) {
                        document.querySelector('#grid').innerHTML = data.succes;
                        document.querySelector('.grid').classList.toggle('active');
                        document.querySelector('.list').classList.toggle('active');
                        cart();
                        compare();
                    } else if (data.errors) {
                        info.errors_list(data.errors);
                    } else {
                        info.errors_list('Неизвестная ошибка. Повторите попытку, пожалуйста!');
                    }
                })
                .catch((xhr) => {
                    console.log(xhr);
                    info.fail_list(xhr.responseText);
                });
        });
    });
}

export default gridList;
