<?php


namespace PhalconAPI;

use Phalcon\Exception;
use PhalconAPI\Responses\ResponseStub;

/**
 * SDK for Phalcon REST API
 * This class can be used as a standalone client for HTTP based requests or
 * you can use it for internal API calls by calling API::setApp()
 */
class SDK
{
  const METHOD_GET = 'GET';
  const METHOD_POST = 'POST';
  const METHOD_PUT = 'PUT';
  const METHOD_DELETE = 'DELETE';

  /** @var API */
  private $app;

  /** @var string */
  private $url;

  public function setApp(API $app)
  {
    $this->app = $app;
  }

  public function setURL($url)
  {
    $this->url = $url;
  }

  /**
   * Makes a GET call based on path/url
   * @param $path
   * @throws \Phalcon\Exception
   * @return ResponseStub
   */
  public function get($path)
  {
    // Get from the internal call if available
    if(isset($this->app))
    {
      return $this->app->handle($path);
    }

    // Get via HTTP (cURL) if available
    if(isset($this->url))
    {
      return $this->getHTTPResponse($path, self::METHOD_GET);
    }

    // todo better exception message with link
    throw new Exception(
      'No app configured for internal calls,
          and no URL supplied for HTTP based calls'
    );
  }

  /**
   * Makes a POST call based on path/url
   * todo this is not complete
   * @param $path
   * @throws \Phalcon\Exception
   * @return ResponseStub
   */
  public function post($path)
  {
    // Get from the internal call if available
    if(isset($this->app))
    {
      return $this->app->handle($path);
    }

    // Get via HTTP (cURL) if available
    if(isset($this->url))
    {
      return $this->getHTTPResponse($path, self::METHOD_POST);
    }

    // todo better exception message with link
    throw new Exception(
      'No app configured for internal calls,
          and no URL supplied for HTTP based calls'
    );
  }

  /**
   * Makes a PUT call based on path/url
   * todo this is not complete
   * @param $path
   * @throws \Phalcon\Exception
   * @return ResponseStub
   */
  public function put($path)
  {
    // Get from the internal call if available
    if(isset($this->app))
    {
      return $this->app->handle($path);
    }

    // Get via HTTP (cURL) if available
    if(isset($this->url))
    {
      return $this->getHTTPResponse($path, self::METHOD_POST);
    }

    // todo better exception message with link
    throw new Exception(
      'No app configured for internal calls,
          and no URL supplied for HTTP based calls'
    );
  }

  /**
   * Makes a DELETE call based on path/url
   * todo this is not complete
   * @param $path
   * @throws \Phalcon\Exception
   * @return ResponseStub
   */
  public function delete($path)
  {
    // Get from the internal call if available
    if(isset($this->app))
    {
      return $this->app->handle($path);
    }

    // Get via HTTP (cURL) if available
    if(isset($this->url))
    {
      return $this->getHTTPResponse($path, self::METHOD_POST);
    }

    // todo better exception message with link
    throw new Exception(
      'No app configured for internal calls,
          and no URL supplied for HTTP based calls'
    );
  }

  /**
   * Makes a cURL HTTP request to the API and returns the response
   * todo this needs to also handle PUT, POST, DELETE
   * @param $path
   * @param string $method
   * @throws \Exception
   * @return string
   */
  private function getHTTPResponse($path, $method = self::METHOD_GET)
  {
    // Prepare curl
    $curl = curl_init($this->url . $path);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $curlResponse = curl_exec($curl);

    // Handle failed request
    if($curlResponse === false)
    {
      $info = curl_getinfo($curl);
      curl_close($curl);

      throw new \Exception('Transmission Error: ' . print_r($info, true));
    }

    // Return response
    curl_close($curl);
    return json_decode($curlResponse);
  }
}