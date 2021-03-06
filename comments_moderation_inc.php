<?php
/**
 * @version $Header$
 *
 * Copyright (c) 2004-2008 bitweaver Group
 * All Rights Reserved.
 * Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See http://www.gnu.org/copyleft/lesser.html for details.
 *
 * @author  Will <will@onnyturf.com>  
 * @version  $Revision$
 * @package  modcomments
 */

/**
 * load up moderation
 * we need to include its bit_setup_inc incase comments gets loaded first
 */
if ( is_file( BIT_ROOT_PATH.'moderation/bit_setup_inc.php' ) ){
	require_once( BIT_ROOT_PATH.'moderation/bit_setup_inc.php' );
}

global $gBitSystem;
if( $gBitSystem->isPackageActive('moderation') &&
	!defined('modcomments_moderation_callback') ) {
	global $gModerationSystem;

	require_once(MODERATION_PKG_PATH.'ModerationSystem.php');

	// What are our transitions
	$commentTransitions = array( "comment_post" =>
							   array (MODERATION_PENDING =>
									  array(MODERATION_APPROVED,
											MODERATION_REJECTED),
									  MODERATION_REJECTED => MODERATION_DELETE,
									  MODERATION_APPROVED => MODERATION_DELETE,
									  ),
							   );

	function modcomments_moderation_callback(&$pModeration) {
		global $gBitUser, $gBitSystem;

		if ($pModeration['type'] == 'comment_post') {
			$comment = new LibertyComment( NULL, $pModeration['content_id'] );
			$comment->load();
			if ($pModeration['status'] == MODERATION_APPROVED) {
				// change its status
				$comment->storeStatus( 50 );
				// delete the ticket
				$pModeration['status'] = MODERATION_DELETE;
			}else if($pModeration['status'] == MODERATION_REJECTED) {
				// change its status to soft delete
				$comment->storeStatus( -999 );
				// delete the ticket
				$pModeration['status'] = MODERATION_DELETE;
			}
		}

		return TRUE;
	}

	// Register our moderation transitions
	$gModerationSystem->registerModerationListener('liberty',
												   'modcomments_moderation_callback',
												   $commentTransitions);
}

?>
