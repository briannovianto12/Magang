<?php

namespace Modules\Bromo\HostToHost\Services;

use Illuminate\Http\Response;
use Requests;
use Requests_Response;

class RequestService
{
    private $url;
    private $headers;
    private $bodies;
    private $response;

    public function __construct()
    {
        $this->response = new Response();
    }

    /**
     * Set the url request
     *
     * @param string $url
     * @return RequestService
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Set the header on request
     *
     * @param array $headers
     * @return RequestService
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * Set the body on request
     *
     * @param array $bodies
     * @return RequestService
     */
    public function setBodies(array $bodies)
    {
        $this->bodies = json_encode($bodies);
        return $this;
    }

    /**
     * Request for 'GET' type
     *
     * @return Response
     */
    public function get(): Response
    {
        $request = Requests::get($this->url, $this->headers);

        return $this->handler($request);
    }

    /**
     * Request for 'POST' type
     *
     * @return Response
     */
    public function post(): Response
    {
        $request = Requests::post($this->url, $this->headers, $this->bodies);

        return $this->handler($request);
    }

    /**
     * Handler for response status
     *
     * @param Requests_Response $request
     * @return Response
     */
    protected function handler(Requests_Response $request): Response
    {
        $this->response->setStatusCode($request->status_code);
        $this->response->setContent([
            'header' => $request->headers->getAll(),
            'body' => $request->body
        ]);

        return $this->response;
    }
}