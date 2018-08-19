/**
 * ajax提交表单
 * @param form_obj [表单对象]
 * @param url [提交地址]
 * @param method [提交方法,POST|GET]
 */
function ajaxSubmit(form_obj, url, method) {
    let index = layer.load();
    let formData = new FormData(form_obj);
    let res = ajax(formData, url, method);
    if (res) {
        let data = JSON.parse(res);
        let msg = data.msg ? data.msg : '操作失败';
        if (data.code == 1) {
            layer.msg(msg, {'icon': 1});
        } else {
            layer.msg(msg, {'icon': 2});
            res = false;
        }
        if (data.url) {
            let time = data.time ? (data.time * 1000) : 1500;
            setTimeout('location.href="' + data.url + '";', time);
        }
    }
    layer.close(index);
    return res;
}

function ajax(formData, url, method) {
    let xmlhttp = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    let res = false;
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

function closeOpen(time) {
    let index = parent.layer.getFrameIndex(window.name);
    setTimeout('parent.layer.close(' + index + ');', time);
}

/**
 * 设置cookie
 * @param name
 * @param value
 * @param second
 */
function setCookie(name, value, second, path) {
    if (!path) {
        path = '/';
    }
    let exp = new Date();
    exp.setTime(exp.getTime() + second * 1000);
    document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString() + ";path=" + path;
}