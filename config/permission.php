<?php

return [
    'roles' => [
        'super-admin' => 'Super Administrator',
        'dpd-admin' => 'Admin DPD',
        'dpc-admin' => 'Admin DPC',
        'news-writer' => 'Penulis Berita',
        'kader' => 'Kader',
    ],
    
    'permissions' => [
        'users' => [
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',
        ],
        
        'dpd' => [
            'view-dpd',
            'create-dpd',
            'edit-dpd',
            'delete-dpd',
            'view-dpd-structure',
            'create-dpd-structure',
            'edit-dpd-structure',
            'delete-dpd-structure',
        ],
        
        'dpc' => [
            'view-dpc',
            'create-dpc',
            'edit-dpc',
            'delete-dpc',
            'view-dpc-structure',
            'create-dpc-structure',
            'edit-dpc-structure',
            'delete-dpc-structure',
        ],
        
        'dprt' => [
            'view-dprt',
            'create-dprt',
            'edit-dprt',
            'delete-dprt',
            'view-dprt-structure',
            'create-dprt-structure',
            'edit-dprt-structure',
            'delete-dprt-structure',
        ],
        
        'kader' => [
            'view-kader',
            'create-kader',
            'edit-kader',
            'delete-kader',
            'verify-kader',
        ],
        
        'berita' => [
            'view-berita',
            'create-berita',
            'edit-berita',
            'delete-berita',
            'publish-berita',
            'view-category',
            'create-category',
            'edit-category',
            'delete-category',
        ],
        
        'gis' => [
            'view-gis',
            'edit-gis',
        ],
        
        'dashboard' => [
            'view-dashboard',
        ],
    ],
    
    'role_permissions' => [
        'super-admin' => '*',
        'dpd-admin' => [
            'view-dashboard',
            'view-dpd', 'edit-dpd',
            'view-dpd-structure', 'create-dpd-structure', 'edit-dpd-structure', 'delete-dpd-structure',
            'view-dpc', 'create-dpc', 'edit-dpc', 'delete-dpc',
            'view-dpc-structure', 'edit-dpc-structure',
            'view-dprt', 'create-dprt', 'edit-dprt', 'delete-dprt',
            'view-kader', 'create-kader', 'edit-kader', 'verify-kader',
            'view-berita', 'create-berita', 'edit-berita', 'publish-berita',
            'view-category',
            'view-gis',
        ],
        'dpc-admin' => [
            'view-dashboard',
            'view-dpc', 'edit-dpc',
            'view-dpc-structure', 'edit-dpc-structure',
            'view-dprt', 'create-dprt', 'edit-dprt',
            'view-kader', 'create-kader', 'edit-kader',
            'view-berita', 'create-berita', 'edit-berita',
        ],
        'news-writer' => [
            'view-dashboard',
            'view-berita', 'create-berita', 'edit-berita',
        ],
        'kader' => [
            'view-dashboard',
        ],
    ],
];