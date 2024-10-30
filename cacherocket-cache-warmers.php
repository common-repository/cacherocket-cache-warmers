<?php
/*
Plugin Name: CacheRocket - the most advanced Cache Warming
Description: A plugin to fetch Cache warmers from the CacheRocket API.
Version: 1.0.0
Author: NOOBBase
License: GPLv2 or later
*/

if (!defined('WPINC')) {
  die;
}


function cacherocket_crawlers_register_settings()
{
  register_setting(
    'cacherocket_crawlers_options_group',
    'cacherocket_api_key',
    'sanitize_text_field'
  );

  register_setting(
    'cacherocket_crawlers_options_group',
    'cacherocket_api_secret',
    'sanitize_text_field'
  );

  add_settings_section('cacherocket_crawlers_section', 'API Settings', null, 'cacherocket-warmers');

  add_settings_field('cacherocket_api_key', 'Public API Key', 'cacherocket_crawlers_api_key_field', 'cacherocket-warmers', 'cacherocket_crawlers_section');
  add_settings_field('cacherocket_api_secret', 'Secret API Key', 'cacherocket_crawlers_api_secret_field', 'cacherocket-warmers', 'cacherocket_crawlers_section');
}
add_action('admin_init', 'cacherocket_crawlers_register_settings');


function cacherocket_crawlers_api_key_field()
{
  $api_key = get_option('cacherocket_api_key');
  echo '<input type="text" name="cacherocket_api_key" value="' . esc_attr($api_key) . '" />';
}

function cacherocket_crawlers_api_secret_field()
{
  $api_secret = get_option('cacherocket_api_secret');
  echo '<input type="password" name="cacherocket_api_secret" value="' . esc_attr($api_secret) . '" />';
}

require_once plugin_dir_path(__FILE__) . 'admin/settings-page.php';
require_once plugin_dir_path(__FILE__) . 'includes/api.php';

function cacherocket_crawlers_activate()
{
  add_option('cacherocket_api_key', '');
  add_option('cacherocket_api_secret', '');
}
register_activation_hook(__FILE__, 'cacherocket_crawlers_activate');

function cacherocket_crawlers_deactivate()
{
  delete_option('cacherocket_api_key');
  delete_option('cacherocket_api_secret');
}
register_deactivation_hook(__FILE__, 'cacherocket_crawlers_deactivate');

// Add the admin menu item for CacheRocket Crawlers
function cacherocket_crawlers_menu()
{
  add_menu_page(
    'CacheRocket Warmers',
    'CacheRocket Warmers',
    'manage_options',
    'cacherocket-warmers',
    'cacherocket_crawlers_settings_page',
    'dashicons-admin-site-alt3',
    100
  );
}
add_action('admin_menu', 'cacherocket_crawlers_menu');
