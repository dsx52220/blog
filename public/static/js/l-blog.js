document.body.onload = function () {
    init();
    $('#phone-nav-cat').click(function () {
        $('.layui-nav-tree').toggle(400);
    });
    $('#pc-nav-login').mouseover(function () {
        $('.login_icon').attr('src', '/static/images/login-white.svg');
    });
    $('#pc-nav-login').mouseout(function () {
        $('.login_icon').attr('src', '/static/images/login-gray.svg');
    });
    $('#pc-nav-login').click(function () {
        loginShow();
    });
    $('#pc-nav-register').mouseover(function () {
        $('.register_icon').attr('src', '/static/images/register-white.svg');
    });
    $('#pc-nav-register').mouseout(function () {
        $('.register_icon').attr('src', '/static/images/register-gray.svg');
    });
    $('#pc-nav-register').click(function () {
        registerShow();
    });
}

function init() {
    layui.use(['carousel', 'laypage', 'util'], function () {
        var carousel = layui.carousel;
        //建造实例
        carousel.render({
            elem: '#repeat_img',
            width: '100%',//设置容器宽度
            arrow: 'always',//始终显示箭头
        });

        var laypage = layui.laypage;
        laypage.render({
            elem: 'page',
            curr: $('#curr').val(),
            count: $('#count').val(), //数据总数，从服务端得到
            limit: 10,
            layout: ['prev', 'first', 'page', 'last', 'next'],
            jump: function (obj, first) {
                //首次不执行
                if (!first) {
                    getMainHtml(url + '?page=' + obj.curr + '&list_row=' + obj.limit);
                }
            }
        });

        var util = layui.util;
        util.fixbar({
            showHeight: 50,
            bgcolor: 'rgba(0, 0, 0, 0.4)',
        });
        let span_objs = document.getElementsByClassName('article-time');
        for (let i = 0, len = span_objs.length; i < len; i++) {
            span_objs[i].innerText = util.timeAgo(parseInt(span_objs[i].getAttribute('data')));
        }
    });
}

function addBookmark(url, title) {
    if (!url) {
        url = window.location
    }
    if (!title) {
        title = document.title
    }
    var browser = navigator.userAgent.toLowerCase();
    if (window.sidebar) { // Mozilla, Firefox, Netscape
        window.sidebar.addPanel(title, url, "");
    } else if (window.external) { // IE or chrome
        if (browser.indexOf('chrome') == -1) { // ie
            window.external.AddFavorite(url, title);
        } else { // chrome
            layer.msg('请使用按键 CTRL+D (MacBook使用 Command+D ) 收藏本站');
        }
    }
    else if (window.opera && window.print) { // Opera - automatically adds to sidebar if rel=sidebar in the tag
        return true;
    }
    else if (browser.indexOf('konqueror') != -1) { // Konqueror
        layer.msg('请使用按键 CTRL+B 收藏本站');
    }
    else if (browser.indexOf('webkit') != -1) { // safari
        layer.msg('请使用按键 CTRL+B (MacBook使用 Command+D ) 收藏本站');
    } else {
        layer.msg('请手动将本站加入书签');
    }
}

function loginShow() {
    layer.closeAll('page');
    layer.open({
        type: 1,
        title: '登录',
        content: $('#login_panel'),
        resize: false,
        area: ['300px', '300px'],
        end: function () {
            $('#login_panel').hide();
        }
    });
}

function registerShow() {
    layer.closeAll('page');
    layer.open({
        type: 1,
        title: '注册',
        content: $('#register_panel'),
        resize: false,
        area: ['315px', '350px'],
        end: function () {
            $('#register_panel').hide();
        }
    });
}