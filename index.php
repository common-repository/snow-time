<?php
/*
Plugin Name: Snow Time
Description: Animated snow plugin for your website.
Version: 1.1
Author: WebArea | Vera Nedvyzhenko
*/

add_action('login_enqueue_scripts', 'snowt_scripts');
add_action('wp_enqueue_scripts', 'snowt_scripts' );
function snowt_scripts(){
	wp_enqueue_script('jquery', false, array('jquery'));
	wp_enqueue_script('snowt_flurry_scripts', plugins_url('js/jquery.flurry.min.js', __FILE__), array('jquery'), false, true);

	$snowt_option_character = get_option('snowt_options')['snowt_character'];
	$snowt_option_height = get_option('snowt_options')['snowt_height'];
	$snowt_option_speed = get_option('snowt_options')['snowt_speed'];
	$snowt_option_frequency= get_option('snowt_options')['snowt_frequency'];
	$snowt_option_small = get_option('snowt_options')['snowt_small'];
	$snowt_option_large = get_option('snowt_options')['snowt_large'];
	$snowt_option_rotation = get_option('snowt_options')['snowt_rotation'];
	$snowt_option_blur = get_option('snowt_options')['snowt_blur'];
	$snowt_option_wind = get_option('snowt_options')['snowt_wind'];
	$snowt_option_zindex = get_option('snowt_options')['snowt_zindex'];

	wp_enqueue_script('snowt_main_scripts', plugins_url('js/main.js', __FILE__), array('jquery'), false, true);

	wp_localize_script('snowt_main_scripts', 'snowt_option_character', $snowt_option_character);
	wp_localize_script('snowt_main_scripts', 'snowt_option_height', $snowt_option_height);
	wp_localize_script('snowt_main_scripts', 'snowt_option_speed', $snowt_option_speed);
	wp_localize_script('snowt_main_scripts', 'snowt_option_frequency', $snowt_option_frequency);
	wp_localize_script('snowt_main_scripts', 'snowt_option_small', $snowt_option_small);
	wp_localize_script('snowt_main_scripts', 'snowt_option_large', $snowt_option_large);
	wp_localize_script('snowt_main_scripts', 'snowt_option_rotation', $snowt_option_rotation);
	wp_localize_script('snowt_main_scripts', 'snowt_option_blur', $snowt_option_blur);
	wp_localize_script('snowt_main_scripts', 'snowt_option_wind', $snowt_option_wind);
	wp_localize_script('snowt_main_scripts', 'snowt_option_zindex', $snowt_option_zindex);
}

add_action('admin_enqueue_scripts', 'snowt_admin_scripts');
function snowt_admin_scripts(){
	wp_enqueue_style('snowt_admin_select2', plugins_url('css/select2.min.css', __FILE__));
	wp_enqueue_style('snowt_admin_style', plugins_url('css/admin-style.css', __FILE__));
	wp_enqueue_style('wp-color-picker'); 
	wp_enqueue_script('snowt_admin_select2_script', plugins_url('js/select2.min.js', __FILE__), array('jquery'), false, true);
	wp_enqueue_script('snowt_admin_scripts', plugins_url('js/main-admin.js', __FILE__), array('jquery'), false, true);
	wp_enqueue_script('snowt_admin_scripts_color', plugins_url('js/main-admin-color.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}


// Add Settings Page
add_action('admin_menu', 'snowt_settings_page');
function snowt_settings_page(){
	add_options_page( 'Snow Time', 'Snow Time', 'manage_options', 'snow_time_settings', 'snow_time_settings_page_content' );
}

function snow_time_settings_page_content(){
	?>
	<div class="wrap snowt_wrap">
		<h1>Snow Time ❄ Settings</h1>

		<form action="options.php" method="POST">
			<?php
				settings_fields( 'snowt_option_group' );
				do_settings_sections( 'snowt_settings_page' );
				submit_button();
			?>
		</form>
	</div>
	<?php
}

// Register Settings
add_action('admin_init', 'snowt_register_settings');
function snowt_register_settings(){
	register_setting('snowt_option_group', 'snowt_options');

	add_settings_section('snowt_section_general_st', 'General Settings', '', 'snowt_settings_page' );

	add_settings_field('snowt_main_character', 'Character', 'snowt_main_character_fill', 'snowt_settings_page', 'snowt_section_general_st' );
	add_settings_field('snowt_main_color', 'Color', 'snowt_main_color_fill', 'snowt_settings_page', 'snowt_section_general_st' );
	add_settings_field('snowt_main_height', 'Snow Block Height (px)', 'snowt_main_height_fill', 'snowt_settings_page', 'snowt_section_general_st' );
	add_settings_field('snowt_main_speed', 'Snow Speed (second)', 'snowt_main_speed_fill', 'snowt_settings_page', 'snowt_section_general_st' );
	add_settings_field('snowt_main_frequency', 'Snow Frequency', 'snowt_main_frequency_fill', 'snowt_settings_page', 'snowt_section_general_st' );
	add_settings_field('snowt_main_small', 'The Smallest Item (font size px)', 'snowt_main_small_fill', 'snowt_settings_page', 'snowt_section_general_st' );
	add_settings_field('snowt_main_large', 'The Biggest Item (font size px)', 'snowt_main_large_fill', 'snowt_settings_page', 'snowt_section_general_st' );
	add_settings_field('snowt_main_rotation', 'Rotation (number)', 'snowt_main_rotation_fill', 'snowt_settings_page', 'snowt_section_general_st' );
	add_settings_field('snowt_main_blur', 'Blur', 'snowt_main_blur_fill', 'snowt_settings_page', 'snowt_section_general_st' );
	add_settings_field('snowt_main_wind', 'Wind (px)', 'snowt_main_wind_fill', 'snowt_settings_page', 'snowt_section_general_st' );
	add_settings_field('snowt_main_zindex', 'Z-index', 'snowt_main_zindex_fill', 'snowt_settings_page', 'snowt_section_general_st' );
	add_settings_field('snowt_main_exclude', 'Exclude Pages', 'snowt_main_exclude_fill', 'snowt_settings_page', 'snowt_section_general_st' );
}

function snowt_main_exclude_fill(){
	$val = get_option('snowt_options');
	$val = $val['exclude_pages'];
	$all_pages = get_pages();
	?>
	<select class="snowt_select2" name="snowt_options[exclude_pages][]" multiple="multiple">
	<?php foreach ($all_pages as $key_p => $value_p) { ?>
		<option value="<?php echo $value_p->ID ?>" <?php selected($val, $value_p->post_title); ?>><?php echo $value_p->post_title; ?></option>
	<?php } ?>
	</select>
	<br />
	<i>To use this settings, please download <a target="_blank" href="https://sellfy.com/p/B3J6/">PRO version</a></i>
	<?php
}

function snowt_main_color_fill(){
	$val = get_option('snowt_options');
	$val = $val['snowt_color'];
	?>
	<input type="text" name="snowt_options[snowt_color]" value="<?php echo esc_attr( $val ) ?>" /><br />
	<i>To use color settings, please download <a target="_blank" href="https://sellfy.com/p/B3J6/">PRO version</a></i>
	<?php
}

function snowt_main_character_fill(){
	$val = get_option('snowt_options');
	$val_one = $val['snowt_character'];
	$val_more = $val['snowt_character_more'];
	?>
	<select name="snowt_options[snowt_character]">
		<option value="❅" <?php selected($val_one, "❅"); ?>>❅</option>
		<option value="❄" <?php selected($val_one, "❄"); ?>>❄</option>
		<option value="❆" <?php selected($val_one, "❆"); ?>>❆</option>
		<option value="☃" <?php selected($val_one, "☃"); ?>>☃</option>
		<option value="⛄" <?php selected($val_one, "⛄"); ?>>⛄</option>
	</select>
	<i>determines the character or html entity to be replicated as a snowflake</i>
	<br />
	<br />
	<input id="more_character" type="checkbox" name="more_than_one">
	<label for="more_character">Use more than one character</label>
	<br />
	<br />
	<input type="text" name="snowt_options[snowt_character_more]" value="<?php echo esc_attr( $val_more ) ?>" disabled="disabled"/>
	<i>Example of using more than one character: ❄❅❆<br /> You can find it on <a target="_blank" href="https://www.copypastecharacter.com/symbols">https://www.copypastecharacter.com/symbols</a></i>
	<?php
}

function snowt_main_height_fill(){
	$val = get_option('snowt_options');
	$val = $val['snowt_height'];
	?>
	<input type="number" name="snowt_options[snowt_height]" value="<?php echo esc_attr( $val ) ?>" />
	<i>controls how far down the page the flakes will fall in pixels</i>
	<?php
}

function snowt_main_speed_fill(){
	$val = get_option('snowt_options');
	$val = $val['snowt_speed'];
	?>
	<input type="number" name="snowt_options[snowt_speed]" value="<?php echo esc_attr( $val ) ?>" />
	<i>controls how long it takes each flake to fall in seconds</i>
	<?php
}

function snowt_main_frequency_fill(){
	$val = get_option('snowt_options');
	$val = $val['snowt_frequency'];
	?>
	<input type="number" name="snowt_options[snowt_frequency]" value="<?php echo esc_attr( $val ) ?>" />
	<i>controls how frequently new flakes</i>
	<?php
}

function snowt_main_small_fill(){
	$val = get_option('snowt_options');
	$val = $val['snowt_small'];
	?>
	<input type="number" name="snowt_options[snowt_small]" value="<?php echo esc_attr( $val ) ?>" />
	<?php
}

function snowt_main_large_fill(){
	$val = get_option('snowt_options');
	$val = $val['snowt_large'];
	?>
	<input type="number" name="snowt_options[snowt_large]" value="<?php echo esc_attr( $val ) ?>" />
	<?php
}

function snowt_main_rotation_fill(){
	$val = get_option('snowt_options');
	$val = $val['snowt_rotation'];
	?>
	<input type="number" name="snowt_options[snowt_rotation]" value="<?php echo esc_attr( $val ) ?>" />
	<i>controls how much each flake will rotate in degrees while it falls</i>
	<?php
}

function snowt_main_blur_fill(){
	$val = get_option('snowt_options')['snowt_blur'];
	?>
	<input type="checkbox" name="snowt_options[snowt_blur]" value="1"<?php checked( 1 == $val ); ?> />
	<i>determines whether a blur effect is applied to smaller flakes</i>
	<?php
}

function snowt_main_wind_fill(){
	$val = get_option('snowt_options');
	$val = $val['snowt_wind'];
	?>
	<input type="number" name="snowt_options[snowt_wind]" value="<?php echo esc_attr( $val ) ?>" />
	<i>controls how far to the left each flake will drift in pixels</i>
	<?php
}

function snowt_main_zindex_fill(){
	$val = get_option('snowt_options');
	$val = $val['snowt_zindex'];
	?>
	<input type="number" name="snowt_options[snowt_zindex]" value="<?php echo esc_attr( $val ) ?>" />
	<i>sets the z-index CSS property for the snowflakes</i>
	<?php
}


// Set Option Default Value
add_action('admin_init', 'snowt_default_options_v');
function snowt_default_options_v(){

	echo get_option('snowt_options')['snowt_zindex'];

	$snowt_main_option = get_option('snowt_options');
	if(empty($snowt_main_option)){
		$snowt_main_option['snowt_character'] = '❄';
		$snowt_main_option['snowt_height'] = '200';
		$snowt_main_option['snowt_speed'] = '3';
		$snowt_main_option['snowt_frequency'] = '1';
		$snowt_main_option['snowt_small'] = '8';
		$snowt_main_option['snowt_large'] = '28';
		$snowt_main_option['snowt_rotation'] = '90';
		$snowt_main_option['snowt_blur'] = '1';
		$snowt_main_option['snowt_wind'] = '40';
		$snowt_main_option['snowt_zindex'] = '9999';
		update_option('snowt_options', $snowt_main_option);
	}
}

?>