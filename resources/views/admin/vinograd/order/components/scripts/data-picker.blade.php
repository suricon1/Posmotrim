$(function () {
//https://www.daterangepicker.com/
jQuery("input[data-build='build']").each(function(index, item) {
$(item).daterangepicker({
minDate: new Date(),
autoUpdateInput: false,
singleDatePicker: true,
locale: {
format: 'DD.MM YYYY',
applyLabel: 'Принять',
cancelLabel: 'Отмена',
invalidDateLabel: 'Выберите дату',
daysOfWeek: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
firstDay: 1
}
});

$(item).on('cancel.daterangepicker', function(ev, picker) {
$(item).val('');
ajaxData ('', item);
});

$(item).on('apply.daterangepicker', function(ev, picker) {
if(picker.startDate.format('DD.MM YYYY') == item.value){return;}
$(this).val(picker.startDate.format('DD.MM YYYY'));
ajaxData (picker.startDate.format('DD.MM YYYY'), item)
});
});

function ajaxData (newDate, item){
let data = {
order_id: $(item).attr('data-order_id'),
date_build: newDate
}
getData(data, build_url)
.then(data => {
if(data.success) {
toastr.success('ok');
if(newDate) {
$(item).prev().children('.input-group-text').addClass('bg-warning');
} else {
$(item).prev().children('.input-group-text').removeClass('bg-warning');
}
}else if(data.errors){
errors_list(data.errors);
}else{
console.log(data);
errors_list('Неизвестная ошибка. Повторите попытку, пожалуйста!');
}
}).catch((xhr) => {
console.log(xhr);
});
}
});
