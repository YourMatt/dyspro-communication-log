<?php

class dcl_shortcode_manager {

   private $db;

   public function __construct () {
      global $wpdb;
      $this->db = &$wpdb;

      wp_enqueue_script ('dcl_main', DCL_BASE_WEB_PATH . '/content/js/main.js', null, '20150821', true);
      wp_enqueue_script ('jquery-ui-datepicker');
      wp_enqueue_style ('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');

   }

   public function build_communication_log_page ($attributes) {

      // load shortcode attributes
      $categories = explode (',', $attributes["categories"]);
      $category_description = $attributes["category_description"];
      $category_description || $category_description = "category";

      // load current category selection
      $current_category = $_REQUEST['cat'];
      $current_date = $_REQUEST['date'];

      // show log entries for the current category if selected
      if ($current_category) $html = $this->get_category_log_view ($current_category, $current_date);

      // show category selection if none already selected
      else $html = $this->get_category_selection_view ($categories, $category_description);

      return $html;

   }

   private function get_category_selection_view ($categories, $category_description) {

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

   private function get_category_log_view ($category, $date)
   {

      $html = '';

      $current_date = date ('m-d-Y', time () + 60 * 60 * get_option ('gmt_offset')); // db stores gmt - pull date to wordpress time zone
      $date || $date = $current_date;

      // create base page
      $html .= '
<div class="dcl-category-log-wrapper">
   <p>Viewing log entries for ' . $category . '. Select a date below to view log entries.</p>
   <dl>
      <dt>Date</dt>
      <dd><input name="date" id="dcl-date" value="' . $date . '"/></dd>
   </dl>';

      // load log entries for the current date
      $lm = new dcl_log_manager ();
      $log_entries = $lm->get_log_entries ($category, $date);

      // return message for no logs if none found
      if (! $log_entries) {
         $html .= '
   <p class="dcl-empty-list-message">There are currently no log entries for the selected date.</p>';
      }

      // build the log table if entries found
      else $html .= $this->get_log_table ($log_entries);

      // add the add log field if showing current date
      if ($date == $current_date) {
         $html .= '
   <form id="dcl-form-add" method="post">
      <input type="hidden" name="action" value="add"/>
      <input type="hidden" name="cat" value="' . $category . '"/>
      ' . wp_nonce_field('dcl_add', DCL_MANAGEMENT_NONCE, false, false) . '
      <textarea name="log_entry"></textarea>
      <p class="center">
         <button class="form-submit">Save</button>
      </p>
   </form>';
      }

      $html .= '
</div>';

      return $html;

   }

   private function get_log_table ($log_entries)
   {

      $html = '
<table id="dcl-table" class="display" cellspacing="0" width="100%">
<thead>
   <tr>
      <th>Time</th>
      <th>User</th>
      <th>Log Entry</th>
      <th></th>
   </tr>
</thead>
<tbody>';

      foreach ($log_entries as $log_entry) {
         $time = strtotime ($log_entry->date_updated) + 60 * 60 * get_option ('gmt_offset');
         $html .= '
   <tr log="' . $log_entry->id . '">
      <td class="time">' . date ('H:i', $time) . '</td>
      <td class="user">' . $log_entry->author_first_name . ' ' . $log_entry->author_last_name . '</td>
      <td class="entry">' . $log_entry->log_entry . '</td>
      <td class="edit-controls">';

         // add edit controls only for the current user
         if (get_current_user_id () == $log_entry->author) {
            $html .= '
         <button class="dcl-edit-log-entry">Edit</button>
         <button class="dcl-delete-log-entry">Delete</button>';
         }

         $html .= '
      </td>
   </tr>';
      }

      $html .= '
</tbody>
</table>';

      return $html;

   }

}
