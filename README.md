# FilePreviews.io

PHP client library for the [FilePreviews.io](http://filepreviews.io) service. Generate image previews and metadata from almost any kind of file.


## Installation

```
composer require filepreviews/filepreviews
```

### Example code

```php
$fp = new FilePreviews\FilePreviews([
  'api_key' => 'API_KEY_HERE',
  'api_secret' => 'API_KEY_HERE'
]);

$response = $fp->generate($url);
print_r($response);

$response = $fp->retrieve($response->id);
print_r($response);
```

#### Options
You can optionally send an options associative array.

```php
$fp = new FilePreviews\FilePreviews([
  'api_key' => 'API_KEY_HERE',
  'api_secret' => 'API_KEY_HERE'
]);

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

$response = $fp->generate($url, $options);
print_r($response);
```
