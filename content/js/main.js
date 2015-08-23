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

   },

   getParameterByName: function (name) {
      name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
      var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
         results = regex.exec(location.search);
      return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
   }

}