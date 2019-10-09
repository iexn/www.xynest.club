define(function (require, exports) {

    /**
     *  HTML NODE ELEMENT
     */


    NodeList.prototype.all = function () {
        return Array.prototype.slice.call(this, 0);
    }
    NodeList.prototype.one = function () {
        return this.all()[0];
    }

    NodeList.prototype.each = function (callback) {
        let nodelist = Array.prototype.slice.call(this, 0);

        for(let i in nodelist) {
            let node = nodelist[i];
            callback && callback.call(node);
        }
    }

    HTMLElement.prototype.on = HTMLElement.prototype.addEventListener
    NodeList.prototype.on = function (type, listener, options) {
        this.each(function () {
            this.addEventListener(type, listener, options);
        })
    }

    HTMLElement.prototype.attr = function (name, value) {
        if(value === undefined) {
            return this.getAttribute(name);
        }
        this.setAttribute(name, value);
        return this;
    }
    NodeList.prototype.attr = function (name, value) {
        if(value === undefined) {
            return this.all()[0].getAttribute(name) || '';
        }
        this.each(function () {
            this.setAttribute(name, value);
        });
        return this;
    }

    HTMLElement.prototype.html = function (value) {
        if(value === undefined) {
            return this.innerHTML;
        }
        this.innerHTML = value;
        return this;
    }
    NodeList.prototype.html = function (value) {
        if(value === undefined) {
            return this.all()[0].innerHTML || '';
        }
        this.each(function () {
            this.innerHTML = value;
        });
        return this;
    }

    /**
     * $$
     */

    window.$$ = function (selector) {
        return $$.fn.init(selector);
    };

    $$.fn = $$.prototype = {
        constructor: $$
    };

    var init = $$.fn.init = function (selector) {
        return document.querySelectorAll(selector);
    }
    init.prototype = $$.fn;

    $$.post = function (url, data) {
        data = data || {};
        if(Object.prototype.toString.call(data) == '[object Object]') {
            var fd = new FormData();
            for(var key in data) {
                fd.append(key, data);
            }
        } else if(Object.prototype.toString.call(data) == '[object FormData]') {
            fd = data;
        } else {
            fd = new FormData;
        }
        var request = fetch(url, {
            method: 'POST',
            body: fd,
            credentials: 'same-origin'
        }).then(res => res.json());

        var collect = {
            done: function (callback) {
                request.then(function (response) {
                    callback && callback(response);
                });
                return collect;
            },
            fail: function (callback) {
                request.catch(function (error) {
                    callback && callback(error);
                });
                return collect;
            }
        };

        return collect;
    };


    /**
     * 按钮变为加载中
     */
    function loading(selector)
    {
        var node = $$(selector).one();
        let html = node.html();
        node.attr('data-origin-text', html);
        node.html('<span class="spinner-grow spinner-grow-sm mr-1" role="status" aria-hidden="true"></span>' + (node.attr('data-loading-text') || node.html()));
        node.disabled = true;

        return {
            hide: function (callback) {
                node.html(html);
                node.disabled = false;
                callback && callback.call(node);
            }
        };
    }

    exports.loading = loading;
});


function define(callback) {

    var exports = {};

    callback && callback({}, exports);

    window.Admin = exports;
}