<?php
/**
*
* @package Points MOD
* @author Kamahl kamahl19@gmail.com
* @version 1.0.3
* @copyright (c) 2012 Kamahl www.phpbb3hacks.com
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/
define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);
include($phpbb_root_path . 'includes/functions_privmsgs.' . $phpEx);
include_once($phpbb_root_path . 'includes/functions_points.' . $phpEx);

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup('mods/points');   

if (!$config['points_enable'])
{
  trigger_error($user->lang['POINTS_DISABLED']);
}   

if ( !$user->data['is_registered'] )
{
	if ( $user->data['is_bot'] )
	{
		redirect(append_sid("{$phpbb_root_path}index.$phpEx"));
	}
	login_box('');
}

$mode	= request_var('mode', '');

$template->assign_block_vars('navlinks', array(
	'U_VIEW_FORUM'	=> append_sid("{$phpbb_root_path}points.$phpEx"),
	'FORUM_NAME'	=> $config['points_name'],
));

switch( $mode ) 
{
	case 'transfer_points':
	  
	  if ( !$config['transfer_enable'] )
		{
			trigger_error('TRANSFER_DISABLED');
		}

		if ( !$auth->acl_get('u_use_transfer') )
		{
			trigger_error('NOT_AUTHORISED');
		}
	
    $user_id = request_var('u', 0);
    $post_id = request_var('post_id', 0);
    $submit	= (isset($_POST['submit'])) ? true : false;
    
    if ($user_id)
    {
      $sql_array = array(
				'SELECT'    => 'u.username',
				'FROM'      => array(
					USERS_TABLE => 'u',
				),
				'WHERE'		=> 'u.user_id = ' . $user_id,
			);
			$sql = $db->sql_build_query('SELECT', $sql_array);
			$result = $db->sql_query($sql);
			$username = $db->sql_fetchfield('username');  
    }
    else
    {
      $username = '';
    }
    
		$page_title = sprintf($user->lang['TRANSFER_POINTS'], $config['points_name']);
    
		$template->assign_block_vars('navlinks', array(
			'U_VIEW_FORUM'	=> append_sid("{$phpbb_root_path}points.$phpEx", "mode=transfer_points"),
			'FORUM_NAME'	=> $page_title,
		)); 
		      
		if ($submit) 
		{
			$amount 		      = request_var('amount', 0);
			$comment	        = request_var('comment', '', true);
			$username 	      = request_var('username', '', true);
			$username_clean   = utf8_clean_string($username);
			
			if (!$username)
  		{
  			trigger_error('NO_USER_SELECTED');
  		}
  		
  		if (!$amount || !is_numeric($amount))
  		{
  			trigger_error(sprintf($user->lang['NO_AMOUNT_SELECTED'], $config['points_name']));
  		}
  		
  		if ( $user->data['user_points'] < $amount )
			{
				$message = sprintf($user->lang['TRANSFER_NOT_ENOUGH_POINTS'], $config['points_name']) . '<br /><br /><a href="' . append_sid("{$phpbb_root_path}points.$phpEx", "mode=transfer_points") . '">&laquo; ' . $user->lang['BACK_TO_PREV'] . '</a>';
				trigger_error($message);
			}

			$sql_array = array(
				'SELECT'    => 'u.user_id, u.user_allow_pm',
				'FROM'      => array(
					USERS_TABLE => 'u',
				),
				'WHERE'		=> 'username_clean = "' . $db->sql_escape($username_clean) . '"',
			);
			$sql = $db->sql_build_query('SELECT', $sql_array);
			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);
			
			if (!$db->sql_affectedrows())
      {
				trigger_error('USERNAME_NOT_EXIST');
      }

			add_points($row['user_id'], $amount);

			remove_points($user->data['user_id'], $amount);

			if ( $config['transfer_pm_enable'] && $row['user_allow_pm'] )
			{
      	$my_subject	= $user->lang['TRANSFER_PM_SUBJECT'];
      	$message	= ($comment) ? sprintf($user->lang['TRANSFER_PM_BODY_COMMENT'], $amount, $config['points_name'], utf8_normalize_nfc($comment)) : sprintf($user->lang['TRANSFER_PM_BODY'], $amount, $config['points_name'], utf8_normalize_nfc($comment));
      
      	$poll = $uid = $bitfield = $options = '';
      	generate_text_for_storage($my_subject, $uid, $bitfield, $options, false, false, false);
      	generate_text_for_storage($message, $uid, $bitfield, $options, true, true, true);
      	
      	$data = array(
      		'address_list'		=> array ('u' => array($row['user_id'] => 'to')),
      		'from_user_id'		=> $user->data['user_id'],
      		'from_username'		=> $user->data['username'],
      		'icon_id'			=> 0,
      		'from_user_ip'		=> $user->data['user_ip'],
      		'enable_bbcode'		=> true,
      		'enable_smilies'	=> true,
      		'enable_urls'		=> true,
      		'enable_sig'		=> true,
      		'message'			=> $message,
      		'bbcode_bitfield'	=> $bitfield,
      		'bbcode_uid'		=> $uid,
      	);
      	submit_pm('post', $my_subject, $data, false);
			}
			
			if ($post_id)
			{        
        $message = $user->lang['TRANSFER_SUCCESS'] . '<br /><br /><a href="' . append_sid("{$phpbb_root_path}viewtopic.$phpEx", "p=".$post_id."#p".$post_id) . '">&laquo; ' . $user->lang['POINTS_RETURN_POST'] . '</a>';
      }
      else
      {
        $message = $user->lang['TRANSFER_SUCCESS'] . '<br /><br /><a href="' . append_sid("{$phpbb_root_path}points.$phpEx", "mode=transfer_points") . '">&laquo; ' . $user->lang['POINTS_RETURN_TRANSFER'] . '</a>';
      }
			trigger_error($message);
		}

		$template->assign_vars(array(
			'S_CAN_ADD_COMMENT'		=> ( $config['comments_enable'] && $auth->acl_get('u_sendpm') ) ? true : false,
			'S_TRANSFER_POINTS'   => true,    
			'S_TRANSFER_USERNAME' => ($username) ? $username : '',
			'U_ACTION'				    => append_sid("{$phpbb_root_path}points.$phpEx", "mode=".$mode."&amp;u=" . $user_id . "&amp;post_id=".$post_id),
		));
		
	 break;

	case 'change_points':
	
	  if ( !( $auth->acl_get('a_') || $auth->acl_get('m_chg_points') ) )
		{
      trigger_error('NOT_AUTHORISED'); 
    }
	
    $user_id = request_var('u', 0);
    $post_id = request_var('post_id', 0);
    $submit	= (isset($_POST['submit'])) ? true : false;
    
    if ($user_id)
    {
      $sql_array = array(
				'SELECT'    => 'u.username, u.user_points',
				'FROM'      => array(
					USERS_TABLE => 'u',
				),
				'WHERE'		=> 'u.user_id = ' . $user_id,
			);
			$sql = $db->sql_build_query('SELECT', $sql_array);
			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);  
    }
    else
    {
      $row['username'] = '';
      $row['user_points'] = '';
    }
    
    $page_title = sprintf($user->lang['CHANGE_POINTS'], $config['points_name']);
    
		$template->assign_block_vars('navlinks', array(
			'U_VIEW_FORUM'	=> append_sid("{$phpbb_root_path}points.$phpEx", "mode=change_points"),
			'FORUM_NAME'	=> $page_title,
		));  
		
		if ($submit) 
		{
			$set_points       = request_var('points', 0);
			$username 	      = request_var('username', '', true);
			$username_clean   = utf8_clean_string($username);
			
			if (!$username)
  		{
  			trigger_error('NO_USER_SELECTED');
  		}
  		
  		if (!is_numeric($set_points))
  		{
  			trigger_error(sprintf($user->lang['NO_AMOUNT_SELECTED'], $config['points_name']));
  		}
  		
			$sql_array = array(
				'SELECT'    => 'u.user_id',
				'FROM'      => array(
					USERS_TABLE => 'u',
				),
				'WHERE'		=> 'username_clean = "' . $db->sql_escape($username_clean) . '"',
			);
			$sql = $db->sql_build_query('SELECT', $sql_array);
			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);
			
			if (!$db->sql_affectedrows())
      {
				trigger_error('USERNAME_NOT_EXIST');
      }

			set_points($row['user_id'], $set_points);

			if ($post_id)
			{        
        $message = $user->lang['CHANGE_SUCCESS'] . '<br /><br /><a href="' . append_sid("{$phpbb_root_path}viewtopic.$phpEx", "p=".$post_id."#p".$post_id) . '">&laquo; ' . $user->lang['POINTS_RETURN_POST'] . '</a>';
      }
      else
      {
        $message = $user->lang['CHANGE_SUCCESS'] . '<br /><br /><a href="' . append_sid("{$phpbb_root_path}points.$phpEx", "mode=change_points") . '">&laquo; ' . $user->lang['POINTS_RETURN_TRANSFER'] . '</a>';
      }
			trigger_error($message);
		}
    
		$template->assign_vars(array(
			'S_CHANGE_USERNAME'            => ($row['username']) ? $row['username'] : '',
			'S_CHANGE_USERPOINTS'          => ($row['user_points']) ? $row['user_points'] : '',
			'S_CHANGE_POINTS'              => true,
			'U_ACTION'				             => append_sid("{$phpbb_root_path}points.$phpEx", "mode=".$mode."&amp;u=" . $user_id . "&amp;post_id=".$post_id),
		));
		
	 break;

	default:
	
	  $page_title = sprintf($user->lang['POINTS_MAIN'], $config['points_name']);
	
  	$template->assign_vars(array(
  		'S_POINTS_MAIN' => true,
  		'L_MAIN_HELLO'  => sprintf($user->lang['MAIN_HELLO'], $user->data['username']),
  		'L_MAIN_TEXT'   => sprintf($user->lang['MAIN_TEXT'], $user->data['user_points'], $config['points_name'], $config['pertopic'], $config['perpost'], $config['perword']),
  	));

}

$template->assign_vars(array(
	'S_POINTS_TITLE'       => $page_title,
	'L_TRANSFER_POINTS'    => sprintf($user->lang['TRANSFER_POINTS'], $config['points_name']),
	'L_CHANGE_POINTS'      => sprintf($user->lang['CHANGE_POINTS'], $config['points_name']),
	'U_TRANSFER_POINTS'    => ( $auth->acl_get('u_use_transfer') && $config['transfer_enable'] ) ? append_sid("{$phpbb_root_path}points.$phpEx", "mode=transfer_points") : '',
	'U_CHANGE_POINTS'      => ( $auth->acl_get('m_chg_points') ) ? append_sid("{$phpbb_root_path}points.$phpEx", "mode=change_points") : '',
	'U_FIND_USERNAME'			 => append_sid("{$phpbb_root_path}memberlist.$phpEx", "mode=searchuser&amp;form=post&amp;field=username"),
));

page_header($page_title);

$template->set_filenames(array(
  'body'	=> 'points.html',
));

page_footer();

?>