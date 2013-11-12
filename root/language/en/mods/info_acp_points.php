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

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(
	'ACP_POINTS'						     => 'Points MOD',
	'ACP_POINTS_INDEX_TITLE'     => 'Point MOD Settings',
	'ACP_POINTS_INDEX_EXPLAIN'	 => 'Here you can set Points MOD',
	'ACP_POINTS_DEACTIVATED'	   => 'Points MOD is currently disabled',
  
  'ENABLE_POINTS'              => 'Enable points for this forum', 
    
	'POINTS_ENABLE'						   => 'Enable Points MOD',
	'POINTS_ENABLE_EXPLAIN'		   => 'Allow users to use Points MOD',
	'POINTS_NAME'						     => 'Points name',
	'POINTS_NAME_EXPLAIN'			   => 'The name of your board points',
	'FORUM_PERPOST'						   => 'Points per new post',
	'FORUM_PERPOST_EXPLAIN'			 => 'Set how much points users will receive for creating a new post.',
	'FORUM_PERWORD'						   => 'Points per word',
	'FORUM_PERWORD_EXPLAIN'			 => 'Set how much points users will receive for every word in the post.',
	'FORUM_PERTOPIC'					   => 'Points per new topic',
	'FORUM_PERTOPIC_EXPLAIN'		 => 'Set how much points users will receive for creating a new topic.',
	'POINTS_TRANSFER'					   => 'Allow users to transfer points',
	'POINTS_TRANSFER_EXPLAIN'		 => 'Allow users to transfer their points to another user',
	'POINTS_TRANSFER_PM'				 => 'Notify user about transfer by PM',
	'POINTS_TRANSFER_PM_EXPLAIN' => 'Notify user by PM, when somebody sends points to him',
	'POINTS_COMMENTS'					   => 'Allow comments',
	'POINTS_COMMENTS_EXPLAIN'		 => 'Allow user to leave the comment about the points transfer',
	'POINTS_STATS'						   => 'Display The richest users on index',
	
	'POINTS_CONFIG_SUCCESS'			 => 'Points MOD settings have been updated successfully',
	
	'POINTS_GROUP_TRANSFER'                    => 'Transfer points to group',
	'POINTS_GROUP_TRANSFER_EXPLAIN'            => 'Cou can add, remove or set points for a certain group. You also can send a personal message to each member of the group.',
	'POINTS_GROUP_TRANSFER_PM_ERROR'           => 'You have to enter the subject as well as the message to send the PM to the group.',
	'POINTS_GROUP_TRANSFER_SUCCESS'	           => 'Transfer has been processed successfully',
	'POINTS_GROUP_TRANSFER_NO_USERS_IN_GROUP'  => 'There are no users in this group',
	'POINTS_GROUP_TRANSFER_GROUP'              => 'Group',
	'POINTS_GROUP_TRANSFER_AMOUNT'             => 'Amount',
	'POINTS_SMILIES'                           => 'Smilies',
	'POINTS_GROUP_TRANSFER_PM_TITLE'           => 'Personal message subject',
	'POINTS_GROUP_TRANSFER_PM_COMMENT'         => 'Personal message text',
	'POINTS_GROUP_TRANSFER_FUNCTION'           => 'Function',
	'POINTS_GROUP_TRANSFER_ADD'                => 'Add',
	'POINTS_GROUP_TRANSFER_SET'                => 'Set',
	'POINTS_GROUP_TRANSFER_REMOVE'             => 'Remove',
	'POINTS_GROUP_TRANSFER_NO_AMOUNT'          => 'You have to set the amount of points to transfer',
	
	'LOG_RESYNC_SUCCESS'                       => 'Points has been reset succesfully',
	'RESYNC_POINTS_CONFIRM'	                   => 'Are you sure, you want to reset all points?<br />Note: This can not be undone!',
	'RESYNC_ATTENTION'                         => 'This actions can not be undone!',
	'RESYNC_POINTS'                            => 'Reset users points',
));

?>