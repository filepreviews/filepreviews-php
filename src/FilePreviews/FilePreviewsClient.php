<?php

namespace FilePreviews;

class FilePreviewsClient {
    protected $session;

    public function __construct($api_key, $api_secret, $base_url)
    {
        $this->session = new \Requests_Session($base_url);
        $this->session->headers['Accept'] = 'application/json';
        $this->session->headers['Content-Type'] = 'application/json';
        $this->session->auth = [$api_key, $api_secret];
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
