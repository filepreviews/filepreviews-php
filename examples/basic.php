<?php

require '../vendor/autoload.php';

ini_set('display_errors', 'On');
error_reporting(E_ALL);

$filepreviews = new FilePreviews\FilePreviews();

$url = 'http://www.getblimp.com/images/screenshot1.png';

$options = [
  'sizes' => [
    'width' => 250,
    'height' => 250
  ],
  'format' => 'jpg',
  'pages' => '1',
  'metadata' => ['exif', 'ocr', 'psd'],
  'data' => ['foo' => 'bar']
];

$response = $filepreviews->generate($url, $options);
print_r($response->id);

$response = $filepreviews->retrieve($response->id);
print_r($response);
