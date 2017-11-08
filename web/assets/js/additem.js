$(document).ready(event => {

	let $nb_files = 1;
	$('#add_image').click(e => {
		e.preventDefault();
		$inputTemplate = $('<input type="file" name="images[]" multiple="multiple" />')
		$('#inputs').append($inputTemplate);
		$nb_files ++;
		if($nb_files > 0 && !$('#remove_image').length){
			$('#images').append('<input type="button" name="remove_image" id="remove_image" value="Enlever une image"/>');
		}
	});
	$('body').on('click', '#remove_image', function(e){
		e.preventDefault();
		$('#inputs > input').last().remove();
		$nb_files --;
		if($nb_files == 0){
			$('#remove_image').remove();
		}
	});
});