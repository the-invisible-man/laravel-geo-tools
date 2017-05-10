<?php

namespace Combustion\Geo\Services\Google;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\ClientException;
use Combustion\StandardLib\Traits\ValidatesConfig;
use Combustion\StandardLib\Exceptions\ConfigNotFoundException;
use Combustion\Geo\Services\Google\Exceptions\GoogleMapsRequestNotOkatException;

/**
 * Class GoogleMapsRequest
 *
 * Parent of any google maps API implementation.
 * Google treats directions and geocoding as two separate
 * APIs.
 *
 * @package     Combustion\Geo\Services\Google
 * @author      Carlos Granados <cgranados@combustiongroup.com>
 *
 * */
abstract class GoogleMapsAPI {

    use ValidatesConfig;

    const   POST    = 'POST',
            GET     = 'GET',
            DELETE  = 'DELETE',
            PUT     = 'PUT',
            JSON    = 'application/json',
            XML     = 'application/xml';

    // Response statuses
    const   OK                  = "OK",
            INVALID_REQUEST     = "INVALID_REQUEST",
            OVER_QUERY_LIMIT    = "OVER_QUERY_LIMIT",
            REQUEST_DENIED      = "REQUEST_DENIED",
            UNKNOWN_ERROR       = "UNKNOWN_ERROR",
            ZERO_RESULTS        = "ZERO_RESULTS";

    /**
     * @var array
     */
    private $config;

    /**
     * Child class can add its required configuration
     * in this array.
     * @var array
     */
    protected $requiredConfig = [];

    /**
     * This is configuration that is always assumed
     * to exist in the child class.
     * @var array
     */
    private $baseRequired = ['url', 'apiKey', 'responseType'];

    /**
     * @var Client
     */
    private $httpClient;

    /**
     * GoogleMapsRequest constructor.
     * @param array $config
     * @param Client $httpClient
     */
    public function __construct(array $config, Client $httpClient)
    {
        array_merge($this->requiredConfig, $this->baseRequired);

        $this->config       = $this->validateConfig($config);
        $this->httpClient   = $httpClient;
    }

    /**
     * @return array
     */
    protected function getRequiredConfig() : array
    {
        return $this->requiredConfig;
    }


    /**
     * @param array  $data
     * @param string $endpoint
     * @param string $method
     *
     * @return array
     * @throws \Exception
     */
    public function do(array $data, string $endpoint = '', string $method = self::GET) : array
    {
        $url            = $this->getConfig('url') . $endpoint;
        $data['key']    = $this->getConfig('apiKey');
        $options        = [];

        if ($method == self::GET) {
            $options    = ['query' => $data];
            $data       = [];
        }

        $options = array_merge($options, $data);

        try {
            $request     = $this->httpClient->request($method, $url, $options);
        } catch (ClientException $e) {
            throw $e;
        }

        return $this->handleResponse($request);
    }

    /**
     * @param Response $requestInterface
     * @return array
     * @throws ConfigNotFoundException
     */
    private function handleResponse(Response $requestInterface) : array
    {
        switch($this->getConfig('responseType')) {
            case self::JSON:
                return $this->handleJson($requestInterface);
            case self::XML:
                return $this->handleXml($requestInterface);
            default:
                return $requestInterface;
        }
    }

    /**
     * @param string $status
     * @throws GoogleMapsRequestNotOkatException
     */
    public function handleResponseStatus(string $status) {
        switch($status) {
            case self::OK:
                return;
            case self::INVALID_REQUEST:
            case self::OVER_QUERY_LIMIT:
            case self::REQUEST_DENIED:
            case self::UNKNOWN_ERROR:
            case self::ZERO_RESULTS:
                break;
        }
    }


    /**
     * @param \GuzzleHttp\Psr7\Response $requestInterface
     *
     * @return array
     * @throws \Exception
     */
    private function handleJson(Response $requestInterface) : array
    {
        $response = json_decode($requestInterface->getBody(), true);
        if($this->requestWasSuccesfull($requestInterface))
        {
            $this->handleResponseStatus($response['status']);
            return $response;
        }
        $errors = isset($response['error_message']) ? $response['error_message'] : $response['status'];
        throw new \Exception('Google response : '.$errors,$requestInterface->getStatusCode());
    }

    /**
     * @param \GuzzleHttp\Psr7\Response $requestInterface
     *
     * @return bool
     */
    private function requestWasSuccesfull(Response $requestInterface) : bool
    {
        $response = json_decode($requestInterface->getBody(), true);
        if($response['status']!=self::OK)
        {
            return false;
        }
        return true;
    }

    /**
     * @param Response $requestInterface
     * @return array
     */
    private function handleXml(Response $requestInterface) : array
    {
        // TODO: implement this bullshit
        return [];
    }

    /**
     * @param string $key
     * @return mixed
     * @throws ConfigNotFoundException
     */
    protected function getConfig(string $key)
    {
        if (!array_key_exists($key, $this->config)) {
            throw new ConfigNotFoundException("Tried to access invalid configuration \"{$key}\"");
        }

        return $this->config[$key];
    }

    abstract protected function getOutput() : string;
}
