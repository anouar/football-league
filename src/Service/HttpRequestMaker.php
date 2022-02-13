<?php 
namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HttpRequestMaker
{

    private $headers = [];
    private $apiUrl;
    private $client;
    private $loggerInterface;
    public function __construct(ParameterBagInterface $params, HttpClientInterface $client, LoggerInterface $loggerInterface)
    {
      $this->headers['x-rapidapi-host']  = $params->get('x-rapidapi-host');
      $this->headers['x-rapidapi-key']   = $params->get('x-rapidapi-key');
      $this->apiUrl  = $params->get('x-rapidapi-url'); 
      $this->client = $client;
    }

    /**
     * Make general http request
     * @param $url
     * @param $data
     * @param string $method
     * @param array $headers
     * @return bool|mixed|string
     */

    public function make($url, $data,  $method = 'GET', $headers = [])
    {
      $content = [];
      $content['headers'] = $headers;
      if (null !== $data) {
        $content['query'] = $data;
      }

      try {
        $request = $this->client->request($method, $this->apiUrl . $url, $content);
        $response = json_decode($request->getContent());
      } catch (BadRequestException $e) {
        $this->loggerInterface->log($e->getMessage() . ' in line ' . $e->getLine() . ' in file ' . $e->getFile());
        $response = [];
      }

      return $response;
    }



    /**
     * Make get http request
     * @param $url
     * @param $data
     * @return bool|mixed|string
     */
    public function get($url, $data)
    {
        return $this->make($url, $data, 'GET', $this->headers);

    }


} 