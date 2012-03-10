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
Version: 0.2
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

		<?php _e('Code:', 'widgets'); ?><input style="width:150px;" type="text" id="whosamongus-code" name="whosamongus-code" value="<?php echo ($options['code'] ? wp_specialchars($options['code'], true) : ''); ?>" /></label>
		<br/>
		<small>To get your code visit them at <a href="http://whos.amung.us" TARGET="_blank">http://whos.amung.us</a> copy the code in the yellow box and paste it here.</small>
		<br/><br/>
		
		<?php
			$code = $options['code'];
			$unique_id = substr($code, 42, 12);// Get Unique ID
			
			if($unique_id != "")
			{
				?>
					<?php _e('Unique ID:', 'widgets'); ?><input style="width:150px;" type="text" id="whosamongus-unique-id" name="whosamongus-unique-id" value="<?php echo ($unique_id); ?>" readonly="readonly"/></label>
					<small>Keep a copy this Unique ID <strong>somewhere (else)</strong>!</small>
					<br/><br/>
				<?
			}
		?>
		

		
		
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





/* ADMIN MENU */
add_action('admin_menu', 'mt_add_pages');

// action function for above hook
function mt_add_pages() 
{
    // Add a new top-level menu (ill-advised):
    add_menu_page(__('Test Toplevel','menu-test'), __('Whos Amung Us','menu-test'), 'manage_options', 'whos-amung-us', 'my_plugin_options' );

    // Add a submenu to the custom top-level menu:
    //add_submenu_page('mt-top-level-handle', __('Test Sublevel','menu-test'), __('Wiget','menu-test'), 'manage_options', 'sub-page', 'mt_sublevel_page');
}


function my_plugin_options()
{
	if (!current_user_can('manage_options'))  
	{
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	
	
	
	
	global $wpdb;
	$options = (array) get_option('widget_whosamongus');
	$code = $options['code'];
	$unique_id = substr($code, 42, 12);// Get Unique ID


	?>
	
	
	<h2>
		<a target='_blank' href=''>Who's Amung Us - WP Plugin</a>
		<span style='font-size: 12px'>Version:0.2</span>
	</h2>
	

	
	
	<!-- START :: Donate  -->
	<div style="width:905px; ">
		<div style="float:left;background-color:white;padding: 10px 10px 10px 10px;margin-right:15px;border: 1px solid #ddd;height:150px; background-color:#CEF6CE">
			<div style="width:423px;height:130px;">
				<h3>About this Plugin</h3>
				<em>This plugin will allow you to manage your whos.amung.us stats very easily. Don't forget to setup the widget!</em>
				
				<em>This plugin was developed by <a href="http://www.miguelpinho.com" target="_blank"><strong>Miguel Pinho</strong></a>.</em><br/><br/>
				
				Twitter: <a href="https://twitter.com/megafu" class="twitter-follow-button" data-show-count="false" data-show-screen-name="false">Follow @megafu</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				<br/>
				
				Linkedin:
				<script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
				<script type="IN/MemberProfile" data-id="http://www.linkedin.com/in/miguelpinho" data-format="click" data-text="Miguel Pinho" data-related="false"></script>
			</div>
		</div>

		<div style="float:left;background-color:white;padding:10px;border:1px solid #ddd;height:150px; background-color:#F5F6CE">
			<div style="width:423px;height:130px;">
				<h3><img src="http://assets.amung.us/images/pro/hooks/map.png" class="imgvam" /> Do you like these? Go PRO!</h3>
				<em>With a whos.amung.us Pro account, you are in control. Everything is customizable. Insert your own logo, re-arrange dashboard stats anyway you like, choose colors for each stat. The possibilities are endless!</em><br/><br/>
				<a href="http://whos.amung.us/pro/">Get more stats!</a><br/>
		    	<a href="http://whos.amung.us/pro/">Upgrade your map!</a>
			</div>
		</div>

	<div style="clear:both;">
		
	<br/>		

	<!-- END :: Donate  -->
	
	
	

	<div id="poststuff" class="metabox-holder has-right-sidebar" style="margin-top:10px">
		<div id="side-info-column" class="inner-sidebar">
	    	<div id="side-sortables" class="meta-box-sortables">

				<!-- SOON
				<div id="more_plugins" class="postbox">
					<div class="handlediv"><br /></div>
					<h3 class='hndle'><span>More Great WP Plugins</span></h3>
					<div class="inside">
						<ul>
							<li><a class="rsswidget" href="">Easy to Install Whos.Among.Us Stats</a><br/>Delivers Real-time stats about your visitors</li>
						</ul>
					</div>
				</div>
				-->
				
				<?php
				if($unique_id != "")
				{
					?>
						<div id="more_stats" class="postbox">
							<div class="handlediv"><br /></div>
							<h3 class='hndle'><span>Your Unique ID</span></h3>
							<div class="inside">
								<?php _e('Unique ID:', 'widgets'); ?><input style="width:150px;" type="text" id="whosamongus-unique-id" name="whosamongus-unique-id" value="<?php echo ($unique_id); ?>" readonly="readonly"/></label>
								<br/>
								<small>Keep a copy this Unique ID <strong>somewhere (else)</strong>!</small>
							</div>
						</div>				
						<div id="more_stats" class="postbox">
							<div class="handlediv"><br /></div>
							<h3 class='hndle'><span>More Whos.Amung.Us Stats</span></h3>
							<div class="inside">
								<ul>
									<li><a class="rsswidget" target="_blank" href="http://whos.amung.us/stats/<?php echo($unique_id); ?>/">View Official Website</a><br/>View the more of your stats online</li>
									<li><a class="rsswidget" target="_blank" href="http://whos.amung.us/stats/readers/<?php echo($unique_id); ?>/">Users Pages</a><br/>A list of the most popular pages, with the number of people on each page.</li>
								</ul>
							</div>
						</div>
					<?php
				}
				?>
			</div>
		</div>

		<?php
			if(isset($_GET['period']))
			{
				if($_GET['period'] == 'daily' OR $_GET['period'] == 'monthly' OR $_GET['period'] == 'yearly')
				{
					$period = $_GET['period'];
				}
				else $period = "daily";
			}
			else $period = "daily";
		
	
			if($unique_id != "")
			{
				?>

				<div id="post-body">
				    <div id="post-body-content" class="has-sidebar-content">
						<h3>Timeline Stats</h3><br/>
						<div class="tar mediumfont bold" style="margin-top:-20px">
					    	<img src="http://assets.amung.us/images/pro/hooks/pie.png" class="imgvam" />
					    	Change Period:
							<a href="admin.php?page=whos-amung-us&period=daily">Daily </a> | 
							<a href="admin.php?page=whos-amung-us&period=monthly">Monthly </a> | 
							<a href="admin.php?page=whos-amung-us&period=yearly">Yearly </a>
					    </div>
					
					    <div>
					        <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" 
					            codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" 
					            width="900" height="130" id="timeline" align="middle">
					            <param name="allowScriptAccess" value="always" />
								<param name="allowNetworking" value="all" />
					            <param name="allowFullScreen" value="false" />
					            <param name="movie" value="http://whos.amung.us/flash/timeline.swf?data=http://whos.amung.us/stats/graph_data/<?php echo($unique_id);?>/<?php echo($period);?>/timeline/" />
					            <param name="quality" value="high" />
					            <param name="bgcolor" value="#ffffff" />   
					            <param name="wmode" value="transparent" /> 
					            <embed src="http://whos.amung.us/flash/timeline.swf?data=http://whos.amung.us/stats/graph_data/<?php echo($unique_id);?>/<?php echo($period);?>/timeline/" 
					            quality="high" bgcolor="#ffffff" width="600" height="130" 
					            name="timeline" align="middle" allowScriptAccess="always" allowNetworking="all" allowFullScreen="false" wmode="transparent"
					            type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
					        </object>
					    </div>
					</div>
		
					<!-- MAP -->
					<h3>Live Map</h3>
					<div id="maps_data">
				        <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" 
				            codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" 
				            width="468" height="234" id="dashmap" align="middle">
				            <param name="allowScriptAccess" value="always" />
							<param name="allowNetworking" value="all" />
				            <param name="allowFullScreen" value="false" />
				            <param name="movie" value="http://whos.amung.us/flash/dashmap.swf" />
				            <param name="quality" value="high" />
				            <param name="bgcolor" value="#ffffff" />
				            <param name="flashvars" value="wausitehash=<?php echo($unique_id);?>&amp;pin=star-red-dashmap&amp;link=yes&amp;map=dashmap.png" />  
				            <embed src="http://whos.amung.us/flash/dashmap.swf" quality="high" bgcolor="#ffffff" 
				            flashvars="wausitehash=<?php echo($unique_id);?>&amp;pin=star-red-dashmap&amp;link=yes&amp;map=dashmap.png"
				 			width="600" height="300" name="dashmap" align="middle" allowScriptAccess="always" allowFullScreen="false" 
				            allowNetworking="all" type="application/x-shockwave-flash" 
							pluginspage="http://www.macromedia.com/go/getflashplayer" />
				        </object>
				    </div>
				</div>

				<?php
			}
			else
			{
				?>
					<div id="post-body">
					    <div id="post-body-content" class="has-sidebar-content">
						First you must setup the "widget"!
						</div>
					</div>
				<?
			}
		?>
		</div>
		</div>
		</div>
		<?php
}


?>