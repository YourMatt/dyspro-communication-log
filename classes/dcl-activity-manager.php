<?php

class dcl_activity_manager {

   public $error_message;
   public $success_message;

   public function __construct () {}

   public function process_management_forms () {

      switch ($_POST['action']) {
         case 'add':
            $this->process_add ();
            break;
         case 'edit':
            $this->process_edit ();
            break;
         case 'delete':
            $this->process_delete ();
            break;
      }

   }

   private function process_add ()
   {

      if (! wp_verify_nonce ($_POST[DCL_MANAGEMENT_NONCE], 'dcl_add')) {
         $this->error_message = 'Could not verify the form submission. Please try again.';
         return;
      }

      $log_entry = $_POST['log_entry'];
      $category = $_POST['cat'];
      $author = get_current_user_id ();

      $log_manager = new dcl_log_manager ();

      if ($log_manager->add_log_entry ($log_entry, $category, $author)) {
         $this->success_message = 'Successfully added the new log entry.';
      }
      else {
         if ($log_manager->error_message) $this->error_message = $log_manager->error_message;
         else $this->error_message = 'There as an error saving your log entry. Please contract your administrator.';
      }

   }

   private function process_edit () {

      if (! wp_verify_nonce ($_POST[DCL_MANAGEMENT_NONCE], 'dcl_edit')) {
         $this->error_message = 'Could not verify the form submission. Please try again.';
         return;
      }

      $log_id = $_POST['log_id'];
      $author = get_current_user_id ();
      $log_entry = $_POST['log_entry'];
      $category = $_POST['cat'];

      $log_manager = new dcl_log_manager ();

      if ($log_manager->update_log_entry ($log_id, $log_entry, $category, $author)) {
         $this->success_message = 'Successfully updated the log entry.';
      }
      else {
         if ($log_manager->error_message) $this->error_message = $log_manager->error_message;
         else $this->error_message = 'There was an error updating your log entry. Please contact your administrator.';
      }

   }

   private function process_delete () {

      if (! wp_verify_nonce ($_POST[DCL_MANAGEMENT_NONCE], 'dcl_delete')) {
         $this->error_message = 'Could not verify the form submission. Please try again.';
         return;
      }

      $log_id = $_POST['log_id'];
      $log_manager = new dcl_log_manager ();

      if ($log_manager->delete_log_entry ($log_id)) {
         $this->success_message = 'Successfully deleted the log entry.';
      }
      else {
         if ($log_manager->error_message) $this->error_message = $log_manager->error_message;
         else $this->error_message = 'There was an error deleting the log entry. Please contact your administrator.';
      }

   }

}