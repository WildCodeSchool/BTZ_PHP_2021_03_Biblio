// $('.custom-file-input').on('change',function(){
// 	var fileName = $(this).val().replace(/\\/g, '/').replace(/.*\//, '');
// 	$(".custom-file-label").text(fileName); 
// });

$('.custom-file-input').on('change', function(event) {
	var inputFile = event.currentTarget;
	$(inputFile).parent()
		.find('.custom-file-label')
		.html(inputFile.files[0].name);
});