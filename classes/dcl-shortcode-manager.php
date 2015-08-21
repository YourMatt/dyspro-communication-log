<?php

class dcl_shortcode_manager {

   private $db;

   public function __construct () {
      global $wpdb;
      $this->db = &$wpdb;

      wp_enqueue_script ('dcl_main', DCL_BASE_WEB_PATH . '/content/js/main.js', null, '20150821', true);

   }

   public function build_communication_log_page ($attributes) {

      // load shortcode attributes
      $categories = explode (',', $attributes["categories"]);
      $category_description = $attributes["category_description"];
      $category_description || $category_description = "category";

      // load current category selection
      $current_category = $_REQUEST['cat'];

      // show log entries for the current category if selected
      if ($current_category) $html = 'Selected ' . $current_category;

      // show category selection if none already selected
      else $html = $this->get_category_selection_page ($categories, $category_description);

      return $html;

   }

   private function get_category_selection_page ($categories, $category_description) {

      $dm = new dcl_log_manager ();

      $html = '
<div class="dcl-category-selection-wrapper">
   <p>Select a ' . $category_description . ' to continue.</p>
   <ul>';

      foreach ($categories as $category) {

         $num_entries = $dm->get_num_log_entries_for_current_date ($category);
         $num_entries_title = ($num_entries == 1) ? 'entry' : 'entries';

         $html .= '
      <li>
         <a href="?cat=' . urlencode ($category) . '">
            <div class="category">' . $category . '</div>
            <div class="info">' . $num_entries . ' log ' . $num_entries_title . ' entered today</div>
         </a>
      </li>';

      }

      $html .= '
   </ul>
</div>';

      return $html;

   }

}