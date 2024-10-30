<?php

function cacherocket_crawlers_settings_page()
{
?>
  <div class="wrap">
    <h1>CacheRocket Cache Settings</h1>

    <div class="notice notice-info" style="margin-bottom: 20px; padding: 15px; background-color: #e7f3fe; border-left-color: #0073aa;">
      <h2>How Does It Work?</h2>
      <p>
        1. <strong>Create an <b>FREE</b> account</strong> at <a href="https://www.CacheRocket.com" target="_blank">CacheRocket.com</a>.<br>
        2. <strong>Create your Cache Warmer</strong> within your CacheRocket account.<br>
        3. <strong>Generate your API keys</strong> and add them here in the WordPress plugin.<br>
      </p>
      <p><strong>And let the magic happen!</strong></p>
    </div>
    <form method="post" action="options.php">
      <?php
      settings_fields('cacherocket_crawlers_options_group');
      do_settings_sections('cacherocket-warmers');
      submit_button();
      ?>
    </form>

    <h2>Cache Warmers</h2>
    <?php
    $crawlers = cacherocket_crawlers_fetch_data();
    if (is_wp_error($crawlers)) {
      echo '<p>Error: ' . esc_html($crawlers->get_error_message()) . '</p>';
    } else {
      if (!empty($crawlers['crawlers'])) {
        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Warmer ID</th>';
        echo '<th>Warmer Name</th>';
        echo '<th>Active</th>';
        echo '<th>Created At</th>';
        echo '<th>Updated At</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($crawlers['crawlers'] as $crawler) {
          $createdAt = new DateTime($crawler['createdAt']);
          $updatedAt = new DateTime($crawler['updatedAt']);

          echo '<tr>';
          echo '<td>' . esc_html($crawler['id']) . '</td>';
          echo '<td>' . esc_html($crawler['name']) . '</td>';
          echo '<td>' . esc_html($crawler['active'] ? 'Yes' : 'No') . '</td>';
          echo '<td>' . esc_html($createdAt->format('Y-m-d')) . '</td>';
          echo '<td>' . esc_html($updatedAt->format('Y-m-d')) . '</td>';
          echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
      } else {
        echo '<p>You haven’t got any warmers. Please create one in your CacheRocket account.</p>';
        echo '<a href="https://cacherocket.com/nl-NL/account/account-crawlers" target="_blank" class="button button-primary">Create Cache Warmer</a>';
      }
    }
    ?>

    <!-- Promotional Section -->
    <hr />
    <h2>About CacheRocket</h2>
    <p>
      CacheRocket is your ultimate solution to improve website performance by warming up your cache
      and ensuring your users always get the fastest experience. No more cold caches —
      let CacheRocket optimize your site with our state-of-the-art crawler technology.
    </p>
    <p>
      Interested in learning more or signing up? Visit our website:
      <a href="https://www.cacherocket.com" target="_blank">www.CacheRocket.com</a>
    </p>

    <h3>Why Use CacheRocket?</h3>
    <ul>
      <li>✔️ Improve website speed by preloading cache</li>
      <li>✔️ Reduce load times for your users</li>
      <li>✔️ Optimize your server’s performance</li>
      <li>✔️ Easy integration with WordPress</li>
    </ul>

    <p>
      Don't wait, try CacheRocket today and boost your site’s performance!
    </p>
  </div>
<?php
}
