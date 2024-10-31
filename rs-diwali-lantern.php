<?php
/**
 * @package rs-diwali-lantern
 * @version 2.3
 */
/*
Plugin Name: RS Diwali Lantern
Plugin URI: https://wordpress.org/plugins/rs-diwali-lantern/
Description: A Beautiful Diwali Lantern for your website with lanterns to choose and settings for it. A perfect plugin to celebrate the festive season.You can even upload your own favourite image like your little mascot or gif or even a nice juicy tomato image looks perfect...
Author: Rashmi Sonawane
Version: 2.3
Author URI: https://rashmisworld.wordpress.com
*/

register_activation_hook( __FILE__, 'rsdl_plugin_activation' );

function rsdl_plugin_activation()
{
	 flush_rewrite_rules();
	 
	 //saving default options
	  $default = array(
        'rsdl_text_field_0'     => '20',
        'rsdl_radio_field_2'   => '1',
        'rsdl_swaystyle_field'   => 'sway2',
        'rsdl_swayspeed_field'   => '2',
        'rsdl_url_text_field'   => '',
       // 'rsdl_custom_image'   => '',
    );
    update_option( 'rsdl_settings', $default );
}


// plugin uninstallation
register_uninstall_hook( __FILE__, 'rsdl_uninstall' );
function rsdl_uninstall() {
    delete_option( 'rsdl_settings' );
}


//Register plugin stylesheet
add_action('wp_enqueue_scripts','rs_diwali_lanternstyle');

function rs_diwali_lanternstyle(){
	wp_register_style('rsdiwalilantern',plugins_url( 'css/rs_diwali_style.css', __FILE__ ));
	wp_enqueue_style('rsdiwalilantern');

}

function media_uploader_enqueue() {
	wp_enqueue_media();
	wp_register_script('media-uploader', plugins_url('js/admin.js' , __FILE__ ), array('jquery'));
	wp_enqueue_script('media-uploader');
}
add_action('admin_enqueue_scripts', 'media_uploader_enqueue');

add_action( 'admin_menu', 'rsdl_add_admin_menu' );
add_action( 'admin_init', 'rsdl_settings_init' );

function rsdl_add_admin_menu(  ) { 
	
	add_menu_page( 'RS Diwali Lantern', 'RS Diwali Lantern', 'manage_options', 'rsdiwalilantern', 'rsdl_options_page_function','dashicons-buddicons-tracking' );
}

function rsdl_options_page_function() 
{ 
?><form action='options.php' method='post'>
		<h2>Welcome to RS Diwali Lantern Plugin settings</h2><?php
				settings_fields( 'rsdl_option_group' );
				do_settings_sections( 'rsdl_option_group' );
				submit_button();
			?></form><?php

}


function rsdl_settings_init()
{ 
	register_setting( 'rsdl_option_group', 'rsdl_settings' );

	add_settings_section(
		'rsdl_pluginPage_section', 
		__( '', 'rsdltextdomain' ), 
		'rsdl_settings_section_callback', 
		'rsdl_option_group'
	);

	add_settings_field( 
		'rsdl_text_field_0', 
		__( 'Height of lantern string<br />e.g 20', 'rsdltextdomain' ), 
		'rsdl_text_field_0_render', 
		'rsdl_option_group', 
		'rsdl_pluginPage_section' 
	);

	add_settings_field( 
		'rsdl_radio_field_2', 
		__( 'Select your favourite lantern', 'rsdltextdomain' ), 
		'rsdl_radio_field_2_render', 
		'rsdl_option_group', 
		'rsdl_pluginPage_section' 
	);
	
	add_settings_field( 
		'rsdl_url_text_field', 
		__( 'URL link for lantern', 'rsdltextdomain' ), 
		'rsdl_urllink_render', 
		'rsdl_option_group', 
		'rsdl_pluginPage_section' 
	);	
	
	$args_uploadlantern     = array (
            'class'      => 'uploadlanterdiv'
        );
	
	add_settings_field( 
		'rsdl_upload_field_2_1', 
		__( 'Upload your favourite lantern', 'rsdltextdomain' ), 
		'rsdl_upload_field_2_1_render', 
		'rsdl_option_group', 
		'rsdl_pluginPage_section',
		$args_uploadlantern
	);
	
	add_settings_field( 
		'rsdl_swaystyle_field', 
		__( 'Select Swaying Style', 'rsdltextdomain' ), 
		'rsdl_swaystyle_render', 
		'rsdl_option_group', 
		'rsdl_pluginPage_section' 
	);
	
	add_settings_field( 
		'rsdl_swayspeed_field', 
		__( 'Enter Swaying Speed (Keep empty for default speed)<br />Max recommended seconds :12', 'rsdltextdomain' ), 
		'rsdl_swayspeed_render', 
		'rsdl_option_group', 
		'rsdl_pluginPage_section' 
	);
}

function rsdl_text_field_0_render()
{ 
	$options = get_option( 'rsdl_settings' );
	?><p><input type='text' required name='rsdl_settings[rsdl_text_field_0]' value='<?php echo $options['rsdl_text_field_0']; ?>'> px</p>
	<?php
}

function rsdl_urllink_render()
{ 
	$options = get_option( 'rsdl_settings' );
	?><p><input type='text' name='rsdl_settings[rsdl_url_text_field]' value='<?php echo $options['rsdl_url_text_field']; ?>'></p>
	<?php
	
}


function rsdl_swayspeed_render()
{ 
	$options = get_option( 'rsdl_settings' );
	?><p><input type='text' required placeholder="16" required name='rsdl_settings[rsdl_swayspeed_field]' value='<?php echo $options['rsdl_swayspeed_field']; ?>'> seconds</p>
	<?php
}



function rsdl_radio_field_2_render()
{ 
	$options = get_option( 'rsdl_settings' );
	?><input type='radio' name='rsdl_settings[rsdl_radio_field_2]'<?php checked( $options['rsdl_radio_field_2'], 1 ); ?>value='1'>Lantern 1
	<input type='radio' name='rsdl_settings[rsdl_radio_field_2]'<?php checked( $options['rsdl_radio_field_2'], 2 ); ?>value='2'>Lantern 2
	<input type='radio' name='rsdl_settings[rsdl_radio_field_2]'<?php checked( $options['rsdl_radio_field_2'], 3 ); ?>value='3'>Lantern 3
	<input type='radio' name='rsdl_settings[rsdl_radio_field_2]'<?php checked( $options['rsdl_radio_field_2'], 4 ); ?>value='4'>My Lantern
	<?php
}


function rsdl_settings_section_callback(  ) { 
	echo __( 'Select the lantern you want to display on your website and to adjust the height of the lantern string insert the appropriate pixel value', 'rsdltextdomain' );
}

function rsdl_upload_field_2_1_render()
{
	$options = get_option( 'rsdl_settings' );
	rsdl_image_uploader( 'rsdl_custom_image', $width = 115, $height = 115 );
}

function rsdl_image_uploader( $name, $width, $height ) 
{

    // Set variables
    $options = get_option( 'rsdl_settings' );
    $default_image = plugins_url('images/no-image.png', __FILE__);

    if ( !empty( $options[$name] ) ) {
        $image_attributes = wp_get_attachment_image_src( $options[$name], array( $width, $height ) );
        $src = $image_attributes[0];
        $value = $options[$name];
    } else {
        $src = $default_image;
        $value = '';
    }

   

    // Print HTML field
    echo '
        <div class="upload rsdlupload">
            <img data-src="' . $default_image . '" src="' . $src . '" width="' . $width . 'px" height="' . $height . 'px" />
            <div>
                <input type="hidden" name="rsdl_settings[' . $name . ']" id="rsdl_settings[' . $name . ']" value="' . $value . '" />
                <button type="submit" class="upload_image_button button">Upload My Lantern</button>
                <button type="submit" class="remove_image_button button">&times;</button>
            </div>
        </div>
    ';
}

function rsdl_swaystyle_render()
{
	$options = get_option( 'rsdl_settings' );
	?><input type='radio' name='rsdl_settings[rsdl_swaystyle_field]'<?php checked( $options['rsdl_swaystyle_field'], 'sway1' ); ?> value='sway1' default>Sway 1
	<input type='radio' name='rsdl_settings[rsdl_swaystyle_field]'<?php checked( $options['rsdl_swaystyle_field'], 'sway2' ); ?> value='sway2'>Sway 2
	<input type='radio' name='rsdl_settings[rsdl_swaystyle_field]'<?php checked( $options['rsdl_swaystyle_field'], 'swayno' ); ?> value='swayno'>No Sway
	
	<?php
}

$options = get_option( 'rsdl_settings' );

function rs_diwali_plugin()
{
	$rsdl_plugin_options = get_option('rsdl_settings');
	$radiofields= $rsdl_plugin_options['rsdl_radio_field_2']; 
	$stringtoadjust= $rsdl_plugin_options['rsdl_text_field_0']; 
	$urllink= $rsdl_plugin_options['rsdl_url_text_field']; 
	
	
	
	if(isset($rsdl_plugin_options['rsdl_custom_image']))
	{
	
	$rsdlcustomlanternid= $rsdl_plugin_options['rsdl_custom_image']; 
	$rsdlcustomlanterurl=wp_get_attachment_url($rsdlcustomlanternid);
	
	
	if($rsdlcustomlanterurl)
	{
		
	}
	else
	{
		$rsdlcustomlanterurl=plugins_url('images/no-image.png', __FILE__);
	}
	
	
	}
	$swaystylefield= $rsdl_plugin_options['rsdl_swaystyle_field']; 
	$swayspeed= $rsdl_plugin_options['rsdl_swayspeed_field'];
	
	if($swayspeed > 0)
	{
		if($swaystylefield=='sway1')
		{
		$userswayspeed='animation: sway1 '.$swayspeed.'s infinite;';
		}
		
		if($swaystylefield=='sway2')
		{
		$userswayspeed='-webkit-animation: swinging '.$swayspeed.'s ease-in-out forwards infinite;animation: swinging '.$swayspeed.'s ease-in-out forwards infinite;';
		}
		if($swaystylefield=='swayno')
		{
			$userswayspeed='';
		}
		
		$defaultspeedstyle='';
	}
	else
	{
		$userswayspeed='';
		
		if($swaystylefield=='sway1')
		{
		$defaultspeedstyle='defaultspeedstyle1';
		}
		
		if($swaystylefield=='sway2')
		{
			$defaultspeedstyle='defaultspeedstyle2';
		}
		
		if($swaystylefield=='swayno')
		{
			$userswayspeed='';
		}
	}
	
?><div class="rs_diwali_div <?php echo $swaystylefield.' '.$defaultspeedstyle; ?>" style="top:<?php echo $stringtoadjust.'px;'.$userswayspeed; ?>">
		<?php
				
		if($radiofields==1)
		{
			if($urllink)
			{
				?>
				<a href="<?php echo $urllink; ?>">
				<?php
			}
			?><img class="rsdl_img" src="<?php echo plugins_url('images/lantern2.gif',__FILE__); ?>"><?php
			
			if($urllink)
			{
				?>
				</a>
				<?php
			}
		
			
		}
		if($radiofields==2)
		{
			if($urllink)
			{
				?>
				<a href="<?php echo $urllink; ?>">
				<?php
			}
			
			
			?><img class="rsdl_img" src="<?php echo plugins_url('images/diwali_lantern1.gif',__FILE__); ?>"><?php
			
			if($urllink)
			{
				?>
				</a>
				<?php
			}
			
		}
		if($radiofields==3)
		{
			if($urllink)
			{
				?>
				<a href="<?php echo $urllink; ?>">
				<?php
			}
			
			?><img class="rsdl_img" src="<?php echo plugins_url('images/lantern3.gif',__FILE__); ?>"><?php
			
			if($urllink)
			{
				?>
				</a>
				<?php
			}
			
		}
		
		if($radiofields==4)
		{
			if($urllink)
			{
				?>
				<a href="<?php echo $urllink; ?>">
				<?php
			}
			
			?><img class="rsdl_img" src="<?php echo $rsdlcustomlanterurl; ?>"><?php
			
			if($urllink)
			{
				?>
				</a>
				<?php
			}
			
		}
		?></div><?php
}

add_action('wp_footer', 'rs_diwali_plugin');
