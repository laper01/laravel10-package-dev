<?php
// jika ingin merubah ulang sebaiknya migrate ulang atau hapus data pada table model DB::table('models')->truncate();
return [
    [
        "name" => 'test modul', // harus unique
        'allow_permission' => 16, // integer 1,2 ,4 ,8, 16 tegantung julah permission,
        'author' => 'yusuf',
        'edited' => 'yusuf',
        'folder' => 'test' // folder tempat controller tidak wajib tapi sunnah
    ],
    [
        "name" => 'admin', // harus unique
        'allow_permission' => 8, // integer 1,2 ,4 ,8, 16 tegantung julah permission,
        'author' => 'yusuf',
        'edited' => 'yusuf',
        'folder' => 'test' // folder tempat controller tidak wajib tapi sunnah
    ]
];
