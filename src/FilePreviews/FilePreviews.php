<?php

namespace FilePreviews;

require '../vendor/autoload.php';

class FilePreviews {
    const VERSION = '1.0.0';
    const API_URL = 'https://api.filepreviews.io/v2/';

    public function __construct(array $config = [])
    {
        $config = array_merge([
            'api_url' => static::API_URL,
            'debug' => false,
        ], $config);

        $this->client = new FilePreviewsClient(
            $config['api_key'],
            $config['api_secret'],
            $config['api_url']
        );
    }

    public function generate($url, array $params = [])
    {
        $params = array_merge([
            'url' => $url,
            'metadata' => []
        ], $params);

        $metadata = array_unique($params['metadata']);

        if(empty($metadata))
        {
            unset($params['metadata']);
        }

        if(isset($params['size']))
        {
            $size = $params['size'];
            unset($params['size']);

            $geometry = '';
            $size = array_merge([
                'height' => null,
                'width' => null
            ], $size);

            if ($size['width'] !== null)
            {
                $geometry = "{$size['width']}";
            }

            if ($size['height'] !== null)
            {
                $geometry = "{$geometry}x{$size['height']}";
            }

            $params['sizes'] = [$geometry];
        }

        return $this->client->post('previews/', json_encode($params));
    }

    public function retrieve($preview_id)
    {
        return $this->client->get("previews/$preview_id/");
    }
}
