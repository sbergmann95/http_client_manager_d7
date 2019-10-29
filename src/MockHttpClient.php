<?php

namespace Drupal\http_client_manager;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Command\Command;
use GuzzleHttp\Command\CommandInterface;
use GuzzleHttp\Command\Exception\CommandException;
use GuzzleHttp\Command\Result;
use GuzzleHttp\Command\ServiceClient;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Request;

class MockHttpClient {

  /**
   * Service Client for mocking responses.
   *
   * @param array $responses
   *
   * @return \GuzzleHttp\Command\ServiceClient
   */
  public static function getServiceClient(array $responses) : ServiceClient {
    return new ServiceClient(
      new HttpClient([
        'handler' => MockHandler::createWithMiddleware($responses),
      ]),
      function (CommandInterface $command) {
        $data = $command->toArray();
        $data['action'] = $command->getName();
        return new Request('POST', '/', [], http_build_query($data));
      },
      function (ResponseInterface $response, RequestInterface $request) {
        $data = json_decode($response->getBody(), true);
        parse_str($request->getBody(), $data['_request']);
        return new Result($data);
      }
    );
  }

}
