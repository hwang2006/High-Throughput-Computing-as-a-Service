<?php
/**
 * MediaWiki extension to add SNS buttons in the sidebar
 * Installation instructions can be found on
 * http://www.mediawiki.org/wiki/Extension:SNSButtonsInSidebar
 *
 * @ingroup Extensions
 * @author Jmkim dot com
 * @license GNU Public License
 */
 
// Exit if called outside of MediaWiki
if( !defined( 'MEDIAWIKI' ) ) exit;
 
// SETTINGS
$wgSNSButtonsTitle = 'Recommendations';
 
$wgExtensionCredits['parserhook'][] = array(
        'path'        => __FILE__,
        'name'        => 'SNSButtonsInSidebar',
        'version'     => '1.0.0',
        'author'      => 'Jmkim dot com',
        'description' => 'SNSButtonsInSidebar Extension',
        'url'         => 'http://www.mediawiki.org/wiki/Extension:SNSButtonsInSidebar'
);
 
// Register class and localisations
$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['SNSButtonsInSidebar'] = $dir.'SNSButtonsInSidebar.class.php';
 
// Hook to modify the sidebar
$wgHooks['SkinBuildSidebar'][] = 'SNSButtonsInSidebar::renderSNSButtonsInSidebar';

