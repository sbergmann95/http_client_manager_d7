<?php

/**
 * Allow modules to push middleware and handlers onto the stack when building the client.
 *
 * @param $stack
 * @param $service_api
 */
function hook_http_client_manager_handler_stack_alter(&$stack, $service_api) {
  if ($service_api !== 'some_service_api') {
    return;
  }

  $stack->push(my_custom_logger());
}

/**
 * Implements hook_http_services_api_definitions().
 *
 * @note variable name for getting the environment for a service
 * endpoint is in this format: 'http_client_manager_' . $endpoint_id . '_env'
 */
function hook_http_services_api_definitions() {
  // Get the env settings from the admin settings page.
  $env = variable_get('http_client_manager_some_service_api_env', 'local');
  $config = some_service_api_env_config($env);

  return [
    'some_service_api' => [
      'title' => 'Some Service API',
      'api_path' => 'src/api/some_service_api.json',
      'config' => $config,
    ],
  ];
}

/**
 * Define the Request Options for the local, staging, and prod environments.
 *
 * @param string $env
 *   The environment to get the Request options config that will be used when
 *   creating the Guzzle Http Client.
 *
 * @see http://docs.guzzlephp.org/en/stable/request-options.html
 *   For valid Request options.
 *
 * @return array
 *   The config array containing Request options.
 */
function some_service_api_env_config($env = 'local') {
  $config = [
    'local' => [
      'base_uri' => 'local_random_endpoint',
      'headers' => [
        'someHeader' => 'value',
      ],
    ],
    'staging' => [
      'base_uri' => 'staging_random_endpoint',
    ],
    'prod' => [
      'base_uri' => 'prod_random_endpoint',
    ],
  ];

  return $config[$env] ?? $config['local'];
}

