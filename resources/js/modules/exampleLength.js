import * as responce from "./components/resources";
import * as info from "./components/informers";

function exampleLength () {
    const e = document.querySelector("select[name=example_length]");
    if(e){
        e.addEventListener("change", (e) => {
            // document.querySelector("select[name=example_length]").addEventListener("change", (e) => {
            const data = {
                example_length: e.target.value
            }
            responce.get(e.target.getAttribute('data-url'), data)
                .then(data => {
                    if (data.succes) {
                        window.location.reload(true);
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
    }

}
export default exampleLength;
