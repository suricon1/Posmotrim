import * as responce from './components/resources'

function compare() {

    const compares = document.querySelectorAll('.compare');
    handleCompare(compares);

    function handleCompare(compares){
        compares.forEach(item => {
            bindPostData(item);
        });
    }

    function bindPostData(item) {
        item.addEventListener('click', (e) => {
            e.preventDefault();

            let formData = new FormData();
            formData.append('product_id', item.getAttribute('data-product-id'));
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

            const compareAction = item.getAttribute('data-action');
            const url = item.getAttribute('data-url');

            if (compareAction === "add") {
                responce.post(url, formData)
                    .then(data => {
                        if(data.succes) {
                            let div = document.querySelector('#compare .modal-content') ;
                            div.innerHTML = data.succes;

                            $('#compare').modal('show')

                            const addCompares = document.querySelectorAll('.compare-table .compare');
                            handleCompare(addCompares);

                        }else if(data.errors){
                            toastr.error(data.errors);
                        }else{
                            toastr.error('Неизвестная ошибка. Повторите попытку, пожалуйста!');
                        }
                    }).catch((error) => {
                    toastr.error(error);
                });
            } else if (compareAction === "remove") {
                responce.post(url, formData)
                    .then(data => {
                        if(data.succes) {
                            let div = document.querySelector('.compare-table') ;
                            div.innerHTML = data.succes;

                            const removeCompares = document.querySelectorAll('.compare-table .compare');
                            handleCompare(removeCompares);

                        }else if(data.errors){
                            toastr.error(data.errors);
                        }else{
                            toastr.error('Неизвестная ошибка. Повторите попытку, пожалуйста!');
                        }
                    }).catch((error) => {
                    toastr.error(error);
                });
            }
        });
    }
}

export default compare;
