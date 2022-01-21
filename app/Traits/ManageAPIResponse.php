<?php

namespace App\Traits;

/**
 * Trait ManageAPIResponse
 * @package App\Traits
 * Responsible for formatting API response to make the response uniform for all APIs
 */
trait ManageAPIResponse
{
    protected $statusCode = 200;
    protected $headers = [];
    protected $payload = [
        'status' => 'success',
        'message' => '',
        'data' => []
    ];

    public function getCode($key)
    {
        return config('api')['response_codes'][$key];
    }

    public function withStatusCode($code)
    {
        $this->statusCode = $code;

        return $this;
    }

    /**
     * append extra header or headers to the current response headers
     */
    public function withHeader($headers)
    {
        $this->headers += $headers;

        return $this;
    }

    private function setStatus($status)
    {
        $this->payload['status'] = $status;

        return $this;
    }

    public function withSuccess()
    {
        return $this->setStatus('success');
    }

    public function withFail()
    {
        return $this->setStatus('fail');
    }

    public function withError()
    {
        return $this->setStatus('error');
    }

    public function withMessage($message)
    {
        $this->payload['message'] = $message;

        return $this;
    }

    public function withData($data)
    {
        $this->payload['data'] += $data;

        return $this;
    }

    /**
     * generate response
     */
    public function respond()
    {
        if (empty($this->payload['message']))
            unset($this->payload['message']);

        if (empty($this->payload['data']))
            unset($this->payload['data']);

        return response()->json($this->payload, $this->statusCode, $this->headers);
    }
}
