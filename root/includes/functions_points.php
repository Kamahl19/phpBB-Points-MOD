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
* Add points
*/
function add_points($user_id, $amount)
{
	global $db;

	$sql = 'UPDATE ' . USERS_TABLE . '
		        SET user_points = user_points + ' . $amount . '
		          WHERE user_id = ' . $user_id;
	$db->sql_query($sql);
}

/**
* Remove points
*/
function remove_points($user_id, $amount)
{
	global $db;
	
	if ( load_user_points($user_id) < $amount )
	{
    $sql = 'UPDATE ' . USERS_TABLE . '
		        SET user_points = 0
		          WHERE user_id = ' . $user_id;
    $db->sql_query($sql);
  }
  else
  {
    $sql = 'UPDATE ' . USERS_TABLE . '
  		        SET user_points = user_points - ' . $amount . '
  		          WHERE user_id = ' . $user_id;
  	$db->sql_query($sql);
  }
}

/**
* Set the amount of points
*/
function set_points($user_id, $amount)
{
	global $db;

	$sql = 'UPDATE ' . USERS_TABLE . '
		        SET user_points = ' . $amount . '
		          WHERE user_id = ' . $user_id;
	$db->sql_query($sql);
}

/*
* Load user points
*/
function load_user_points($user_id)
{
  global $db;
  
  $sql = 'SELECT user_points 
            FROM ' . USERS_TABLE . '
				      WHERE user_id = ' . $user_id;
	$result = $db->sql_query($sql);
	$user_points  = $db->sql_fetchfield('user_points');
	$db->sql_freeresult($result);
	
	return $user_points;
}

/*
* Set points for post or topic
*/
function set_points_received($post_id, $add_points)
{
  global $db;
  
  $sql = 'UPDATE ' . POSTS_TABLE . '
            SET points_received = points_received + ' . $add_points . '
				      WHERE post_id = ' . $post_id;
	$db->sql_query($sql);
}

/*
* Load points received
*/
function load_points_received($post_id)
{
  global $db;
  
  $sql = 'SELECT points_received 
            FROM ' . POSTS_TABLE . '
				      WHERE post_id = ' . $post_id;
	$result = $db->sql_query($sql);
	$points_received  = $db->sql_fetchfield('points_received');
	$db->sql_freeresult($result);
	
	return $points_received;
}

/*
* Find out, if Points MOD is enabled for the forum
*/
function forum_points_enabled($forum_id)
{
  global $db;
  
  $sql = 'SELECT enable_points
            FROM ' . FORUMS_TABLE . '
              WHERE forum_id = ' . $forum_id;
	$result = $db->sql_query($sql);
	$forum_points_enable = $db->sql_fetchfield('enable_points');
	$db->sql_freeresult($result);
	
	return $forum_points_enable;
}

?>