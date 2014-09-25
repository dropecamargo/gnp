$(window).ready(function() {

   if ($('.btn-delete').length) {
      $('.btn-delete').click(function() {
         var id = $(this).data('id');
         var form = $('#form-delete');
         var action = form.attr('action').replace('USER_ID', id);
         var row =  $(this).parents('tr');
         
         row.fadeOut(1000);
         
         $.post(action, form.serialize(), function(result) {
            if (result.success) {
               setTimeout (function () {
                  row.delay(1000).remove();
                  alert(result.msg);
               }, 1000);                
            } else {
               row.show();
            }
         }, 'json');
      });
   }

}); 