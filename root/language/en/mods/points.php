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

if ( empty($lang) || !is_array($lang) )
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'POINTS'						         => 'Points',
	'POINTS_MOST_RICH_USERS'		 => 'The richest users',
	'POINTS_RETURN_POST'				 => 'Return to the topic',
	'POINTS_RETURN_INDEX'				 => 'Return to the index',
	'POINTS_RETURN_TRANSFER'		 => 'Return to the transfer',
	'POINTS_MAIN'						     => '%s overwiev',
	'POINTS_MODIFY'						   => 'Modify',
	'POINTS_DONATE'						   => 'Donate',	
	'POINTS_DISABLED'            => 'Points MOD is currently disabled',
	
	'POINTS_RECEIVED_POST_MESSAGE'		=> 'You have received <strong>%1$s %2$s</strong> for this topic',
	'POINTS_RECEIVED_REPLY_MESSAGE'		=> 'You have received <strong>%1$s %2$s</strong> for this post',
	'POINTS_RECEIVED_POST_MOD_MESSAGE'		=> 'You will receive <strong>%1$s %2$s</strong> for this topic when it will be approved',
	'POINTS_RECEIVED_REPLY_MOD_MESSAGE'		=> 'You will receive <strong>%1$s %2$s</strong> for this post when it will be approved',
	'POINTS_POST_REMOVED'		     => 'You have lost <strong>%1$s %2$s</strong> for deleting this post',
	
	'NO_USER_SELECTED'           => 'You did not select any user',
	'NO_AMOUNT_SELECTED'         => 'You did not select any amount of %s',       
	
	'TRANSFER_DISABLED'						=> 'Transfer is disabled',
	'TRANSFER_USERNAME_NOT_EXIST' => 'There is no user with this username.',
	'TRANSFER_SUCCESS'			      => 'The transfer was successful.',
	'TRANSFER_NOT_ENOUGH_POINTS'  => 'You do not have enough %1$s to transfer.',
	'TRANSFER_PM_SUBJECT'				  => 'You have received a donation!',
	'TRANSFER_PM_BODY'					  => 'You have received a donation of %1$s %2$s.',
	'TRANSFER_PM_BODY_COMMENT'	  => 'You have received a donation of %1$s %2$s with the following comment: <br /><i>%3$s</i>',
	'TRANSFER_POINTS_TITLE'				=> 'Transfer %s',
	'TRANSFER_POINTS'						  => 'Transfer %s',   
	'TRANSFER_AMOUNT'						  => 'Amount',
	'TRANSFER_COMMENT'						=> 'Comment',
	
	'CHANGE_NO_USER_SELECTED'			=> 'No user selected',
	'CHANGE_SUCCESS'					    => 'The user has been updated.',
	'CHANGE_POINTS'						    => 'Change %s',
	'CHANGE_AMOUNT'						    => 'New amount',
	
	'MAIN_HELLO'				          => 'Hello %s !',
	'MAIN_TEXT'				            => 'You have %1$s %2$s.<br /><br />%2$s per new topic: %3$s<br />%2$s per new post: %4$s<br />%2$s per word: %5$s',
));

?>