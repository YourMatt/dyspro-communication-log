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

}