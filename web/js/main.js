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


$('#category_add').hide();
$('#show_add_new_category').click(function(event){
	event.preventDefault();
	$('#category_add').toggle();
});

$('#add_new_category').on('click', function(){
	var titleInput = $("[name='added_category_title']");
	var title = titleInput.val();
	var parentSelect = $("[name='added_category_parent']");
	var parentId = parentSelect.val();
	if(title){
		$.post({
			url: 'index.php?r=media-category/ajax-create',
			dataType: 'json',
			data: {MediaCategory: {title: title, parent_id: parentId}	},
			success: function(data) {
				if (data.status === 'success') {
					$('#uploadform-category_id option:selected').removeAttr("selected");
					$('#uploadform-category_id').append('<option selected value="' + data.id + '">' + title + '</option>');
					titleInput.val('');
					alert('New category added!');
				} else if(data.status === 'error') {
					alert('Error adding new category!');
				}
			}
			
		});
	}
});

function registerMediaClick(){
	$('.media_src').on('click', function(event){ 
		event.preventDefault();
		var item_url = $(this).attr('href');
		document.getElementById(mediaBrowser.editorInput).value = item_url;
		$('#mediaModal').modal('hide');
	});
}

$(document).on('pjax:success', function() {	
	registerMediaClick();
});

$(document).ready(function(){
	loadMediaBrowser();
});

function loadMediaBrowser(){
		var csrfToken = $('meta[name="csrf-token"]').attr("content");
		$.post( "index.php?r=media/index-ajax", {_csrf: csrfToken}, function( data ) {
			$('#mediaModal .modal-body').html(data);
			$('#mediaModal').css('z-index', 65537);
			registerMediaClick();
		});
}

var mediaBrowser = {
	init: function(fieldName){
		mediaBrowser.editorInput = fieldName;
		$('#mediaModal').modal('show');
		return false;
	}
}

