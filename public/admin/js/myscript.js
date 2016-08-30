$("div.alert").delay(3000).slideUp();

function xacnhanxoa(msg)
{
    if(window.confirm(msg))
    {
        return true;
    }
    return false;
}

$(document).ready(function() {
    $("#addImages").click(function() {
        $("#inserts").append('<div class="form-group"><input type="file" name="fProductDetail[]"></div>');
    });

    $("a#del_img_demo").click(function() {
        var url = "http://192.168.100.86:8081/laravel-practice/admin/product/delImg/";
        var _token = $("form[name='frmEditProduct']").find("input[name='_token']").val();
        var idHinh = $(this).parent().find("img").attr("idHinh");
        var img = $(this).parent().find("img").attr("src");
        var rid = $(this).parent().find("img").attr("id");
        $.ajax({
            url: url + idHinh,
            type: 'GET',
            cache: false,
            data: {"_token": _token, "idHinh": idHinh, "urlHinh": img},
            success: function(data) {
                if(data == "Ok")
                {
                    $("#" + rid).remove();
                }
                else
                {
                    alert('error');
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
});