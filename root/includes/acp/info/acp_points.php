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

/**
* @package module_install
*/
class acp_points_info
{
	function module()
	{
		return array(
			'filename'	=> 'acp_points',
			'title'		=> 'ACP_POINTS',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'points'		=> array('title' => 'ACP_POINTS_INDEX_TITLE', 'auth' => 'acl_a_points', 'cat' => array('ACP_POINTS')),
			),
		);
	}

	function install()
	{
	}

	function uninstall()
	{
	}
}

?>