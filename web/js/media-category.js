
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
