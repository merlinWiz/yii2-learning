$('#batchMediaDelete').on('click',function(event) {
	event.preventDefault();
    var keys = $('#mediaGrid').yiiGridView('getSelectedRows'); // returns an array of pkeys, and #grid is your grid element id
    $.post({
       url: 'index.php?r=media/batch-delete', // your controller action
       dataType: 'json',
       data: {keys: keys},
       success: function(data) {
          if (data.status === 'success') {
	          $.pjax.reload({container:'#mediaGridPjax'});
              alert('Selected media was deleted!');
          } else if(data.status === 'error') {
              alert('Selected media was not deleted!');
          }
       },
    });
    
});