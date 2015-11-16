<?php

namespace FilePreviews;

class FilePreviewsClient {
    protected $session;

    public function __construct(array $config = [])
    {
        $this->session = new \Requests_Session($config['api_url']);
        $this->session->auth = [
            $config['api_key'], $config['api_secret']
        ];

        $client_ua = [
            'lang' => 'php',
            'publisher' => 'filepreviews',
            'bindings_version' => $config['version'],
            'lang_version' => phpversion(),
            'platform' => PHP_OS,
            'uname' => php_uname(),
        ];

        $this->session->headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'X-FilePreviews-Client-User-Agent' => json_encode($client_ua),
            'User-Agent' => 'FilePreviews/v2 PhpBindings/' . $config['version']
        ];
    }

    public function get($path)
    {
        $request = $this->session->get($path);

        $request->throw_for_status();

        return json_decode($request->body);
    }

    public function post($path, $data)
    {
        $request = $this->session->post($path, [], $data, []);

        $request->throw_for_status();

        return json_decode($request->body);
    }
}
