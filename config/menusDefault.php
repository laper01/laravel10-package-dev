<?php

return [
    'data' => [
        [
            'name' => 'RBAC',
            'url' => null,
            'allow_permissions' => null,
            'original_name' => null,
            'icon_class' => null,
            'sub_menu' => [
                [
                    'name' => 'Module',
                    'url' => 'module',
                    'allow_permissions' => 15,
                    'original_name' => 'Module',
                    'icon_class' => 'fa-solid fa-cubes',
                    'sub_menu' => []
                ],
                [
                    'name' => 'Group',
                    'url' => 'group',
                    'allow_permissions' => 15,
                    'original_name' => 'Group',
                    'icon_class' => 'fa-solid fa-layer-group',
                    'sub_menu' => []
                ],
                [
                    'name' => 'Menu',
                    'url' => 'menu',
                    'allow_permissions' => 15,
                    'original_name' => 'Menu',
                    'icon_class' => 'fa-solid fa-bars',
                    'sub_menu' => []
                ]
            ]
        ],
        [
            'name' => 'Dashboard',
            'url' => 'dashboard',
            'allow_permissions' => 1,
            'original_name' => 'Dashboard',
            'icon_class' => 'fa-solid fa-gauge-high',
            'sub_menu' => []
        ],
        [
            'name' => 'Penugasan',
            'url' => null,
            'original_name' => null,
            'icon_class' => null,
            'allow_permissions' => null,
            'sub_menu' => [
                [
                    'name' => 'Supervisor',
                    'url' => 'supervisor',
                    'allow_permissions' => 15,
                    'original_name' => 'Supervisor',
                    'icon_class' => 'fa-solid fa-user-tie',
                    'sub_menu' => []
                ],
                [
                    'name' => 'Enumerator',
                    'url' => 'enumerator',
                    'allow_permissions' => 15,
                    'original_name' => 'Enumerator',
                    'icon_class' => 'fa-solid fa-users-rectangle',
                    'sub_menu' => []
                ]
            ]
        ],
        [
            'name' => 'Master Data',
            'url' => null,
            'allow_permissions' => null,
            'original_name' => null,
            'icon_class' => null,
            'sub_menu' => [
                [
                    'name' => 'Periode',
                    'url' => 'periode',
                    'allow_permissions' => 15,
                    'original_name' => 'Periode',
                    'icon_class' => 'fa-regular fa-calendar',
                    'sub_menu' => []
                ],
                [
                    'name' => 'Petugas',
                    'url' => 'petugas',
                    'allow_permissions' => 15,
                    'original_name' => 'Petugas',
                    'icon_class' => 'fa-solid fa-users',
                    'sub_menu' => []
                ],
                [
                    'name' => 'Indikator',
                    'url' => null,
                    'allow_permissions' => null,
                    'original_name' => 'Indikator',
                    'icon_class' => 'fa-solid fa-list-check',
                    'sub_menu' => [
                        [
                            'name' => 'Kategori',
                            'url' => 'indikator/kategori',
                            'allow_permissions' => 15,
                            'original_name' => 'Menu',
                            'icon_class' => 'fa-solid fa-bars',
                            'sub_menu' => []
                        ],
                        [
                            'name' => 'Data Indikator',
                            'url' => 'indikator',
                            'allow_permissions' => 15,
                            'original_name' => 'Data Indikator',
                            'icon_class' => 'fa-solid fa-bars',
                            'sub_menu' => []
                        ]
                    ]
                ]

            ]
        ]

    ]
];
