<?php

class dcl_log_manager {

   public $updated_document_title;
   public $error_message;
   private $db;

   public function __construct () {
      global $wpdb;
      $this->db = &$wpdb;
   }

   public function get_log_entries () {

      return array ();

   }

   public function get_log_entry ($log_id) {

      return array ();

   }

   public function add_log_entry () {

      return true;

   }

   public function update_log_entry ($log_id) {

      return true;

   }

   public function delete_log_entry ($log_id) {

      return true;

   }

}