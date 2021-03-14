export function fail_list(data)
{
    data = jQuery.parseJSON(data);
    if(data.errors){
        errors_list(data.errors);
    }
}

export function errors_list(data)
{
    if((typeof data) != 'string'){
        var temp = '';
        for (var error in data)
        {
            temp = temp + '<li>' + data[error] + "</li>";
        }
    }else{
        temp = '<li>' + data + "</li>";
    }
    $(function() {
        $("#Errors").html(temp);
        $('#ErrorModal').modal('show')
    });
}

export function succes_list(data)
{
    $(function() {
        $("#Succes").html(data);
        $('#SuccesModal').modal('show')
    });
}
