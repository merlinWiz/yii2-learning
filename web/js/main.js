$('#batchMediaDelete').on('click',function(event) {
	event.preventDefault();
	if(confirm('Are you sure you want to delete these items?')){
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
	} else {
		return false;
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

function registerMediaUploadClick(){
	$('#mediaUploadButton').on('click', function(event){
		event.preventDefault();
		$('#mediaUploadModal').modal('show');
	});
}


$(document).ready(function(){

	if($('#mediaUploadModal').length){
		
		loadMediaUploader();
		
		registerMediaUploadClick();
		
		$('#mediaUploadModal').on('hide.bs.modal', function(){
			$.pjax.reload({container:'#mediaGridPjax'});
		});
	}

	if($('#mediaModal').length){
		loadMediaBrowser();
		$(document).on('pjax:success', function() {	
			registerMediaClick();
		});
	}
	
	
});

function loadMediaUploader(){
		var csrfToken = $('meta[name="csrf-token"]').attr("content");
		$.post( "index.php?r=media/upload", {_csrf: csrfToken}, function( data ) {
			$('#mediaUploadModal .modal-body').html(data);
		});
}

function loadMediaBrowser(){
		var csrfToken = $('meta[name="csrf-token"]').attr("content");
		$.post( "index.php?r=media/index-ajax", {_csrf: csrfToken}, function( data ) {
			$('#mediaModal .modal-body').html(data);
			$('#mediaModal').css('z-index', 65537);
			loadMediaUploader();
			registerMediaClick();
			registerMediaUploadClick();
		});
}

var mediaBrowser = {
	init: function(fieldName){
		mediaBrowser.editorInput = fieldName;
		$('#mediaModal').modal('show');
		return false;
	}
}

