$(document).ready(event => {

	let inputs = document.querySelectorAll( '.imageFile' );
	console.log(inputs);
	Array.prototype.forEach.call( inputs, function( input )
	{

		input.addEventListener( 'change', function( e )
		{
			$('.uploadesFilenames').html('');
			let template = '';
			for(let file of this.files){
				template = '<p class="uploadesFilename">'+file.name+'</p>';
				$('.uploadesFilenames').append(template);
			}
		});
	});

});