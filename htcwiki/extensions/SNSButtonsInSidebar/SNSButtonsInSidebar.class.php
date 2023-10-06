<?php
if (!defined('MEDIAWIKI')) exit;
 
class SNSButtonsInSidebar {
        static function renderSNSButtonsInSidebar( $skin, &$bar ) {
                global $wgFacebookCommonScriptWritten, $wgFacebookAppId;
                $btnsText = '';
                if( !isset($wgFacebookCommonScriptWritten) || !$wgFacebookCommonScriptWritten ) {
                        if( !isset($wgFacebookAppId) ) $wgFacebookAppId = '';
                        $wgFacebookCommonScriptWritten = true;
                        $btnsText .= '<div id="fb-root">';
                        $btnsText .= '</div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1&appId='.$wgFacebookAppId.'"></script>';
                }
                $btnsText .= '<script type="text/javascript">';
        $btnsText .= '(function() {';
    $btnsText .= "var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;";
    $btnsText .= "po.src = 'https://apis.google.com/js/plusone.js';";
    $btnsText .= "var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);";
        $btnsText .= '})();';
                $btnsText .= '</script>';
 
                global $wgServer;
                $btnsText .= '<div class="fb-like" data-href="'.$wgServer.'"';
                $btnsText .= ' data-send="false"        data-layout="button_count"';
                $btnsText .= ' data-width="130" data-show-faces="false"';
                $btnsText .= ' data-action="like" data-colorscheme="light"';
                $btnsText .= '></div>';
                $btnsText .= '<div style="height:5px"></div>';
                $btnsText .= '<div class="g-plusone" data-width="130" data-href="'.$wgServer.'"></div>';
                global $wgSNSButtonsTitle;
                $bar[$wgSNSButtonsTitle] = $btnsText;
                return true;
        }
}

