<?php
namespace TH\Stashbox;

use \TH\Stashbox\Moment;
use \TH\Stashbox\Encrypt;

class Note
{
      
    /**
     * Create a comment on a Stashbox object.
     * 
     * @access public
     * @static
     * @param string $text
     * @param string $type
     * @param integer $post_id
     * @return integer
     */
    public static function create($text, $type, $post_id)
    {
        $user = wp_get_current_user();
        $time = current_time('mysql');
        $sanitize_text = wpautop($text);
        $encrypt_text = Encrypt::encrypt($sanitize_text);
        $comment_args = array(
            'comment_post_ID'      => $post_id,
            'comment_author'       => $user->display_name,
            'comment_author_email' => $user->user_email,
            'comment_author_url'   => '',
            'comment_content'      => $encrypt_text,
            'comment_type'         => $type,
            'comment_parent'       => 0,
            'user_id'              => $user->ID,
            'comment_author_IP'    => $_SERVER['REMOTE_ADDR'],
            'comment_agent'        => $_SERVER['HTTP_USER_AGENT'],
            'comment_date'         => $time,
            'comment_approved'     => 1
        );
        $comment_id = wp_insert_comment($comment_args);
        return $comment_id;
    }
   
    /**
     * Get all the comments for a post.
     * 
     * @access public
     * @static
     * @param integer $post_id
     * @return array
     */
    public static function getByPost($post_id)
    {
        $comment_args = array(
            'post_id' => $post_id
        );
        $comments = get_comments($comment_args);
        if (is_array($comments)) {
            array_walk($comments, array(__CLASS__, 'load'));
            return $comments;
        }
        if (!is_array($comments) && is_object($comments)) {
            $comment = self::load($comments);
            return array($comment);
        }
        return array();
    }
   
    /**
     * Delete a comment from the DB.
     * 
     * @access public
     * @static
     * @param integer $comment_id
     * @return boolean
     */
    public static function delete($comment_id)
    {
        $deleted = wp_delete_comment($comment_id);
        return $deleted;
    }
   
    /**
     * Augment the abilities of a standard Comment object.
     * Currently assigns a Moment() object of the comment date to replace the comment_date property.
     * 
     * @access public
     * @static
     * @param object $comment
     * @return object
     */
    public static function load(&$comment)
    {
        $comment->comment_date = new Moment($comment->comment_date);
        $comment->comment_content = Encrypt::decrypt($comment->comment_content);
    }
   
}