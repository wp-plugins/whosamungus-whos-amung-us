<?php
/*  
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/

/*
Plugin Name: Who's Among Us
Plugin URI: http://www.miguelpinho.com/wordpress-plugins/whos-amung-us-wordpress-plugin/
Description: This is a widget that displays the very famous who's among us counter and helps you to manage it. To get your code visit them at <a href="http://whos.amung.us" TARGET="_blank">http://whos.amung.us</a>. This not an official plugin but it works.
Author: Miguel Pinho	
Version: 0.1
Author URI: http://miguelpinho.com/
*/

function show_whosamongus($before,$after)
{
	$string_to_echo = "";
	
	global $wpdb;
	$options = (array) get_option('widget_whosamongus');
	$title = $options['title'];
	$code = $options['code'];
	$standard_position = $options['standard-position'];
	$image_status = $options['image-status'];
	$small_widget_status = $options['small-widget-status'];
	$credit_status = $options['nocredit'];

	// Header
	if($title != "")
		$string_to_echo  =  ($before.$title.$after."\n");
	
	// Get Unique ID
	$unique_id = substr($code, 42, 12);
	
	// Standard Widget
	if($standard_position != "off")
		$string_to_echo .= '<script>var _wau = _wau || []; _wau.push(["tab", "'.$unique_id.'", "bmw", "'.$standard_position.'"]);(function() { var s=document.createElement("script"); s.async=true; s.src="http://widgets.amung.us/tab.js";document.getElementsByTagName("head")[0].appendChild(s);})();</script><br/>';

	// Image Widget
	if($image_status != "off")
		$string_to_echo .= '<a target="_blank" rel="nofollow" href="http://whos.amung.us/stats/'.$unique_id.'/"><img src="http://whos.amung.us/swidget/'.$unique_id.'.png" width="80" height="15" border="0" title="User Online" /></a><br/>';
	
	// Small Widget
	if($small_widget_status != "off")
		$string_to_echo .= '<script id="_waugqt">var _wau = _wau || []; _wau.push(["small", "'.$unique_id.'", "gqt"]);(function() { var s=document.createElement("script"); s.async=true; s.src="http://widgets.amung.us/small.js";document.getElementsByTagName("head")[0].appendChild(s);})();</script><br/>';
	
	// Give credit
	if($credit_status != "off")
		$string_to_echo .= "<small>Created by <a href='http://www.miguelpinho.com'>Miguel Pinho</a></small>";
	
	return $string_to_echo;
}

function widget_whosamongus_control() 
{
	// TODO on later versions: Maps -> http://whos.amung.us/maps/customize/
	
	$options = $newoptions = get_option('widget_whosamongus');
	
	if ( $_POST['whosamongus-submit'] ) 
	{
		$newoptions['title'] = strip_tags(stripslashes($_POST['whosamongus-title']));
		$newoptions['code'] = strip_tags(stripslashes($_POST['whosamongus-code']));
		$newoptions['standard-position'] = $_POST['whosamongus-standard-position'];
		$newoptions['image-status'] = $_POST['whosamongus-image-status'];
		$newoptions['small-widget-status'] = $_POST['whosamongus-small-widget-status'];
		
		if(isset($_POST['nocredit'])) $newoptions['nocredit'] = "off";
		else $newoptions['nocredit'] = "true";
		
		update_option('widget_whosamongus', $newoptions);
	}
?>			
	<div style="text-align:right">
		<small>Created by <a href='http://www.miguelpinho.com/wordpress-plugins/' TARGET="_blank">Miguel Pinho</a></small>
		<br/><br/>

		<label for="whosamongus-title" style="line-height:25px;display:block;">
			<?php _e('Title:', 'widgets'); ?> 	
			<input style="width: 200px;" type="text" id="whosamongus-title" name="whosamongus-title" value="<?php echo ($options['title'] ? wp_specialchars($options['title'], true) : ''); ?>" />
		</label>
		<br/>

		<?php _e('Code:', 'widgets'); ?><input style="width:150px;" type="text" id="whosamongus-code" name="whosamongus-code" value="<?php echo ($options['code'] ? wp_specialchars($options['code'], true) : '115'); ?>" /></label>
		<br/>
		<small>To get your code visit them at <a href="http://whos.amung.us" TARGET="_blank">http://whos.amung.us</a> copy the code in the yellow box and paste it here.</small>
		<br/><br/>
		
		<label for="whosamongus-standard-position" style="line-height:25px;display:block;">
			<?php _e('Standard Widget (Status & Position):', 'widgets'); ?>
				<select style="width: 200px;" id="whosamongus-standard-position" name="whosamongus-standard-position">
					<option value="off"<?php if ($options['standard-position'] == 'off') echo ' selected' ?>>Disabled</option>
					<option value="left-upper"<?php if ($options['standard-position'] == 'left-upper') echo ' selected' ?>>Left-Upper</option>
					<option value="left-middle"<?php if ($options['standard-position'] == 'left-middle') echo ' selected' ?>>Left-Center</option>
					<option value="left-lower"<?php if ($options['standard-position'] == 'left-lower') echo ' selected' ?>>Left-Bottom</option>
					<option value="bottom-left"<?php if ($options['standard-position'] == 'bottom-left') echo ' selected' ?>>Bottom-Left</option>
					<option value="bottom-center"<?php if ($options['standard-position'] == 'bottom-center') echo ' selected' ?>>Bottom-Center</option>
					<option value="bottom-right"<?php if ($options['standard-position'] == 'bottom-right') echo ' selected' ?>>Bottom-Right</option>
					<option value="right-upper"<?php if ($options['standard-position'] == 'right-upper') echo ' selected' ?>>Right-Upper</option>
					<option value="right-middle"<?php if ($options['standard-position'] == 'right-middle') echo ' selected' ?>>Right-Center</option>
					<option value="right-lower"<?php if ($options['standard-position'] == 'right-lower') echo ' selected' ?>>Right-Bottom</option>
				</select>
		</label>
		<br/>
		
		<label for="whosamongus-image-status" style="line-height:25px;display:block;">
			<?php _e('Image Widget Status:', 'widgets'); ?>
				<select style="width: 200px;" id="whosamongus-image-status" name="whosamongus-image-status">
					<option value="on"<?php if ($options['image-status'] == 'on') echo ' selected' ?>>Enabled</option>
					<option value="off"<?php if ($options['image-status'] == 'off') echo ' selected' ?>>Disabled</option>
				</select>
		</label>		
		<br/>
		
		<label for="whosamongus-small-widget-status" style="line-height:25px;display:block;">
			<?php _e('Small Widget Status:', 'widgets'); ?>
				<select style="width: 200px;" id="whosamongus-small-widget-status" name="whosamongus-small-widget-status">
					<option value="on"<?php if ($options['small-widget-status'] == 'on') echo ' selected' ?>>Enabled</option>
					<option value="off"<?php if ($options['small-widget-status'] == 'off') echo ' selected' ?>>Disabled</option>
				</select>
		</label>
		
		<small>
			<input type="checkbox" name="nocredit" value="off" <?php if($options['nocredit'] == "off") echo('checked="yes"'); ?>/> Don't give credit to the creator :( <br />
		</small>
	
		<input type="hidden" name="whosamongus-submit" id="whosamongus-submit" value="1" />
	</div>
<?php
}

function widget_whosamongus_init() {

	// Check for the required API functions
	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return;

	// This prints the widget
	function widget_whosamongus($args) 
	{
		extract($args);
		echo $before_widget;
		echo show_whosamongus($before_title, $after_title);
		echo $after_widget;
	}

	// Tell Dynamic Sidebar about our new widget and its control
	register_sidebar_widget(array('Who\'s Among Us', 'widgets'), 'widget_whosamongus');
	register_widget_control(array('Who\'s Among Us', 'widgets'), 'widget_whosamongus_control');
}


// Delay plugin execution to ensure Dynamic Sidebar has a chance to load first
add_action('widgets_init', 'widget_whosamongus_init');
?>