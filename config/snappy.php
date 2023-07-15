<?php

return array(
    'pdf' => [
        'enabled' => true,
        'binary'  => env('WKHTML_PDF_BINARY', '/usr/local/bin/wkhtmltopdf'),
        'timeout' => false,
        'options' => [
            'enable-local-file-access' => true,
            'orientation'   => 'landscape',
            'encoding' => 'UTF-8'
        ],
        'env'     => [],
    ],
    'image' => [
        'enabled' => true,
     //   $snappy = new Pdf($myProjectDirectory . '/vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64'),
        'binary'  => env('WKHTML_IMG_BINARY', '/usr/local/bin/wkhtmltoimage'),
        'timeout' => false,
        'options' => [
            'enable-local-file-access' => true,
            'orientation'   => 'landscape',
            'encoding'      => 'UTF-8'
        ],
        'env' => [],
    ],
);
