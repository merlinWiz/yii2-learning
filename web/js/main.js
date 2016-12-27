
function mediaSelectModal(link){
	event.preventDefault();
	var item_url = link.href;
	document.getElementById(mediaBrowser.editorInput).value = item_url;
	$('#mediaModal').modal('hide');
}


$(document).ready(function(){
	
	if($('#batchMediaDelete').length){
		$('#batchMediaDelete').on('click',function(event) {
			event.preventDefault();
			var keys = $('#mediaGrid').yiiGridView('getSelectedRows');
			if(keys.length && confirm('Are you sure you want to delete these items?')){
			    $.post({
			       url: 'index.php?r=media/batch-delete',
			       dataType: 'json',
			       data: {keys: keys},
			       success: function(data) {
			          if (data.status === 'success') {
				          $.pjax.reload({container:'#mediaGridPjax'});
			          } else if(data.status === 'error') {
			              alert('Selected media was not deleted!');
			          }
			       },
			    });
			} else {
				return false;
			}
		});
	}
	
	if($('#mediaUploadContainer').length){
				
		$('#mediaUploadButton').on('click', function(event){
			event.preventDefault();
			$('#mediaUploadContainer').toggle();
		});
				
		$('#mediaUploadForm').on('beforeSubmit', function(event){
			event.preventDefault();
			var form = $(this);
			var mediaInput = document.getElementById('mediaInput');
			var files = mediaInput.files;
			var formData = new FormData(form[0]);
			$.each(files, function(key, file){
				formData.append('files[]', file, file.name);
			});
			if(!form.find('.has-error').length){
				$.post({
					url: 'index.php?r=media/upload',
					data: formData,
					cache: false,
					processData: false,
					contentType: false,
					success: function(data){
						console.log(data);
						$('#upload-errors').remove();
						if(data.status === 'success'){
							var mediaIndexUrl = 'index.php?r=media/index' + (typeof mediaUrlPostfix !== 'undefined' ? mediaUrlPostfix : '');
							$.pjax({url: mediaIndexUrl, container: '#mediaGridPjax', push: false});
							mediaInput.value = '';
						}
												
						if(data.errors.media){
							$('#mediaUploadForm').append('<div id="upload-errors" class="alert alert-danger"><h5>Ошибки при загрузке файлов: </h5><ul></ul></div>');
							$.each(data.errors.media, function(index, error){
								var details = '';
								$.each(error.details, function(key, detail){
									details += '<p>– ' + detail[0] + '</p>';
								});
								$('#upload-errors ul').prepend('<li><h6>' + error.file + '</h6>' + details + '</li>');
							});
						}
												
					},
					error: function(jqXHR, textStatus, errorThrown){console.log('ERRORS: ' + errorThrown); console.log(jqXHR);}
				});
			}
			return false;
		});
	}

	if($('#mediaModal').length){
		var mediaUrlPostfix = '-modal';
		loadMediaBrowser();
		$(document).on('pjax:success', function() {	
		});
	}
	
	
});

function loadMediaBrowser(){
		var csrfToken = $('meta[name="csrf-token"]').attr("content");
		$.post( "index.php?r=media/index-modal", {_csrf: csrfToken}, function( data ) {
			$('#mediaGridPjax').replaceWith(data);
			$('#mediaModal').css('z-index', 65537);
		});
}

var mediaBrowser = {
	init: function(fieldName){
		mediaBrowser.editorInput = fieldName;		
		$('#mediaModal').modal('show');
		return false;
	}
}

