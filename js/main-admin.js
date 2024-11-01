jQuery(function($) {

$('input[name="more_than_one"]').on('change', function(){
	var defaultText = 'Use more than one character';
	if($(this).is(':checked')){
		$(this).parent().find('label').html('To use it, please download <a target="_blank" href="https://sellfy.com/p/B3J6/">PRO version</a>')
	}else{
		$(this).parent().find('label').text(defaultText);
	}
});


$('.snowt_select2').select2();

});