<?php

namespace Drupal\http_client_manager;

/**
 * Class HttpClientManagerFactory.
 *
 * @package Drupal\http_client_manager
 */
class HttpClientManagerFactory implements HttpClientManagerFactoryInterface {


  /**
   * An array of HTTP Clients.
   *
   * @var array
   */
  protected $clients = [];

  /**
   * {@inheritdoc}
   */
  public function get($service_api) {
    if (!isset($this->clients[$service_api])) {

      $apiHandler = new HttpServiceApiHandler();
      $this->clients[$service_api] = new HttpClient($service_api, $apiHandler);
    }
    return $this->clients[$service_api];
  }

}
