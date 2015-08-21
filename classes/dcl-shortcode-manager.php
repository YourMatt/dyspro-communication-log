<?php

class dcl_shortcode_manager {

   private $db;

   public function __construct () {
      global $wpdb;
      $this->db = &$wpdb;

      wp_enqueue_script ('dcl_main', DCL_BASE_WEB_PATH . '/content/js/main.js', null, '20150821', true);

   }

   public function build_communication_log_page ($attributes) {
      $categories = explode (',', $attributes["categories"]);
      $category_description = $attributes["category_description"];
      $category_description || $category_description = "category";

      $dm = new dcl_log_manager ();

      $html = 'categories: ' . print_r ($categories, true) . ' - desc: ' . $category_description;

      return $html;

   }

}