<?php

class dcl_plugin_manager {

   private $db;

   public function __construct () {
      global $wpdb;
      $this->db = &$wpdb;
   }

   // run when activating the plugin
   public function activate () {

      // create log table if doesn't already exist
      if ($this->db->get_var ("SHOW TABLES LIKE '" . DCL_TABLE_LOG . "'") != DCL_TABLE_LOG) {

         $sql = '
            CREATE TABLE    ' . DCL_TABLE_LOG . '
            (               id              mediumint(8)    NOT NULL AUTO_INCREMENT
            ,               category        varchar(32)     NOT NULL
            ,               author          bigint(20)      NOT NULL
            ,               log_entry       longtext
            ,               date_updated    datetime        NOT NULL
            ,               UNIQUE KEY      id (id))
         ';
         $this->db->query ($sql);

      }

   }

   // run when uninstalling the plugin
   public function uninstall () {

      // delete the log table
      $sql = '
         DROP TABLE IF EXISTS ' . DCL_TABLE_LOG;
      $this->db->query ($sql);

   }

}