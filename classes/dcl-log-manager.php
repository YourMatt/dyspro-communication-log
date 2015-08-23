<?php

class dcl_log_manager {

   public $error_message;
   private $db;

   public function __construct () {
      global $wpdb;
      $this->db = &$wpdb;
   }

   public function get_log_entries ($category, $date) {

      // set the gmt date range
      $date_seconds = strtotime (str_replace ('-', '/', $date)); // strtotime doesn't like dashes, so convert to slashes
      $date_seconds -= 60 * 60 * get_option ('gmt_offset');

      $date_start = date ('Y-m-d H:i:s', $date_seconds);
      $date_end = date ('Y-m-d H:i:s', $date_seconds + 60 * 60 * 24);

      // load the data from the database
      $sql = $this->db->prepare ('
         SELECT   id
         ,        category
         ,        author
         ,        log_entry
         ,        date_updated
         , (      SELECT meta_value FROM wp_usermeta WHERE user_id = author AND meta_key = \'first_name\') AS author_first_name
         , (      SELECT meta_value FROM wp_usermeta WHERE user_id = author AND meta_key = \'last_name\') AS author_last_name
         FROM     ' . DCL_TABLE_LOG . '
         WHERE    category = %s
         AND      date_updated BETWEEN %s AND %s',
         $category,
         $date_start,
         $date_end);

      return $this->db->get_results ($sql);

   }

   public function get_num_log_entries_for_current_date ($category) {

      return 0;

   }

   public function get_log_entry ($log_id) {

      return array ();

   }

   public function add_log_entry ($log_entry, $category, $author) {

      // validate required fields
      if (!$log_entry || !$category || !$author) {
         $this->error_message = 'Missing required fields. Please try again.';
         return false;
      }

      // insert the new record
      if (! $this->db->insert (DCL_TABLE_LOG, array (
         'log_entry' => $log_entry,
         'category' => $category,
         'author' => $author,
         'date_updated' => current_time ('mysql', 1)
      ))) return false;

      return true;

   }

   public function update_log_entry ($log_id) {

      return true;

   }

   public function delete_log_entry ($log_id) {

      return true;

   }

}