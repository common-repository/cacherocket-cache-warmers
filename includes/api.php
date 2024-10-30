<?php
if (!defined('WPINC')) {
  die;
}

function cacherocket_crawlers_fetch_data()
{
  $api_key = get_option('cacherocket_api_key');
  $api_secret = get_option('cacherocket_api_secret');

  if (!$api_key || !$api_secret) {
    return new WP_Error('missing_api_key', 'API Key or Secret is missing.');
  }

  $api_url = 'https://cacherocket.com/api/wordpress/getCrawlers';

  // Use wp_json_encode() instead of json_encode()
  $body = wp_json_encode([
    'publicKey' => $api_key,
    'secretKey' => $api_secret
  ]);

  $response = wp_remote_post($api_url, [
    'headers' => [
      'Content-Type' => 'application/json',
    ],
    'body' => $body,
  ]);

  if (is_wp_error($response)) {
    return $response;
  }

  $body = wp_remote_retrieve_body($response);
  $data = json_decode($body, true);

  if (json_last_error() !== JSON_ERROR_NONE) {
    return new WP_Error('invalid_json', 'Invalid JSON response from the API.');
  }

  return $data;
}
