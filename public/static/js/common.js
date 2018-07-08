/**
 * ajax提交表单
 * @param form_obj [表单对象]
 * @param url [提交地址]
 * @param method [提交方法,POST|GET]
 */
function ajaxSubmit(form_obj, url, method) {
    var index = layer.load();
    var formData = new FormData(form_obj);
    var res = ajax(formData, url, method);
    if (res) {
        var data = JSON.parse(res);
        var msg = data.msg ? data.msg : '操作失败';
        if (data.code == 1) {
            layer.msg(msg, {'icon': 1});
        } else {
            layer.msg(msg, {'icon': 2});
        }
        if (data.url) {
            var time = data.time ? (data.time * 1000) : 1500;
            setTimeout('location.href="' + data.url + '";', time);
        }
    }
    layer.close(index);
}

function ajax(formData, url, method) {
    var xmlhttp = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    var res = false;
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) {
            res = xmlhttp.responseText;
        }
    };
    xmlhttp.open(method, url, false);
    xmlhttp.send(formData);
    if (!res) {
        layer.msg('请求失败，请重试！', {icon: 2});
    }
    console.log(res);
    return res;
}