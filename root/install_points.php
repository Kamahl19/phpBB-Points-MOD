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
define('UMIL_AUTO', true);
define('IN_PHPBB', true);

$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);

include($phpbb_root_path . 'common.' . $phpEx);

$user->session_begin();
$auth->acl($user->data);
$user->setup();

if (!file_exists($phpbb_root_path . 'umil/umil_auto.' . $phpEx))
{
	trigger_error('Please download the latest UMIL (Unified MOD Install Library) from: <a href="http://www.phpbb.com/mods/umil/">phpBB.com/mods/umil</a>', E_USER_ERROR);
}

$mod_name = 'Points MOD';
$version_config_name = 'points_mod_version';
$language_file = 'mods/points';

$versions = array(
	'1.0.0_RC1'	=> array(
		'permission_add' => array(
			array('u_use_transfer', true),
			array('m_chg_points', true),
			array('a_points', true),
		),
  
		'module_add' => array(
			array('acp', 'ACP_CAT_DOT_MODS', 'ACP_POINTS'),
			
			array('acp', 'ACP_POINTS', array(
  				'module_basename'	=> 'points',
  				'module_langname'	=> 'ACP_POINTS_INDEX_TITLE',
  				'module_mode'		=> 'points',
  				'module_auth'		=> 'acl_a_points',
  			),
      ),
		),
		
		'config_add' => array(
			array('points_enable', '1'),
  		array('points_name', 'Points'),
  		array('transfer_enable', '1'),
  		array('transfer_pm_enable', '1'),
  		array('comments_enable', '1'),
  		array('stats_enable',	'1'),
  		array('perpost',	'10'),
  		array('pertopic',	'20'),
		),
		
		'table_column_add' => array(
			array(POSTS_TABLE, 'points_received', array('UINT', '0')),
			array(USERS_TABLE, 'user_points', array('UINT', '0')),
			array(FORUMS_TABLE, 'enable_points', array('TINT:1', '1')),
		),
			
		'cache_purge' => array(
			array(),
			array('imageset'),
			array('template'),
			array('theme'),
		),
	),
	
	'1.0.1'	=> array(
	
    'permission_set' => array(
			array('REGISTERED', 'u_use_transfer', 'group'),
			array('ROLE_USER_STANDARD', 'u_use_transfer', 'role'),
			array('ROLE_USER_FULL', 'a_points', 'role'),
			array('ROLE_MOD_STANDARD', 'm_chg_points', 'role'),
			array('ROLE_MOD_FULL', 'm_chg_points', 'role'),
			array('ROLE_ADMIN_FULL', 'a_points', 'role'),
		), 			
	),
	
 '1.0.2'	=> array(
	),

	'1.0.3'	=> array(

		'config_add' => array(
  		array('perword',	'1'),
		),

		'cache_purge' => array(
			array('imageset'),
			array('template'),
			array('theme'),
		),
	),

);

// Include the UMIF Auto file and everything else will be handled automatically.
include($phpbb_root_path . 'umil/umil_auto.' . $phpEx);

?>