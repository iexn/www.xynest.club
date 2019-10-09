require(['jquery'], function ($) {

    // 根据路由添加高亮导航项
    const pathname = location.pathname;
    $('.nav-route').each(function (index, item) {
        let route_list = $(this).attr('data-route').split(',');
        route_list.indexOf(pathname) > -1 && $(this).addClass('active');
    });

});