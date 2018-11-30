<?php

namespace HoaVQ\GmoPG;

use BadMethodCallException;
use Illuminate\Support\Traits\Macroable;

class GmoFunctions
{
    use Macroable {
        Macroable::__call as macroCall;
    }

    protected $attributes = [];

    protected $url = '';
    protected $host = '';

    protected $client = '';

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();

        $host = config('gmo.host');
        if (!$host) {
            throw new BadMethodCallException('You do not have "host" config in the gmo.php file.');
        }

        $this->attributes = [
            'Shop_ID' => config('gmo.shop_id'),
            'Shop_Pass' => config('gmo.shop_password'),
        ];
    }

    public function callApi($method, array $params)
    {
        try {
            $url = $this->buildUrl($method);
            $params = array_merge($this->attributes, $params);

            $response = $this->client->request('POST', $url, [
                'form_params' => $params
            ]);

            $body = mb_convert_encoding($response->getBody(), 'UTF-8', 'Windows-31J');

            parse_str($body, $bodyResponse);

            unset($body);

            if (isset($bodyResponse['ErrCode'])) {
                $bodyResponse['message'] = $this->getErrorMessagesFromCode(explode('|', $bodyResponse['ErrInfo']));
            }

            return $bodyResponse;

        } catch (\Exception $exception) {
            throw $exception;
        }

    }

    protected function buildUrl($method)
    {
        $path = config('gmo.urls.' . $method);
        if (!$path) {
            throw new BadMethodCallException("API {$method} does not exist.");
        }
        return config('gmo.host') . $path;
    }

    protected function getErrorMessagesFromCode($codes)
    {
        $arr = [];
        foreach ($codes as $code) {
            $arr[$code] = __('gmo.' . $code);
        }
        return $arr;

    }


    /**
     * Dynamically handle calls to the class.
     *
     * @param  string $method
     * @param  array $parameters
     *
     * @return \Illuminate\Contracts\View\View|mixed
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {

        if (static::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }

        return $this->callApi(ucfirst($method), $parameters[0]);

        throw new BadMethodCallException("Method {$method} does not exist.");
    }
}
