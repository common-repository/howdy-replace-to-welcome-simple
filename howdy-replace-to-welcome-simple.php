<?php 
    /*
    Plugin Name: Howdy AdminBar Settings
    Plugin URI: https://wordpress.org/plugins/howdy-replace-to-welcome-simple/
    Description: Plugin to replace howdy with Welcome and hide frontend admin bar 
    Author: B Damodar Reddy
    Version: 1.1
    Author URI: https://profiles.wordpress.org/damodar22
    */
 
function howdy_custom_admin_menu() {
    add_options_page(
        'Howdy AdminBar Settings',
        'Howdy AdminBar Settings',
        'manage_options',
        'howdy-plugin',
        'wporg_options_page'
    );
}
//

global $jal_db_version;
$jal_db_version = '1.0';

function jal_install() {
	global $wpdb;
	global $jal_db_version;

	$table_name = $wpdb->prefix . 'howdy';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE if not exists $table_name (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  howdy varchar(55) DEFAULT 'off' NOT NULL,
  adminbar varchar(55) DEFAULT 'off' NOT NULL,
   custom_msg varchar(200) DEFAULT 'Welcome' NOT NULL,
  UNIQUE KEY id (id)
) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'jal_db_version', $jal_db_version );
}


function jal_install_data() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'howdy';
	
	$wpdb->insert( 
		$table_name, 
		array( 
			'id' => '', 
			'howdy' => 'off', 
			'adminbar' => 'on' ,
            'custom_msg' => 'Welcome' 

		) 
	);
}
function my_plugin_remove_database() {
     global $wpdb;
     $table_name = $wpdb->prefix . "howdy";
     $sql = "DROP TABLE IF EXISTS $table_name;";
     $wpdb->query($sql);
     delete_option("my_plugin_db_version");
}
// Add settings link on plugin page
function your_plugin_settings_link($links) { 
  $settings_link = '<a href="options-general.php?page=howdy-plugin">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}
 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'your_plugin_settings_link' );

register_deactivation_hook( __FILE__, 'my_plugin_remove_database' );
register_activation_hook( __FILE__, 'jal_install' );
register_activation_hook( __FILE__, 'jal_install_data' );
//



		 global $wpdb;
		 $table_name = $wpdb->prefix . 'howdy';
		 $table2=$table_name;
		 $result = $wpdb->get_row( "SELECT * FROM $table_name");
         $howdy=$result->howdy;
         $adminbar=$result->adminbar;
         $howdy_id=$result->id;
		 $removehowdy=$result->custom_msg;
   update_option( 'od_removehowdytext', $removehowdy );
			 function replace_howdy( $wp_admin_top_bar ) {
    $wp_my_account=$wp_admin_top_bar->get_node('my-account');
	$howdytext = get_option('od_removehowdytext') ;
    $replacetitle = str_replace( 'Howdy', $howdytext, $wp_my_account->title );
    $wp_admin_top_bar->add_node( array(
        'id' => 'my-account',
        'title' => $replacetitle,
    ) );
     }
	function howdy_old($translated_text, $text, $domain) {
    $new_message = str_replace($custom_msg, 'Howdy', $text);
    return $new_message;
    }
		 if($howdy=="on")
		 {
			add_filter( 'admin_bar_menu', 'replace_howdy',25 ); 

		 }
		 else
		 {
			 add_filter('gettext', 'howdy_old', 10, 3);
		 }
		 if($adminbar=="on")
		 {
         add_filter( 'show_admin_bar', '__return_true' , 1000 );	
		 }
		 else
		 {
	     add_filter( 'show_admin_bar', '__return_false' );
		 }
		  //}
	 add_action( 'admin_menu', 'howdy_custom_admin_menu' );

//
function wporg_options_page() {
    ?>
    <div class="wrap">
        <h2>Howdy AdminBar Settings</h2>
        
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-36469106-1', 'auto');
  ga('send', 'pageview');
</script><hr />
         <?php
		 if(isset($_REQUEST['save']))
		   {   
			   $howdy_id=$_REQUEST['howdy_id'];
			   $howdy_new=$_REQUEST['howdy'];
			   $adminbar_new=$_REQUEST['adminbar'];
			   $custom_msg=$_REQUEST['custom_msg'];
				global $wpdb;
				$table_name = $wpdb->prefix . 'howdy';
				 $output=$wpdb->query("UPDATE $table_name SET howdy='$howdy_new',adminbar='$adminbar_new',custom_msg='$custom_msg' WHERE id='$howdy_id'");
				 if($output)
				 { 
				     ?><div class='success'>successfully updated<br><br /><h4>Please Wait....Reloading the page </h4><br /></div>                 <br /><meta http-equiv="refresh" content="2"><?php
				 }
				 else
				 {
					echo "<div class='error-msg'>Already updated (or) please Try again</div><br />"; 
				 }
	  	   }
		?>
        <style>
		.success{padding: 10px 50px;border: 2px solid green;border-radius: 10px;background-color: #fff;font-size: 16px;}
		.error-msg{padding: 10px 50px;border: 2px solid red;border-radius: 10px;background-color: #fff;font-size: 16px;}
		</style>
        <?php
		 global $wpdb;
		 $table_name = $wpdb->prefix . 'howdy';
         $result = $wpdb->get_row( "SELECT * FROM $table_name" );
		//  foreach ( $result as $print )   { 
         $howdy=$result->howdy;
         $adminbar=$result->adminbar;
         $howdy_id=$result->id;
         $custom_msg=$result->custom_msg;
		 			//  print_r($result); 


		 ?>

        <form action="#" method="post">
         <input type="hidden" name="howdy_id" value="<?php echo $howdy_id; ?>" />
        <input type="radio"  name="howdy" <?php if ($howdy=="on"){ ?> checked="checked" <?php } ?> value="on" />Howdy replace with <span  id="cstm-txt" ><input type="text" name="custom_msg" value="<?php echo $custom_msg; ?>" /></span>
        <input type="radio" name="howdy" <?php if ($howdy=="off"){ ?> checked="checked" <?php } ?> value="off" />No&nbsp;
        <hr />
        
        <strong>Admin Bar show on frontend:</strong> 
        <input type="radio" name="adminbar" <?php if ($adminbar=="on"){ ?> checked="checked" <?php } ?> value="on" />yes
        <input type="radio" name="adminbar" <?php if ($adminbar=="off"){ ?> checked="checked" <?php } ?> value="off" />No<hr />
   
        <input  type="submit" name="save" value="Save" />
        </form>
        <?php //} ?>
       
    </div>
   <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="BN3FXAQDJ4CNW">
<input type="image" style="width: 167px;margin-top: 34px;" src="https://scuderiacp.files.wordpress.com/2014/09/pp-donate1.png" border="0" name="submit" alt="PayPal – The safer, easier way to pay online.">
<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
</form>
    <?php
	
}
?>
