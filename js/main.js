jQuery(function($) {
	var flurryBlur = snowt_option_blur;
	if(flurryBlur == '1'){
		var snowt_blur_opt = true;
	}else{
		var snowt_blur_opt = false;
	}

	var snowt_speed = parseInt(snowt_option_speed) * 1000;
	var snowt_frequency = parseInt(snowt_option_frequency) * 100;

	$('body').flurry({
		character: snowt_option_character,
		height: parseInt(snowt_option_height),
		speed: snowt_speed,
		wind: parseInt(snowt_option_wind),
		frequency: snowt_frequency,
		large: parseInt(snowt_option_large),
		small: parseInt(snowt_option_small),
		rotation: parseInt(snowt_option_rotation),
		blur: snowt_blur_opt,
		zIndex: parseInt(snowt_option_zindex),
	});
});