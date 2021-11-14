<?php
  function load_files() {
    wp_enqueue_style('Roboto-Font', 'https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('Font-Awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

    if(strstr($_SERVER['SERVER_NAME'], 'fictionaluniversity.local')) {
      wp_enqueue_script('main-university-js', 'http://localhost:3000/bundled.js', NULL, '1.0', true);
    } else {
      wp_enqueue_script('vendor.js', get_theme_file_uri('/bundled-assets/vendors~scripts.8c97d901916ad616a264.js'), NULL, '1.0', true);
      wp_enqueue_script('main-university-js', get_theme_file_uri('/bundled-assets/scripts.bc49dbb23afb98cfc0f7.js'), NULL, '1.0', true);
      wp_enqueue_style('main-university-css', get_stylesheet_uri('/budled-assets/styles.css'));
    };

    // wp_enqueue_script('main-university-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, '1.0', true);
    // wp_enqueue_style('main-university-css', get_stylesheet_uri());
  };

  // Adds title tag to page.
  function extra_support() {
    add_theme_support('title-tag');
    register_nav_menu('headerMenuLocation', 'Header Menu Location');
    register_nav_menu('footerLocationOne', 'Footer Location One');
    register_nav_menu('footerLocationTwo', 'Footer Location Two');
  };
  function adjust_queries($query) {
    $today = date('Ymd');
    if(!is_admin() AND is_post_type_archive('program') AND $query->is_main_query()) {
      $query->set("orderby", "title");
      $query->set("order", "ASC");
      $query->set("posts_per_page", -1);
    };

    if(!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) {
      $query->set("meta_key", "event_date");
      $query->set("orderby", "meta_value_num");
      $query->set("order", "ASC");
      $query->set("meta_query", array(
        array(
          "key" => "event_date",
          "compare" => ">=",
          "value" => $today,
          "type" => "numeric"
        )
      ));
    };
  };

  add_action('wp_enqueue_scripts', 'load_files');
  add_action('after_setup_theme', 'extra_support');
  add_action('pre_get_posts', 'adjust_queries');
?>