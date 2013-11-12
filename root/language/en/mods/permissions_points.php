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
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
  $lang = array();
}

$lang['permission_cat']['points'] = 'Points MOD';

$lang = array_merge($lang, array(
	'acl_u_use_transfer'	=> array('lang' => 'Can transfer points', 'cat' => 'points'),
	'acl_m_chg_points'		=> array('lang' => 'Can edit users points', 'cat' => 'points'),
	'acl_a_points'			=> array('lang' => 'Can administrate Points MOD', 'cat' => 'points'),
));

?>