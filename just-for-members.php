<?php
/*
Plugin Name: Just For Members
Description: When a non-member clicks on a page that requires membership, this plugin redirects the user to sign up or register page.
Version: 1.0
Author:Shiva


*/
if (!defined('ABSPATH'))
{
	exit;
}

require_once("jfmpagesettings.php");

add_action('admin_menu', 'jfm_option_menu');

/**** localization ****/
add_action('plugins_loaded','jfm_load_textdomain');

function jfm_load_textdomain()
{
	load_plugin_textdomain('just-for-members', false, dirname( plugin_basename( __FILE__ ) ).'/languages/');
}

function jfm_option_menu()
{

   add_menu_page(__('Just For Members', 'just-for-members'), __('Just For Members', 'just-for-members'), 'manage_options', 'justformembersettings', 'just_for_members_setting');
   add_submenu_page('justformembersettings', __('Just For Members','just-for-members'), __('Just For Members','just-for-members'), 'manage_options', 'justformembersettings', 'just_for_members_setting');
   add_submenu_page('justformembersettings', __('Just For Members','just-for-members'), __('Additional Settings','just-for-members'), 'manage_options', 'jfmadditionalsettings', 'just_for_members_additional_setting');   
}

//!!!start
$jfmdisableallfeature = get_option('jfmdisableallfeature');

if ('yes' == $jfmdisableallfeature)
{
	return;
}
//!!!end

function just_for_members_setting()
{
		global $wpdb;
				
		$m_jfmregisterpageurl = get_option('jfmregisterpageurl');

		if (isset($_POST['jfmsubmitnew']))
		{
			check_admin_referer( 'jfm_only_nonce' );
			if (isset($_POST['jfmregisterpageurl']))
			{
				$m_jfmregisterpageurl = esc_url($_POST['jfmregisterpageurl']);
			}
			else 
			{
				
			}

			update_option('jfmregisterpageurl',$m_jfmregisterpageurl);
			if (isset($_POST['jfmopenpageurl']))
			{
				//$jfmopenpageurl = sanitize_textarea_field($_POST['jfmopenpageurl']);

				$jfmopenpagechecktextarea = $_POST['jfmopenpageurl'];
				$jfmopenpagecheckarray = explode("\n", $jfmopenpagechecktextarea);

				$jfmopenpagefilteredarray = array();
				$jfmopenpageurl = '';
				
				if ((is_array($jfmopenpagecheckarray)) && (count($jfmopenpagecheckarray) >0))
				{
					foreach ($jfmopenpagecheckarray as $jfmopenpagechecksingle)
					{
						$jfmopenpagechecksingle = esc_url($jfmopenpagechecksingle);
						if (strlen($jfmopenpagechecksingle) > 0)
						{
							$jfmopenpagefilteredarray[] = $jfmopenpagechecksingle;
						}
					}
				}
				
				if ((is_array($jfmopenpagefilteredarray)) && (count($jfmopenpagefilteredarray) >0))
				{
					$jfmopenpageurl = implode("\n",$jfmopenpagefilteredarray);
				}
				
				if (strlen($jfmopenpageurl) == 0)
				{
					delete_option('jfm_saved_open_page_url',$jfmopenpageurl);
				}
				else 
				{
					update_option('jfm_saved_open_page_url',$jfmopenpageurl);
				}
			}

			$jfmMessageString =  __( 'Your changes has been saved.', 'just-for-members' );
			just_for_members_message($jfmMessageString);
		}
		echo "<br />";

		$saved_register_page_url = get_option('jfmregisterpageurl');
		?>

		<div style='margin:10px 5px;'>
		<div style='float:left;margin-right:10px;'>

		<img src='<?php echo plugins_url('/images/new.png', __FILE__);  ?>' style='width:30px;height:30px;'>
		
		</div> 
		<div style='padding-top:5px; font-size:22px;'>Just For Members Setting:</div>
		</div>
		<div style='clear:both'></div>		
			<div class="wrap">
				<div id="dashboard-widgets-wrap">
			    	<div id="dashboard-widgets" class="metabox-holder">
						<div id="post-body"  style="width:60%;">
							<div id="dashboard-widgets-main-content">
								<div class="postbox-container" style="width:98%;">
									<div class="postbox" >
										<h3 class='hndle' style='padding: 20px; !important'>
											<span>
											<?php 
												echo  __( 'Page Settings:', 'just-for-members' );
											?>
											</span>
										</h3>
								
										<div class="inside" style='padding-left:10px;'>
											<form id="jfmform" name="jfmform" action="" method="POST">
											<?php 
											wp_nonce_field('jfm_only_nonce');
											?>
											<table id="jfmtable" width="100%">
											<tr>
											<td width="30%" style="padding: 20px;">
											<?php 
												echo  __( 'Register Page URL:', 'just-for-members' );
												echo '<div style="color:#888 !important;"><i>';
												echo  __( '(or redirect url)', 'just-for-members' );
												echo '</i></div>';
											?>
											</td>
											<td width="70%" style="padding: 20px;">
											<input type="text" id="jfmregisterpageurl" name="jfmregisterpageurl"  style="width:500px;" size="70" value="<?php  echo esc_url($saved_register_page_url); ?>">
											</td>
											</tr>
										
											<tr style="margin-top:30px;">
											<td width="30%" style="padding: 20px;" valign="top">
											<?php 
												echo  __( 'Opened Page URLs:', 'just-for-members' );
											?>
											</td>
											<td width="70%" style="padding: 20px;">
											<?php 
											$urlsarray = get_option('jfm_saved_open_page_url'); 
											?>
											<textarea name="jfmopenpageurl" id="jfmopenpageurl" cols="70" rows="10" style="width:500px;"><?php echo sanitize_textarea_field($urlsarray); ?></textarea>
											<p><font color="Gray"><i><?php echo  __( 'Enter one URL per line please.', 'just-for-members' ); ?></i></p>
											<p><font color="Gray"><i><?php echo  __( 'These pages will opened for guest and guest will not be directed to register page.', 'just-for-members' ); ?></i></p>					
											</td>
											</tr>
											</table>
											<br />
											<input type="submit" id="jfmsubmitnew" name="jfmsubmitnew" value=" Submit " style="margin:1px 20px;">
											</form>
											<br />
										</div>
									</div>
								</div>
							</div>
						</div>
															
		    		</div>
				</div>
		</div>
		<div style="clear:both"></div>
		<br />
		<?php
}


function jfm_for_members()
{
	global  $user_ID, $post;
	
	if (is_front_page()) return;
	$current_page_id = get_the_ID();
	
	if (function_exists('jfm_is_register_page') && function_exists('jfm_is_activation_page') )
	{
		if ( jfm_is_register_page() || jfm_is_activation_page() )
		{
			return;
		}
	}

	if (function_exists('jfm_is_forum_archive'))
	{
		$jfm_is_forum_archive = jfm_is_forum_archive();
		if($jfm_is_forum_archive)
		{
			return;
		}
	}

	$current_url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$current_url = str_ireplace('http://','',$current_url);
	$current_url = str_ireplace('https://','',$current_url);
	$current_url = str_ireplace('ws://','',$current_url);
	$current_url = str_ireplace('www.','',$current_url);
	$saved_register_page_url = get_option('jfmregisterpageurl');

	$saved_register_page_url = str_ireplace('http://','',$saved_register_page_url);
	$saved_register_page_url = str_ireplace('https://','',$saved_register_page_url);
	$saved_register_page_url = str_ireplace('ws://','',$saved_register_page_url);
	$saved_register_page_url = str_ireplace('www.','',$saved_register_page_url);

	if (function_exists('is_jfm'))
	{
		if (is_jfm())
		{
			$is_jfm_current_forum = bbp_get_forum_id();  
		}
		else
		{
			$is_jfm_current_forum = '';
		}
	}
	else 
	{
		$is_jfm_current_forum = '';
	}
	
	if (function_exists('is_jfm'))
	{
		$jfmrestrictsjfmresssection = get_option('jfmrestrictsjfmresssection');
		if (!(empty($jfmrestrictsjfmresssection)))
		{
			if (is_jfm())
			{
		
			}
			else
			{
				return;
			}
		}
	}
	
	if (stripos($saved_register_page_url,$current_url) === false)
	{

	}
	else 
	{
		return;
	}
	
	$saved_open_page_option = get_option('jfm_saved_open_page_url');

	$jfm_saved_open_page_url = explode("\n", trim($saved_open_page_option));

	if ((is_array($jfm_saved_open_page_url)) && (count($jfm_saved_open_page_url) > 0))
	{
		$root_domain = get_option('siteurl');
		foreach ($jfm_saved_open_page_url as $jfm_saved_open_page_url_single)
		{
			$jfm_saved_open_page_url_single = trim($jfm_saved_open_page_url_single); 

			if (jfm_members_only_reserved_url($jfm_saved_open_page_url_single) == true)
			{
				continue;
			}
			
			$jfm_saved_open_page_url_single = jfm_members_only_pure_url($jfm_saved_open_page_url_single);
			
			if (stripos($current_url,$jfm_saved_open_page_url_single) === false)
			{

			}
			else 
			{
				return;
			}
		}
	}

	if ( is_user_logged_in() == false )
	{
		if (empty($saved_register_page_url))
		{
			$current_url = $_SERVER['REQUEST_URI'];
			$redirect_url = wp_login_url( );
			header( 'Location: ' . $redirect_url );
			die();			
		}
		else 
		{
			$saved_register_page_url = 'http://'.$saved_register_page_url;
			header( 'Location: ' . $saved_register_page_url );
			die();
		}
	}
}

function jfm_members_only_pure_url($current_url)
{
	if (empty($current_url)) return false;
	$current_url_array = parse_url($current_url);

	$current_url = str_ireplace('http://','',$current_url);
	$current_url = str_ireplace('https://','',$current_url);
	$current_url = str_ireplace('ws://','',$current_url);
		
	$current_url = str_ireplace('www.','',$current_url);
	$current_url = trim($current_url);
	return $current_url;
}

function jfm_members_only_reserved_url($url)
{
	$home_page = get_option('siteurl');
	$home_page = jfm_members_only_pure_url($home_page);
	$url = jfm_members_only_pure_url($url);
	if ($home_page == $url)
	{
		return true;
	}
	else
	{
		return false;
	}
} 
add_action('wp','jfm_for_members');


function just_for_members_message($p_message)
{

	echo "<div id='message' class='updated fade' style='line-height: 30px;margin-left: 0px;margin-top:10px; margin-bottom:10px;'>";

	echo $p_message;

	echo "</div>";

}

