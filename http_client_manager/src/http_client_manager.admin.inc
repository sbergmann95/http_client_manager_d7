<?php

use Drupal\http_client_manager\HttpServiceApiHandler;

/**
 * The http client manager services admin settings form.
 *
 * @param $form
 * @param $form_state
 *
 * @return mixed
 */
function http_client_manager_overview_form($form, $form_state) {
  $controller = new HttpServiceApiHandler();
  $servicesApi = $controller->getServicesApi();

  $header = [
    'id' => t('ID'),
    'title' => t('Title'),
    'env' => t('Environment'),
    'base_uri' => t('Base URI'),
  ];
  $rows = [];
  foreach ($servicesApi as $api) {
    $rows[$api['id']] = [
      'id' => $api['id'],
      'title' => $api['title'],
      'env' => variable_get('http_client_manager_' . $api['id'] . '_env', 'local'),
      'base_uri' => $api['config']['base_uri'],
    ];
  }

  $form['env_selection'] = [
    '#type' => 'select',
    '#title' => 'Select environment for services:',
    '#options' => [
      'local' => 'Local',
      'staging' => 'Staging',
      'prod' => 'Prod',
    ],
    '#empty' => t('There are no Http Services Api configured yet.'),
  ];

  $form['services'] = [
    '#type' => 'tableselect',
    '#header' => $header,
    '#options' => $rows,
  ];

  $form['submit'] = [
    '#type' => 'submit',
    '#value' => 'Save Environment Settings',
  ];

  return $form;
}

/**
 * Submit handler for setting the environment for api services.
 *
 * @param $form
 * @param $form_state
 */
function http_client_manager_overview_form_submit($form, &$form_state) {
  $env_selection = $form_state['values']['env_selection'];

  // Sets env for the selected services.
  foreach ($form_state['values']['services'] as $api_id => $selected) {
    if ($selected !== 0) {
      variable_set('http_client_manager_' . $api_id . '_env', $env_selection);
    }
  }
}
