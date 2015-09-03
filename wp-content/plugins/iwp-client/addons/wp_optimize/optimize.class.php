<?php
if(basename($_SERVER['SCRIPT_FILENAME']) == "optimize.class.php"):
    exit;
endif;
class IWP_MMB_Optimize extends IWP_MMB_Core
{
    function __construct()
    {
        parent::__construct();
    }
    
	function cleanup_system($cleanupType){
		
		$cleanup_values = array();
		$cleanup_values['value_array'] = array();
		$text = '';
		
		if (isset($cleanupType["clean-revisions"])) {
			$values = self::cleanup_type_process('revisions');
			$text .= "<span class='wpm_results'>" . $values['message'] . "</span>";
			$cleanup_values['value_array']['revisions'] = $values['value'];
		}
	
		if (isset($cleanupType["clean-autodraft"])) {
			$values = self::cleanup_type_process('autodraft');
			$text .= "<span class='wpm_results'>" . $values['message'] . "</span>";
			$cleanup_values['value_array']['autodraft'] = $values['value'];
			}	
			
		if (isset($cleanupType["clean-comments"])) {
			$values = self::cleanup_type_process('spam');
			$text .= "<span class='wpm_results'>" . $values['message'] . "</span>";
			$cleanup_values['value_array']['spam'] = $values['value'];
			}
		
		if (isset($cleanupType["unapproved-comments"])) {
			$values = self::cleanup_type_process('unapproved');
			$text .= "<span class='wpm_results'>" . $values['message'] . "</span>";
			$cleanup_values['value_array']['unapproved'] = $values['value'];
			}
		
		$text .= '<br>';
		
		if (isset($cleanupType["optimize-db"])) {
			$values = self::cleanup_type_process('optimize-db');
			$text .= "<span class='wpm_results_db'>" . $values['message'] . "</span>";
			$cleanup_values['value_array']['optimize-db'] = $values['value'];
			//$text .= DB_NAME.__(" Database Optimized!<br>", 'wp-optimize');
			}
	
		if ($text !==''){
			$cleanup_values['message'] = $text;
			return $cleanup_values;
		}
	}
	
	function cleanup_type_process($cleanupType){
		global $wpdb;
		$clean = ""; $message = "";
		$message_array = array();
		//$message_array['value'] = array();
		$optimized = array();
	
		switch ($cleanupType) {
			
			case "revisions":
				$clean = "DELETE FROM $wpdb->posts WHERE post_type = 'revision'";
				$revisions = $wpdb->query( $clean );
				$message .= __('Post revisions deleted - ', 'wp-optimize') . $revisions;
				$message_array['value'] = $revisions;
				//$message_array['del_post_rev']['message'] = $revisions.__(' post revisions deleted<br>', 'wp-optimize');
				
				break;
				
	
			case "autodraft":
				$clean = "DELETE FROM $wpdb->posts WHERE post_status = 'auto-draft'";
				$autodraft = $wpdb->query( $clean );
				$message .= __('Auto drafts deleted - ', 'wp-optimize') . $autodraft;
				$message_array['value'] = $autodraft;
				//$message_array['del_auto_drafts']['message'] = $autodraft.__(' auto drafts deleted<br>', 'wp-optimize');
				
				break;
	
			case "spam":
				$clean = "DELETE FROM $wpdb->comments WHERE comment_approved = 'spam';";
				$comments = $wpdb->query( $clean );
				$message .= __('Spam comments deleted - ', 'wp-optimize') . $comments;
				$message_array['value'] = $comments;
				//$message_array['del_spam_comments']['message'] = $comments.__(' spam comments deleted<br>', 'wp-optimize');
				
				break;
	
			case "unapproved":
				$clean = "DELETE FROM $wpdb->comments WHERE comment_approved = '0';";
				$comments = $wpdb->query( $clean );
				$message .= __('Unapproved comments deleted - ', 'wp-optimize') . $comments;
				$message_array['value'] = $comments;
				//$message_array['del_unapproved_comments']['message'] = $comments.__(' unapproved comments deleted<br>', 'wp-optimize');
				
				break;
	
			case "optimize-db":
			   self::optimize_tables(true);
			   $message .= "Database ".DB_NAME." Optimized!";
			   $message_array['value'] = DB_NAME;
			   
			   break;
		
			default:
				$message .= __('NO Actions Taken', 'wp-optimize');
				$message_array['value'] = $comments;
				
				break;
		} // end of switch
		
	$message_array['message'] = $message;
	return $message_array;

	} // end of function
	
	function optimize_tables($Optimize=false){
	
		$db_clean = DB_NAME;
			
		$local_query = 'SHOW TABLE STATUS FROM `'. DB_NAME.'`';
		$result = mysql_query($local_query);
		if (mysql_num_rows($result)){
			while ($row = mysql_fetch_array($result))
			{
				$local_query = 'OPTIMIZE TABLE '.$row[0];
				$resultat  = mysql_query($local_query);
			}
		}
	
	}

}
?>