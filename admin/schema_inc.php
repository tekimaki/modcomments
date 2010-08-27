<?php

global $gBitSystem;

$gBitSystem->registerPackageInfo( MODCOMMENTS_PKG_NAME, array(
	'description' => 'Allow admins or content creators to moderate comments.',
	'requirements' => 'ModComments is dependent on <a class="external" href="http://www.bitweaver.org/wiki/moderationpackage">ModerationPackage</a>',
	'license' => '<a href="http://www.gnu.org/licenses/licenses.html#LGPL">LGPL</a>',
) );

// Requirements
$gBitSystem->registerRequirements( MODCOMMENTS_PKG_NAME, array(
    'liberty' => array( 'min' => '2.1.4' ),
));

// Install process
global $gBitInstaller;
if( is_object( $gBitInstaller ) ){

// ### Default Preferences
$gBitInstaller->registerPreferences( MODCOMMENTS_PKG_NAME, array(
//	array( NEXUS_PKG_NAME, 'nexus_menu_text', 'Menus' ),
) );

}


