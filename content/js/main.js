if (!$) var $ = jQuery;

$(document).ready (function () {

   if ($('.dcl-category-log-wrapper').length) {
      dclMain.setActionsForLogView();
   }

});

var dclMain = {

   setActionsForLogView: function () {

      $('#dcl-date').datepicker({
         dateFormat: 'mm-dd-yy'
      });

      $('#dcl-date').change (function () {
         document.location = '?cat=' + dclMain.getParameterByName ('cat') + '&date=' + $(this).val();
      });

      $('#dcl-date').keyup (function (e) {
         if (e.keyCode == 13) {
            $(this).change ();
         }
      });

      this.setFormButtonHandlers ();

   },

   setFormButtonHandlers: function () {

      // set edit log entry handler
      $('.dcl-edit-log-entry').click (function () {
         var row = $(this).parent().parent();

         var logId = row.attr ("log");
         var logEntry = $('.entry', row).text ();

         $.fancybox(
            '<h2>Edit Log Entry</h2>' + $('#dcl-form-edit').html (),
            {
               autoSize: false,
               width: 600,
               height: 'auto'
            }
         );

         var container = $('.fancybox-wrap');
         $('.form-submit', container).click(dclMain.saveModalHandler);
         $('.form-cancel', container).click(dclMain.closeModalHandler);
         $('input[name=log_id]', container).val(logId);
         $('textarea[name=log_entry]', container).val(logEntry);
         $('textarea[name=log_entry]', container).focus();

      });

      // set delete log entry handler
      $('.dcl-delete-log-entry').click (function () {
         var row = $(this).parent().parent();
         var logId = row.attr ('log');

         $.fancybox (
            '<h2>Delete Log Entry</h2>' + $('#dcl-form-delete').html (),
            {
               autoSize: false,
               width: 350,
               height: 'auto'
            }
         );

         var container = $ ('.fancybox-wrap');
         $ ('input[name=log_id]', container).val (logId);
         $ ('.form-cancel', container).click (dclMain.closeModalHandler);
      });

   },

   saveModalHandler: function() {
      var container = $('.fancybox-wrap');

      var logEntry = $('textarea[name=log_entry]', container).val();

      var errorMessage = '';
      if (! logEntry) errorMessage = 'Please enter a log entry.';

      if (errorMessage) {
         $('.error-message', container).html(errorMessage);
         $('.error-message', container).show();
         return false;
      }

      $('.error-message', container).hide();
      return true;

   },

   closeModalHandler: function() {
      $.fancybox.close();
      return false;
   },

   getParameterByName: function (name) {
      name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
      var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
         results = regex.exec(location.search);
      return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
   }

}