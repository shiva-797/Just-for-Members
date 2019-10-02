<?php
if(!defined('WPINC'))
{
	exit ('Please do not access our files directly.');
}

function just_for_members_additional_setting()
{
	global $wpdb;

	if (isset($_POST['jfmoptionsettingspanelsubmit']))
	{
		if (isset($_POST['jfmrestrictsjfmresssection']))
		{
			$m_jfmrestrictsjfmresssection = sanitize_text_field($_POST['jfmrestrictsjfmresssection']);
			update_option('jfmrestrictsjfmresssection',$m_jfmrestrictsjfmresssection);
		}
		else
		{
			delete_option('jfmrestrictsjfmresssection');
		}

		if (isset($_POST['jfmdisableallfeature']))
		{
			$jfmdisableallfeature = sanitize_text_field($_POST['jfmdisableallfeature']);
			update_option('jfmdisableallfeature',$jfmdisableallfeature);
		}
		else
		{
			delete_option('jfmdisableallfeature');
		}
		
		$jfmdisableallfeature = get_option('jfmdisableallfeature');
		
		$jfmMessageString =  __( 'Your changes has been saved.', 'just-for-members' );
		just_for_members_message($jfmMessageString);
	}
	echo "<br />";
	?>

<div style='margin:10px 5px;'>
<div style='float:left;margin-right:10px;'>
<img src='<?php echo get_option('siteurl');  ?>/wp-content/plugins/just-for-members-pro/images/new.png' style='width:30px;height:30px;'>
</div> 
<div style='padding-top:5px; font-size:22px;'>Just For Members Additional Settings:</div>
</div>
<div style='clear:both'></div>		
		<div class="wrap">
			<div id="dashboard-widgets-wrap">
			    <div id="dashboard-widgets" class="metabox-holder">
					<div id="post-body"  style="width:60%;">
						<div id="dashboard-widgets-main-content">
							<div class="postbox-container" style="width:90%;">
								<div class="postbox">
									<h3 class='hndle' style='padding: 20px; !important'>
									<span>
									<?php 
											echo  __( 'Additional Settings :', 'just-for-members' );
									?>
									</span>
									</h3>
								
									<div class="inside" style='padding-left:10px;'>
										<form id="jfmform" name="jfmform" action="" method="POST">
										<table id="jfmtable" width="100%">

										
										<tr>
										<td width="30%" style="padding: 30px 20px 20px 20px; " valign="top">
										<?php 
											echo  __( 'Only Protect My JFM Pages:', 'just-for-members' );
										?>
										</td>
										<td width="70%" style="padding: 20px;">
										<p>
										<?php
										$jfmrestrictsjfmresssection = get_option('jfmrestrictsjfmresssection');
										if (!(empty($jfmrestrictsjfmresssection)))
										{
											echo '<input type="checkbox" id="jfmrestrictsjfmresssection" name="jfmrestrictsjfmresssection"  style="" value="yes"  checked="checked"> All Other Sections On Your Site Will Be Opened to Guest ';
 
										}
										else 
										{
											echo '<input type="checkbox" id="jfmrestrictsjfmresssection" name="jfmrestrictsjfmresssection"  style="" value="yes" > All Other Sections On Your Site Will Be Opened to Guest ';
										}
										?>
										</p>
										<p><font color="Gray"><i>
										<?php 
										echo  __( '# If you enabled this option, "opened Page URLs" setting in ', 'just-for-members') ;
										echo "<a  style='color:#4e8c9e;' href='".get_option('siteurl')."/wp-admin/admin.php?page=justformembersettings' target='_blank'>Page Settings</a>";
										echo  __(' will be ignored', 'just-for-members' ); 
										?></i></p>
										</td>
										</tr>								
										
										<tr>
										<td width="30%" style="padding: 30px 20px 20px 20px; " valign="top">
										<?php 
											echo  __( 'Temporarily Turn Off All Featrures:', 'just-for-members' );
										?>
										</td>
										<td width="70%" style="padding: 20px;">
										<p>
										<?php
										$jfmdisableallfeature = get_option('jfmdisableallfeature');
										if (!(empty($jfmdisableallfeature)))
										{
											echo '<input type="checkbox" id="jfmdisableallfeature" name="jfmdisableallfeature"  style="" value="yes"  checked="checked"> Temporarily Turn Off All Featrures Of Just For Members ';
 
										}
										else 
										{
											echo '<input type="checkbox" id="jfmdisableallfeature" name="jfmdisableallfeature"  style="" value="yes" > Temporarily Turn Off All Featrures Of Just For Members ';
										}
										?>
										</p>
										<p><font color="Gray"><i>
										<?php 
										echo  __( '# If you enabled this option, all features of Just For Members will be disabled, you site will open to all users', 'just-for-members') ;
										?></i></p>
										</td>
										</tr>
																				
										</table>
										<br />
										<input type="submit" id="jfmoptionsettingspanelsubmit" name="jfmoptionsettingspanelsubmit" value=" Submit " style="margin:1px 20px;">
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


