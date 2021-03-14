window.addEventListener('DOMContentLoaded', function() {

    const forms = document.querySelectorAll('form');
    formsAddSubmit(forms);

    function formsAddSubmit(forms){
        forms.forEach(item => {
            bindPostData(item);
        });
    }

    const postData = async (form) => {
        let res = await fetch(form.getAttribute('action'), {
            method: "POST",
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            body: new FormData(form)
        });

        return await res.json();
    };

    function bindPostData(form) {
        form.addEventListener('submit', (e) => {
            const action = form.getAttribute('data-action');

            if (action === "add-to-cart") {
                e.preventDefault();

                postData(form)
                .then(data => {
                    if(data.succes) {
                        let div = document.querySelector('.mini-cart') ;
                        div.innerHTML = data.succes;
                        div.classList.remove('d-none');

                        const miniCartForms = div.querySelectorAll('form');
                        formsAddSubmit(miniCartForms);

                        toastr.success('Товар положен в Вашу корзину.');
                    }else if(data.errors){
                        toastr.error(data.errors);
                    }else{
                        toastr.error('Неизвестная ошибка. Повторите попытку, пожалуйста!');
                    }
                }).catch((error) => {
                    console.log(error);
                }).finally(() => {

                });
            }
            if (action === "remove-from-cart") {
                e.preventDefault();
                console.log(action);
            }
            if (action === "update-cart") {
                e.preventDefault();
                console.log(action);
            }
        });
    }
});











// $(function() {
//
//     //$('form').on('click', '.product-btn', function (e) {
//     $(document).delegate("form .product-btn", "click", function (e) {
//         e.preventDefault();
//         var form = $(this).parents('form');
//         //var data = form.serialize();
//         // $(this).addClass("disabled").attr('disabled',true);
//
//         // добавить overflow: scroll;
//
//         $.ajax({
//             method: "POST",
//             data: form.serialize(),
//             url: form.attr('action'),
//             headers: {'X-CSRF-Token': $("input[name = '_token']").val()},
//             beforeSend: function(){
//                 $('.product-btn').attr('disabled',true);
//             }
//         })
//             .done(function(data) {
//                 if(data.succes){
//                     if($("div").is(".mini-cart")){
//                         $('.mini-cart').replaceWith(data.succes);
//                     }else{
//                         $('.mini-cart-search').prepend(data.succes);
//                     }
//
//                     $('.cart-dropdown').hide();
//                     $('.mini-cart').hover(
//                         function() {
//                             if( $(this).children('div').length > 0 && $(this).children().hasClass('cart-dropdown') ) {
//                                 $(this).children().stop().slideDown(400);
//                             }
//                         }, function() {
//                             $(this).children('.cart-dropdown').stop().slideUp(300);
//                         }
//                     );
//                     toastr.success('Товар положен в Вашу корзину.');
//                     $('.product-btn').attr('disabled', false);
//                 }
//                     // else if(data.error){
//                     //     console.log(data);
//                     //     toastr.error(data.error);
//                 // }
//                 else if(data.errors){
//                     errors_list(data.errors);
//                     // resetForm($('#login'));
//                     console.log(data);
//                 }
//                 else{
//                     errors_list('Неизвестная ошибка. Повторите попытку, пожалуйста!');                }
//             })
//             .fail(function(data) {
//                 console.log(data);
//             });
//         // .fail(function(xhr, ajaxOptions, thrownError) {
//         //     fail_list(xhr.responseText);
//         // });
//     });
//
//     function errors_list(data)
//     {
//         if((typeof data) != 'string'){
//             var temp = '';
//             for (var error in data)
//             {
//                 temp = temp + '<li>' + data[error] + "</li>";
//             }
//         }else{
//             temp = '<li>' + data + "</li>";
//         }
//         toastr.error(temp);
//         $('.product-btn').attr('disabled',false);
//
//         // $(function() {
//         //     $("#Errors").html(temp);
//         //     $('#ErrorModal').modal('show')
//         // });
//     }
// });
