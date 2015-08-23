<?php

class dcl_log_manager {

   public $error_message;
   private $db;

   public function __construct () {
      global $wpdb;
      $this->db = &$wpdb;
   }

   public function get_log_entries () {

      return array ();

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