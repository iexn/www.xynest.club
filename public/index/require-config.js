const cdn = "https://cdn.xynest.club/";
require.config({
    "urlArgs": "v=20191001",
    "baseUrl": "/",
    "paths": {
        "jquery": cdn + "library/jquery/3.4.1/jquery.min",
        "bootstrap": cdn + "library/bootstrap/4.3.1/bootstrap.min",
        "popper": cdn + "library/popper.min",
        "wangEditor": cdn + "library/wangEditor/3.1.1/wangEditor.min",
        "app": "index/app"
    },
    "map": {
        "*": {
            "css": cdn + "library/require/css.min.js"
        }
    },
    "shim": {
        "bootstrap": {
            "deps": ["jquery"]
        },
        "app": {
            "deps": ["jquery"]
        }
    }
});

require(['bootstrap','app']);

require.init && require.init(require);