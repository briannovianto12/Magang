<?php

namespace Bromo\HostToHost\Traits;

use Carbon\Carbon;
use Illuminate\Http\Response;

trait Result
{
    /**
     * Handle response based status code.
     *
     * @param Response $request
     * @return Response
     */
    public function response(Response $request)
    {
        switch ($request->getStatusCode()) {
            case 200:
                $data = $this->success($request);
                break;
            default:
                $data = $this->error($request);
                break;
        }

        $response = new Response();
        $response->setStatusCode($data['code']);
        $response->setContent($data);

        return $response;
    }

    /**
     * Configure success data.
     *
     * @param Response $request
     * @return mixed
     */
    protected function success(Response $request)
    {
        $decode = json_decode($request->getContent(), true);
        $bodies = json_decode($decode['body'], true);

        $data['code'] = (string)($request->getStatusCode() ?? 200);
        $data['status'] = 'success';
        $data['data'] = $bodies['data'] ?? $bodies;
        $data['timestamp'] = Carbon::now()->format('Y-m-d H:i:s');

        return $data;
    }

    /**
     * Configure error data.
     *
     * @param Response $request
     * @return mixed
     */
    protected function error(Response $request)
    {
        $decode = json_decode($request->getContent(), true);
        $bodies = json_decode($decode['body'], true);

        $data['code'] = (string)($request->getStatusCode() ?? 500);
        $data['status'] = 'error';
        $data['data'] = $bodies ?? '';
        $data['timestamp'] = Carbon::now()->format('Y-m-d H:i:s');

        return $data;
    }
}