<?php

namespace FilePreviews;

class FilePreviews {
    const VERSION = '1.0.1';
    const API_URL = 'https://api.filepreviews.io/v2/';
    const API_KEY_ENV_NAME = 'FILEPREVIEWS_API_KEY';
    const API_SECRET_ENV_NAME = 'FILEPREVIEWS_API_SECRET';

    public function __construct(array $config = [])
    {
        $config = array_merge([
            'api_key' => getenv(static::API_KEY_ENV_NAME),
            'api_secret' => getenv(static::API_SECRET_ENV_NAME),
            'api_url' => static::API_URL,
            'version' => static::VERSION
        ], $config);

        if (!$config['api_key']) {
            throw new \Exception('Required "api_key" key not supplied.');
        }

        if (!$config['api_secret']) {
            throw new \Exception('Required "api_secret" key not supplied.');
        }

        $this->client = new FilePreviewsClient($config);
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
