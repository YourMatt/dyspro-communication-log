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