<?php
return [
    'title' => '休闲小红屋',
    'menu' => [
        '应用中心',
        [
            'name' => '应用管理',
            'icon' => 'dripicons-view-apps',
            '_child' => [
                [
                    'name' => 'nes在线游戏',
                    '_child' => [
                        [ 'name' => 'nes游戏库', 'url' => '/nes/library' ],
                        [ 'name' => '游戏列表', 'url' => '/nes/list' ],
                        [ 'name' => '游戏分组', 'url' => '/nes/group' ],
                    ]
                ]
            ]
        ],
        [
            'name' => '文案管理',
            'icon' => 'dripicons-blog',
            '_child' => [
                [
                    'name' => '专题列表',
                    'url'  => '/topic'
                ]
            ]
        ],
        [
            'name' => '背景音乐管理',
            'icon' => 'dripicons-music',
            'url' => '/bg_music'
        ]
    ]
];