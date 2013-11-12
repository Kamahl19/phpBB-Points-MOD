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
if (!defined('IN_PHPBB'))
{
	exit;
}

class acp_points
{
	var $u_action;
	var $new_config;
	
	function main( $id, $mode )
	{
		global $db, $user, $auth, $template, $config, $phpbb_root_path, $phpbb_admin_path, $phpEx, $u_action;
		include($phpbb_root_path . 'includes/functions_privmsgs.' . $phpEx);                   

		// Grab some vars
		$action  = request_var('action', '');
		$id		   = request_var('id', 0);
		$set_config  = request_var('set_config', '');
		$group_transfer  = request_var('group_transfer', '');
		$action_points  = request_var('action_points', '');

		$this->tpl_name = 'acp_points';
		
		switch ( $mode ) 
		{
			case 'points':
				$this->page_title = 'ACP_POINTS_INDEX_TITLE';

				if ($set_config || $group_transfer || $action_points) 
				{    
          if ($set_config) 
				  {    
  					set_config('points_name', utf8_normalize_nfc(request_var('points_name', '', true)));
  					set_config('points_enable', request_var('points_enable', 0));
  					set_config('pertopic', request_var('pertopic', 0));
  					set_config('perpost', request_var('perpost', 0));
						set_config('perword', request_var('perword', 0));
  					set_config('transfer_enable', request_var('transfer_enable', 0));
  					set_config('transfer_pm_enable', request_var('transfer_pm_enable', 0));     
  					set_config('comments_enable', request_var('comments_enable', 0));
  					set_config('stats_enable', request_var('stats_enable', 0));
  					
  					trigger_error($user->lang['POINTS_CONFIG_SUCCESS'] . adm_back_link($this->u_action));   
  				}
  				elseif ($group_transfer) 
  				{
  				  $amount	    = request_var('transfer_amount',	0);				
    				$func				= request_var('func', '');
    				$group_id		= request_var('group_id', 0);
    				$pm_subject	= utf8_normalize_nfc(request_var('pm_subject', '', true));
    				$pm_text		= utf8_normalize_nfc(request_var('pm_text', '', true));
    				
    				if (!$amount)
    				{
              trigger_error($user->lang['POINTS_GROUP_TRANSFER_NO_AMOUNT'] . adm_back_link($this->u_action), E_USER_WARNING);  
            }
  
  					$sql_array = array(
  						'SELECT'	=> 'g.user_id',
  						'FROM'		=> array(
  							USER_GROUP_TABLE => 'g',
  						),
  						'LEFT_JOIN'	=> array(
             	  array(
            			'FROM'	=> array(USERS_TABLE => 'u'),
            			'ON'	=> 'u.user_id = g.user_id',
                )
            	),     
  						'WHERE'	=> 'g.user_pending = 0 AND u.user_type <> 2 AND g.group_id = ' . $group_id,
  					);
  					$sql = $db->sql_build_query('SELECT', $sql_array);
  					$result = $db->sql_query($sql);
  
  					$user_ids = array();
  
  					while ( $row = $db->sql_fetchrow($result) )
  					{
  						$user_ids[] = $row['user_id'];
  					}
  
  					$db->sql_freeresult($result);
  
  					if (sizeof($user_ids))
  					{
  						$userdata_group = implode(', ', $user_ids);
  
  						if ($func == 'add')
  						{
  							$sql = 'UPDATE ' . USERS_TABLE . '
  								      SET user_points = user_points + ' . $amount . '
  								        WHERE user_id IN (' . $userdata_group . ')';
  							$result = $db->sql_query($sql);
  						}
  
  						if ($func == 'substract')
  						{                        
                $sql = 'SELECT user_id
                        FROM ' . USERS_TABLE . '
  								        WHERE user_points < '. $amount . '
                            AND user_id IN (' . $userdata_group . ')';
  							$result = $db->sql_query($sql);
  							
  							while ($row = $db->sql_fetchrow($result))
            		{
            			$beggar_ids[] = (int) $row['user_id'];
            		}
			          $db->sql_freeresult($result);
			          
			          if ( sizeof($beggar_ids) )
              	{
                  $sql = 'UPDATE ' . USERS_TABLE . '
    								      SET user_points = 0 
    								        WHERE ' . $db->sql_in_set('user_id', $beggar_ids) . '
                              AND user_id IN (' . $userdata_group . ')';
    							$result = $db->sql_query($sql);
              	}
			          
  							$sql = 'UPDATE ' . USERS_TABLE . '
    								    SET user_points = user_points - ' . $amount . '
    								      WHERE ' . $db->sql_in_set('user_id', $beggar_ids, true) . '
                            AND user_id IN (' . $userdata_group . ')';
    						$result = $db->sql_query($sql);
  						}
  
  						if ($func == 'set')
  						{
  							$sql = 'UPDATE ' . USERS_TABLE . '
  								      SET user_points = ' . $amount . '
  								        WHERE user_id IN (' . $userdata_group . ')';
  							$result = $db->sql_query($sql);
  						}
  
  						// Send PM, if pm subject and pm comment is entered
  						if ( $pm_subject || $pm_text )
  						{
  							if ( $pm_subject == '' || $pm_text == '' )
  							{
  								trigger_error($user->lang['POINTS_GROUP_TRANSFER_PM_ERROR'] . adm_back_link($this->u_action), E_USER_WARNING);
  							}
  							else
  							{
                  $poll = $uid = $bitfield = $options = ''; 
  								generate_text_for_storage($pm_subject, $uid, $bitfield, $options, false, false, false);
  								generate_text_for_storage($pm_text, $uid, $bitfield, $options, true, true, true);
          
                  $sql = 'SELECT user_id
                            FROM ' . USERS_TABLE . '
                              WHERE group_id = ' . $group_id;
                  $result = $db->sql_query($sql);
                  
                  $pm_data = array(
                     'from_user_id'		    => $user->data['user_id'],
                     'icon_id'			      => 0,
                     'from_user_ip'		    => $user->data['user_ip'],
                     'from_username'		  => $user->data['username'],
                     'enable_bbcode'		  => true,
    								 'enable_smilies'	    => true,
    								 'enable_urls'		    => true,
    								 'enable_sig'		      => true,
                     'message'			      => $pm_text,
  									 'bbcode_bitfield'	  => $bitfield,
  									 'bbcode_uid'		      => $uid,
                  );
                  
                  while ( $row = $db->sql_fetchrow($result) )
        					{
          					$pm_data['address_list'] = array('u' => array($row['user_id'] => 'to'));
                    submit_pm('post', $pm_subject, $pm_data, false); 
          				}
          				$db->sql_freeresult($result);
  							}
  						}
  						
  						$message = $user->lang['POINTS_GROUP_TRANSFER_SUCCESS'] . adm_back_link($this->u_action);
  						trigger_error($message);
  					}
  					else
  					{
              trigger_error($user->lang['POINTS_GROUP_TRANSFER_NO_USERS_IN_GROUP'] . adm_back_link($this->u_action), E_USER_WARNING);
            }
          }
          elseif ($action_points) 
          {
            if (confirm_box(true))
  					{
  						$db->sql_query('UPDATE ' . USERS_TABLE . ' SET user_points = 0');
  
  						add_log('admin', 'LOG_RESYNC_SUCCESS');
  						trigger_error($user->lang['LOG_RESYNC_SUCCESS'] . adm_back_link($this->u_action));
  					}
  					else
  					{
  						$s_hidden_fields = build_hidden_fields(array(
  							'action_points'		=> true,
  						));
  
  						confirm_box(false, $user->lang['RESYNC_POINTS_CONFIRM'], $s_hidden_fields);
  					}  
          }
				}
				else 
				{
  				$sql_array = array(
  					'SELECT'	=> 'g.group_id, g.group_name, g.group_type',
  					'FROM'		=> array(
  						GROUPS_TABLE => 'g',
  					),
  					'ORDER_BY'	=> 'g.group_name',
  				);
  				$sql = $db->sql_build_query('SELECT', $sql_array);
  				$result = $db->sql_query($sql);
  				$total_groups = $db->sql_affectedrows($result);
  				$db->sql_freeresult($result);
    
					$template->assign_vars(array(
						'POINTS_NAME'					=> $config['points_name'],
						'POINTS_ENABLE'				=> ($config['points_enable']) ? true : false,
						'TRANSFER_ENABLE'			=> $config['transfer_enable'],
						'PERTOPIC'			      => $config['pertopic'],
						'PERPOST'       			=> $config['perpost'],
						'PERWORD'       			=> $config['perword'],
						'STATS_ENABLE'				=> $config['stats_enable'],
						'TRANSFER_PM_ENABLE'	=> $config['transfer_pm_enable'],
						'COMMENTS_ENABLE'			=> $config['comments_enable'],
					  'S_POINTS_ACTIVATED'	=> ($config['points_enable']) ? true : false,
					  'U_ACTION'				    => $this->u_action,
					  'U_SMILIES'	          => append_sid("{$phpbb_root_path}posting.$phpEx", 'mode=smilies'),				
    				'S_GROUP_OPTIONS'	    => group_select_options($total_groups),
					));
				}

			break;

		}
	}
}

?>