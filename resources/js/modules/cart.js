import * as responce from './components/resources'

function cart() {

    const forms = document.querySelectorAll('form');
    formsAddSubmit(forms);

    function formsAddSubmit(forms){
        forms.forEach(item => {
            bindPostData(item);
        });
    }

    function bindPostData(form) {
        form.addEventListener('submit', (e) => {
            const action = form.getAttribute('data-action'), // data-action
                  url = form.getAttribute('action'),
                  formData = new FormData(form);

            if (action === "add-to-cart") {
                e.preventDefault();

                responce.post(url, formData)
                    .then(data => {
                        if(data.succes) {
                            miniCart(data.succes)
                            toastr.success('Товар положен в корзину.');
                        }else if(data.errors){
                            toastr.error(data.errors);
                        }else{
                            toastr.error('Что-то пошло не так. Перегрузите страницу и попробуйте снова.');
                        }
                    }).catch((error) => {
                        toastr.error(error);
                    });
            }
            if (action === "remove-from-cart") {
                e.preventDefault();

                responce.post(url, formData)
                    .then(data => {
                        if(data.succes) {
                            miniCart(data.succes.mini_cart)
                            cart(data.succes.cart)
                            toastr.success('Корзина обновлена.');
                        }else if(data.errors){
                            toastr.error(data.errors);
                        }else{
                            toastr.error('Что-то пошло не так. Перегрузите страницу и попробуйте снова.');
                        }
                    })
                    .catch((error) => {
                        toastr.error(error);
                    });
            }
            if (action === "update-cart") {
                e.preventDefault();
                responce.post(url, formData)
                    .then(data => {
                        if(data.succes) {
                            miniCart(data.succes.mini_cart)
                            cart(data.succes.cart)
                            toastr.success('Корзина обновлена.');
                        }else if(data.errors){
                            toastr.error(data.errors);
                        }else{
                            toastr.error('Что-то пошло не так. Перегрузите страницу и попробуйте снова.');
                        }
                    }).catch((error) => {
                        toastr.error(error);
                    });
            }
        });
    }

    function miniCart(data) {
        let mini_cart = document.querySelector('.mini-cart');
        mini_cart.innerHTML = data;
        mini_cart.classList.remove('d-none');
        formsAddSubmit(mini_cart.querySelectorAll('form'));
    }

    function cart(data) {
        let cart = document.querySelector('.cart');
        if(cart) {
            cart.innerHTML = data;
            formsAddSubmit(cart.querySelectorAll('form'));
        }
    }
}

export default cart;
