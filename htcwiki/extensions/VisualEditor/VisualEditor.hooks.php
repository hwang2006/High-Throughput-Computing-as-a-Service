<?php
/**
 * VisualEditor extension hooks
 *
 * @file
 * @ingroup Extensions
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

class VisualEditorHooks {
	public static function onSetup() {
		global $wgResourceModules, $wgVisualEditorResourceTemplate,
			$wgVisualEditorTabMessages;

		// This prevents VisualEditor from being run in environments that don't
		// have the dependent code in core; this should be updated as a part of
		// when additional dependencies are created and pushed into MediaWiki's
		// core. The most direct effect of this is to avoid confusing any third
		// parties who attempt to install VisualEditor onto non-alpha wikis, as
		// this should have no impact on deploying to Wikimedia's wiki cluster.
		// Is fine for release tarballs because 1.22wmf11 < 1.22alpha < 1.22.0.
		wfUseMW( '1.23wmf2' );

		// Add tab messages to the init init module
		foreach ( $wgVisualEditorTabMessages as $msg ) {
			if ( $msg !== null ) {
				$wgResourceModules['ext.visualEditor.viewPageTarget.init']['messages'][] = $msg;
			}
		}
	}

	/**
	 * Adds VisualEditor JS to the output.
	 *
	 * This is attached to the MediaWiki 'BeforePageDisplay' hook.
	 *
	 * @param $output OutputPage
	 * @param $skin Skin
	 */
	public static function onBeforePageDisplay( &$output, &$skin ) {
		$output->addModules( array( 'ext.visualEditor.viewPageTarget.init' ) );
		$output->addModuleStyles( array( 'ext.visualEditor.viewPageTarget.noscript' ) );
		return true;
	}

	/**
	 * Changes the Edit tab and adds the VisualEditor tab.
	 *
	 * This is attached to the MediaWiki 'SkinTemplateNavigation' hook.
	 *
	 * @param SkinTemplate $skin
	 * @param array $links Navigation links
	 * @return boolean
	 */
	public static function onSkinTemplateNavigation( &$skin, &$links ) {
		// Only do this if the user has VE enabled
		if (
			!$skin->getUser()->getOption( 'visualeditor-enable' ) ||
			$skin->getUser()->getOption( 'visualeditor-betatempdisable' )
		) {
			return true;
		}

		global $wgVisualEditorTabMessages, $wgVisualEditorTabPosition;
		if ( !isset( $links['views']['edit'] ) ) {
			// There's no edit link, nothing to do
			return true;
		}
		$title = $skin->getRelevantTitle();
		// Rebuild the $links['views'] array and inject the VisualEditor tab before or after
		// the edit tab as appropriate. We have to rebuild the array because PHP doesn't allow
		// us to splice into the middle of an associative array.
		$newViews = array();
		foreach ( $links['views'] as $action => $data ) {
			if ( $action === 'edit' ) {
				// Build the VisualEditor tab
				$existing = $title->exists() || (
					$title->getNamespace() == NS_MEDIAWIKI &&
					$title->getDefaultMessageText() !== false
				);
				$veParams = $skin->editUrlOptions();
				unset( $veParams['action'] ); // Remove action=edit
				$veParams['veaction'] = 'edit'; // Set veaction=edit
				$veTabMessage = $wgVisualEditorTabMessages[$existing ? 'edit' : 'create'];
				$veTabText = $veTabMessage === null ? $data['text'] :
					wfMessage( $veTabMessage )->setContext( $skin->getContext() )->text();
				$veTab = array(
					'href' => $title->getLocalURL( $veParams ),
					'text' => $veTabText,
					'primary' => true,
					'class' => '',
				);

				// Alter the edit tab
				$editTab = $data;
				$editTabMessage = $wgVisualEditorTabMessages[$existing ? 'editsource' : 'createsource'];
				if ( $editTabMessage !== null ) {
					$editTab['text'] = wfMessage( $editTabMessage )->setContext( $skin->getContext() )->text();
				}

				// Inject the VE tab before or after the edit tab
				if ( $wgVisualEditorTabPosition === 'before' ) {
					$newViews['ve-edit'] = $veTab;
					$newViews['edit'] = $editTab;
				} else {
					$newViews['edit'] = $editTab;
					$newViews['ve-edit'] = $veTab;
				}
			} else {
				// Just pass through
				$newViews[$action] = $data;
			}
		}
		$links['views'] = $newViews;
		return true;
	}

	/**
	 * Changes the section edit links to add a VE edit link.
	 *
	 * This is attached to the MediaWiki 'DoEditSectionLink' hook.
	 *
	 * @param $skin Skin
	 * @param $title Title
	 * @param $section string
	 * @param $tooltip string
	 * @param $result string HTML
	 * @param $lang Language
	 * @returns bool true
	 */
	public static function onDoEditSectionLink( $skin, $title, $section, $tooltip, &$result, $lang ) {
		// Only do this if the user has VE enabled
		// (and we're not in parserTests)
		if (
			isset( $GLOBALS[ 'wgVisualEditorInParserTests' ] ) ||
			!$skin->getUser()->getOption( 'visualeditor-enable' ) ||
			$skin->getUser()->getOption( 'visualeditor-betatempdisable' )
		) {
			return;
		}

		global $wgVisualEditorTabMessages, $wgVisualEditorTabPosition;
		$veEditSection = $wgVisualEditorTabMessages['editsection'] !== null ?
			$wgVisualEditorTabMessages['editsection'] : 'editsection';
		$sourceEditSection = $wgVisualEditorTabMessages['editsectionsource'] !== null ?
			$wgVisualEditorTabMessages['editsectionsource'] : 'editsection';

		// Code mostly duplicated from Skin::doEditSectionLink() :(
		$attribs = array();
		if ( !is_null( $tooltip ) ) {
			# Bug 25462: undo double-escaping.
			$tooltip = Sanitizer::decodeCharReferences( $tooltip );
			$attribs['title'] = wfMessage( 'editsectionhint' )->rawParams( $tooltip )
				->inLanguage( $lang )->text();
		}
		$veLink = Linker::link( $title, wfMessage( $veEditSection )->inLanguage( $lang )->text(),
			$attribs + array( 'class' => 'mw-editsection-visualeditor' ),
			array( 'veaction' => 'edit', 'section' => $section ),
			array( 'noclasses', 'known' )
		);
		$sourceLink = Linker::link( $title, wfMessage( $sourceEditSection )->inLanguage( $lang )->text(),
			$attribs,
			array( 'action' => 'edit', 'section' => $section ),
			array( 'noclasses', 'known' )
		);

		$veFirst = $wgVisualEditorTabPosition === 'before';
		$result = '<span class="mw-editsection">'
			. '<span class="mw-editsection-bracket">[</span>'
			. ( $veFirst ? $veLink : $sourceLink )
			. '<span class="mw-editsection-divider">'
			. wfMessage( 'pipe-separator' )->inLanguage( $lang )->text()
			. '</span>'
			. ( $veFirst ? $sourceLink : $veLink )
			. '<span class="mw-editsection-bracket">]</span>'
			. '</span>';

		return true;
	}

	public static function onGetPreferences( $user, &$preferences ) {
		if ( !array_key_exists( 'visualeditor-enable', $preferences ) ) {
			$preferences['visualeditor-enable'] = array(
				'type' => 'toggle',
				'label-message' => 'visualeditor-preference-enable',
				'section' => 'editing/beta'
			);
		}
		$preferences['visualeditor-betatempdisable'] = array(
			'type' => 'toggle',
			'label-message' => 'visualeditor-preference-betatempdisable',
			'section' => 'editing/beta'
		);
		return true;
	}

	public static function onGetBetaPreferences( $user, &$preferences ) {
		global $wgExtensionAssetsPath, $wgVisualEditorSupportedSkins, $wgVisualEditorBrowserBlacklist;

		$dir = RequestContext::getMain()->getLanguage()->getDir();

		$preferences['visualeditor-enable'] = array(
			'version' => '1.0',
			'label-message' => 'visualeditor-preference-core-label',
			'desc-message' => 'visualeditor-preference-core-description',
			'screenshot' => $wgExtensionAssetsPath .
				"/VisualEditor/betafeatures-icon-VisualEditor-$dir.svg",
			'info-message' => 'visualeditor-preference-core-info-link',
			'discussion-message' => 'visualeditor-preference-core-discussion-link',
			'requirements' => array(
				'javascript' => true,
				'blacklist' => $wgVisualEditorBrowserBlacklist,
				'skins' => $wgVisualEditorSupportedSkins,
			)
		);

/* Disabling Beta Features option for language for now
		$preferences['visualeditor-enable-language'] = array(
			'version' => '1.0',
			'label-message' => 'visualeditor-preference-language-label',
			'desc-message' => 'visualeditor-preference-language-description',
			'screenshot' => $wgExtensionAssetsPath .
				"/VisualEditor/betafeatures-icon-VisualEditor-language-$dir.svg",
			'info-message' => 'visualeditor-preference-experimental-info-link',
			'discussion-message' => 'visualeditor-preference-experimental-discussion-link',
			'requirements' => array(
				'betafeatures' => array(
					'visualeditor-enable',
				),
			),
		);
*/

/* Disabling Beta Features option for generic content for now
		$preferences['visualeditor-enable-mwalienextension'] = array(
			'version' => '1.0',
			'label-message' => 'visualeditor-preference-mwalienextension-label',
			'desc-message' => 'visualeditor-preference-mwalienextension-description',
			'screenshot' => $wgExtensionAssetsPath .
				"/VisualEditor/betafeatures-icon-VisualEditor-alien-$dir.svg",
			'info-message' => 'visualeditor-preference-mwalienextension-info-link',
			'discussion-message' => 'visualeditor-preference-mwalienextension-discussion-link',
			'requirements' => array(
				'betafeatures' => array(
					'visualeditor-enable',
				),
			),
		);
*/

		$preferences['visualeditor-enable-mwmath'] = array(
			'version' => '1.0',
			'label-message' => 'visualeditor-preference-mwmath-label',
			'desc-message' => 'visualeditor-preference-mwmath-description',
			'screenshot' => $wgExtensionAssetsPath .
				"/VisualEditor/betafeatures-icon-VisualEditor-formulae-$dir.svg",
			'info-message' => 'visualeditor-preference-mwmath-info-link',
			'discussion-message' => 'visualeditor-preference-mwmath-discussion-link',
			'requirements' => array(
				'betafeatures' => array(
					'visualeditor-enable',
				),
			),
		);

/* Disabling Beta Features option for hieroglyphics for now
		$preferences['visualeditor-enable-mwhiero'] = array(
			'version' => '1.0',
			'label-message' => 'visualeditor-preference-mwhiero-label',
			'desc-message' => 'visualeditor-preference-mwhiero-description',
			'screenshot' => $wgExtensionAssetsPath .
				"/VisualEditor/betafeatures-icon-VisualEditor-hieroglyphics-$dir.svg",
			'info-message' => 'visualeditor-preference-mwhiero-info-link',
			'discussion-message' => 'visualeditor-preference-mwhiero-discussion-link',
			'requirements' => array(
				'betafeatures' => array(
					'visualeditor-enable',
				),
			),
		);
*/

/* Disabling Beta Features option for syntax highlighting for now
		$preferences['visualeditor-enable-mwsyntaxHighlight'] = array(
			'version' => '1.0',
			'label-message' => 'visualeditor-preference-mwsyntaxHighlight-label',
			'desc-message' => 'visualeditor-preference-mwsyntaxHighlight-description',
			'screenshot' => $wgExtensionAssetsPath .
				"/VisualEditor/betafeatures-icon-VisualEditor-syntaxHighlight-$dir.svg",
			'info-message' => 'visualeditor-preference-mwsyntaxHighlight-info-link',
			'discussion-message' => 'visualeditor-preference-mwsyntaxHighlight-discussion-link',
			'requirements' => array(
				'betafeatures' => array(
					'visualeditor-enable',
				),
			),
		);
*/
	}

	public static function onListDefinedTags( &$tags ) {
		$tags[] = 'visualeditor';
		$tags[] = 'visualeditor-needcheck';
		return true;
	}

	/**
	 * Adds extra variables to the page config.
	 */
	public static function onMakeGlobalVariablesScript( array &$vars, OutputPage $out ) {
		global $wgStylePath;

		$pageLanguage = $out->getTitle()->getPageLanguage();

		$vars['wgVisualEditor'] = array(
			'isPageWatched' => $out->getUser()->isWatched( $out->getTitle() ),
			// Same as in Linker.php
			'magnifyClipIconURL' => $wgStylePath .
				'/common/images/magnify-clip' .
				( $pageLanguage->isRTL() ? '-rtl' : '' ) . '.png',
			'pageLanguageCode' => $pageLanguage->getHtmlCode(),
			'pageLanguageDir' => $pageLanguage->getDir()
		);

		return true;
	}

	/**
	 * Adds extra variables to the global config
	 */
	public static function onResourceLoaderGetConfigVars( array &$vars ) {
		global $wgDefaultUserOptions,
			$wgVisualEditorDisableForAnons,
			$wgVisualEditorEnableExperimentalCode,
			$wgVisualEditorNamespaces,
			$wgVisualEditorPluginModules,
			$wgVisualEditorTabPosition,
			$wgVisualEditorTabMessages,
			$wgVisualEditorBrowserBlacklist,
			$wgVisualEditorSupportedSkins,
			$wgVisualEditorShowBetaWelcome,
			$wgVisualEditorPreferenceModules;

		$vars['wgVisualEditorConfig'] = array(
			'disableForAnons' => $wgVisualEditorDisableForAnons,
			'preferenceModules' => $wgVisualEditorPreferenceModules,
			'namespaces' => $wgVisualEditorNamespaces,
			'pluginModules' => $wgVisualEditorPluginModules,
			'defaultUserOptions' => array(
				'betatempdisable' => $wgDefaultUserOptions['visualeditor-betatempdisable'],
				'enable' => $wgDefaultUserOptions['visualeditor-enable'],
			),
			'blacklist' => $wgVisualEditorBrowserBlacklist,
			'skins' => $wgVisualEditorSupportedSkins,
			'tabPosition' => $wgVisualEditorTabPosition,
			'tabMessages' => $wgVisualEditorTabMessages,
			'showBetaWelcome' => $wgVisualEditorShowBetaWelcome,
		);

		foreach ( $wgVisualEditorPreferenceModules as $pref => $module ) {
			$vars['wgVisualEditorConfig']['defaultUserOptions'][$pref] =
				$wgDefaultUserOptions[$pref];
		}

		return true;
	}

	/**
	 * Conditionally register the oojs and oojs-ui modules, in case they've already been registered
	 * by a more recent version of MediaWiki core.
	 *
	 * Also conditionally register the jquery.uls and jquery.i18n modules, in case they've already
	 * been registered by the UniversalLanguageSelector extension.
	 *
	 * @param ResourceLoader $resourceLoader
	 * @returns boolean true
	 */
	public static function onResourceLoaderRegisterModules( ResourceLoader &$resourceLoader ) {
		global $wgResourceModules, $wgVisualEditorResourceTemplate;
		$modules = array();
		if ( !isset( $wgResourceModules['oojs'] ) && !$resourceLoader->getModule( 'oojs' ) ) {
			$modules['oojs'] = $wgVisualEditorResourceTemplate + array(
				'scripts' => array(
					'lib/ve/lib/oojs/oojs.js',
				),
				'targets' => array( 'desktop', 'mobile' ),
			);
		}

		if ( !isset( $wgResourceModules['oojs-ui'] ) && !$resourceLoader->getModule( 'oojs-ui' ) ) {
			$modules['oojs-ui'] = $wgVisualEditorResourceTemplate + array(
				'scripts' => array(
					'lib/ve/lib/oojs-ui/oojs-ui.js',
				),
				'styles' => array(
					'lib/ve/lib/oojs-ui/oojs-ui.svg.css',
				),
				'messages' => array(
					'ooui-dialog-action-close',
					'ooui-outline-control-move-down',
					'ooui-outline-control-move-up',
					'ooui-toolbar-more',
				),
				'dependencies' => array(
					'oojs'
				),
				'targets' => array( 'desktop', 'mobile' ),
			);
		}

		if ( !isset( $wgResourceModules['jquery.uls'] ) && !$resourceLoader->getModule( 'jquery.uls' ) ) {
			$modules['jquery.uls'] = $wgVisualEditorResourceTemplate + array(
				'scripts' => array(
					'lib/jquery.uls/src/jquery.uls.core.js',
					'lib/jquery.uls/src/jquery.uls.lcd.js',
					'lib/jquery.uls/src/jquery.uls.languagefilter.js',
					'lib/jquery.uls/src/jquery.uls.regionfilter.js',
				),
				'styles' => array(
					'lib/jquery.uls/css/jquery.uls.css',
					'lib/jquery.uls/css/jquery.uls.lcd.css',
				),
				'dependencies' => array(
					'jquery.uls.grid',
					'jquery.uls.data',
					'jquery.uls.compact',
				),
			);
		}

		if (
			!isset( $wgResourceModules['jquery.uls.data'] ) &&
			!$resourceLoader->getModule( 'jquery.uls.data' )
		) {
			$modules['jquery.uls.data'] = $wgVisualEditorResourceTemplate + array(
				'scripts' => array(
					'lib/jquery.uls/src/jquery.uls.data.js',
					'lib/jquery.uls/src/jquery.uls.data.utils.js',
				),
				'position' => 'top',
			);
		}

		if (
			!isset( $wgResourceModules['jquery.uls.grid'] ) &&
			!$resourceLoader->getModule( 'jquery.uls.grid' )
		) {
			$modules['jquery.uls.grid'] = $wgVisualEditorResourceTemplate + array(
				'styles' => 'lib/jquery.uls/css/jquery.uls.grid.css',
				'position' => 'top',
			);
		}

		if (
			!isset( $wgResourceModules['jquery.uls.compact'] ) &&
			!$resourceLoader->getModule( 'jquery.uls.compact' )
		) {
			$modules['jquery.uls.compact'] = $wgVisualEditorResourceTemplate + array(
				'styles' => 'lib/jquery.uls/css/jquery.uls.compact.css',
				'position' => 'top',
			);
		}

		if (
			!isset( $wgResourceModules['jquery.i18n'] ) &&
			!$resourceLoader->getModule( 'jquery.i18n' )
		) {
			$modules['jquery.i18n'] = $wgVisualEditorResourceTemplate + array(
				'scripts' => array(
					'lib/ve/lib/jquery.i18n/src/jquery.i18n.js',
					'lib/ve/lib/jquery.i18n/src/jquery.i18n.messagestore.js',
					'lib/ve/lib/jquery.i18n/src/jquery.i18n.parser.js',
					'lib/ve/lib/jquery.i18n/src/jquery.i18n.emitter.js',
					'lib/ve/lib/jquery.i18n/src/jquery.i18n.language.js',
				),
				'dependencies' => 'mediawiki.libs.pluralruleparser',
				'languageScripts' => array(
					'bs' => 'lib/ve/lib/jquery.i18n/src/languages/bs.js',
					'dsb' => 'lib/ve/lib/jquery.i18n/src/languages/dsb.js',
					'fi' => 'lib/ve/lib/jquery.i18n/src/languages/fi.js',
					'ga' => 'lib/ve/lib/jquery.i18n/src/languages/ga.js',
					'he' => 'lib/ve/lib/jquery.i18n/src/languages/he.js',
					'hsb' => 'lib/ve/lib/jquery.i18n/src/languages/hsb.js',
					'hu' => 'lib/ve/lib/jquery.i18n/src/languages/hu.js',
					'hy' => 'lib/ve/lib/jquery.i18n/src/languages/hy.js',
					'la' => 'lib/ve/lib/jquery.i18n/src/languages/la.js',
					'ml' => 'lib/ve/lib/jquery.i18n/src/languages/ml.js',
					'os' => 'lib/ve/lib/jquery.i18n/src/languages/os.js',
					'ru' => 'lib/ve/lib/jquery.i18n/src/languages/ru.js',
					'sl' => 'lib/ve/lib/jquery.i18n/src/languages/sl.js',
					'uk' => 'lib/ve/lib/jquery.i18n/src/languages/uk.js',
				),
			);
		}

		$resourceLoader->register( $modules );
		return true;
	}

	public static function onResourceLoaderTestModules(
		array &$testModules,
		ResourceLoader &$resourceLoader
	) {
		$testModules['qunit']['ext.visualEditor.test'] = array(
			'styles' => array(
				// jsdifflib
				'lib/ve/lib/jsdifflib/diffview.css',
			),
			'scripts' => array(
				// MW config preload
				'modules/ve-mw/test/mw-preload.js',
				// jsdifflib
				'lib/ve/lib/jsdifflib/diffview.js',
				'lib/ve/lib/jsdifflib/difflib.js',
				// QUnit plugin
				'lib/ve/modules/ve/test/ve.qunit.js',
				// UnicodeJS Tests
				'lib/ve/modules/unicodejs/test/unicodejs.test.js',
				'lib/ve/modules/unicodejs/test/unicodejs.graphemebreak.test.js',
				'lib/ve/modules/unicodejs/test/unicodejs.wordbreak.test.js',
				// VisualEditor Tests
				'lib/ve/modules/ve/test/ve.test.utils.js',
				'lib/ve/modules/ve/test/ve.test.js',
				'lib/ve/modules/ve/test/ve.Document.test.js',
				'lib/ve/modules/ve/test/ve.Node.test.js',
				'lib/ve/modules/ve/test/ve.BranchNode.test.js',
				'lib/ve/modules/ve/test/ve.LeafNode.test.js',
				// VisualEditor DataModel Tests
				'lib/ve/modules/ve/test/dm/ve.dm.example.js',
				'lib/ve/modules/ve/test/dm/ve.dm.AnnotationSet.test.js',
				'lib/ve/modules/ve/test/dm/ve.dm.NodeFactory.test.js',
				'lib/ve/modules/ve/test/dm/ve.dm.Node.test.js',
				'lib/ve/modules/ve/test/dm/ve.dm.Converter.test.js',
				'lib/ve/modules/ve/test/dm/ve.dm.BranchNode.test.js',
				'lib/ve/modules/ve/test/dm/ve.dm.LeafNode.test.js',
				'lib/ve/modules/ve/test/dm/ve.dm.LinearData.test.js',
				'lib/ve/modules/ve/test/dm/nodes/ve.dm.TextNode.test.js',
				'modules/ve-mw/test/dm/nodes/ve.dm.MWTransclusionNode.test.js',
				'lib/ve/modules/ve/test/dm/ve.dm.Document.test.js',
				'lib/ve/modules/ve/test/dm/ve.dm.DocumentSynchronizer.test.js',
				'lib/ve/modules/ve/test/dm/ve.dm.IndexValueStore.test.js',
				'lib/ve/modules/ve/test/dm/ve.dm.InternalList.test.js',
				'modules/ve-mw/test/dm/ve.dm.InternalList.test.js',
				'lib/ve/modules/ve/test/dm/ve.dm.Transaction.test.js',
				'modules/ve-mw/test/dm/ve.dm.Transaction.test.js',
				'lib/ve/modules/ve/test/dm/ve.dm.TransactionProcessor.test.js',
				'lib/ve/modules/ve/test/dm/ve.dm.Surface.test.js',
				'lib/ve/modules/ve/test/dm/ve.dm.SurfaceFragment.test.js',
				'modules/ve-mw/test/dm/ve.dm.SurfaceFragment.test.js',
				'lib/ve/modules/ve/test/dm/ve.dm.ModelRegistry.test.js',
				'lib/ve/modules/ve/test/dm/ve.dm.MetaList.test.js',
				'lib/ve/modules/ve/test/dm/ve.dm.Model.test.js',
				'lib/ve/modules/ve/test/dm/lineardata/ve.dm.FlatLinearData.test.js',
				'lib/ve/modules/ve/test/dm/lineardata/ve.dm.ElementLinearData.test.js',
				'lib/ve/modules/ve/test/dm/lineardata/ve.dm.MetaLinearData.test.js',
				'modules/ve-mw/test/dm/ve.dm.mwExample.js',
				'modules/ve-mw/test/dm/ve.dm.MWConverter.test.js',
				// VisualEditor ContentEditable Tests
				'lib/ve/modules/ve/test/ce/ve.ce.test.js',
				'lib/ve/modules/ve/test/ce/ve.ce.Document.test.js',
				'lib/ve/modules/ve/test/ce/ve.ce.Surface.test.js',
				'modules/ve-mw/test/ce/ve.ce.Document.test.js',
				'modules/ve-mw/test/ce/ve.ce.Surface.test.js',
				'lib/ve/modules/ve/test/ce/ve.ce.NodeFactory.test.js',
				'lib/ve/modules/ve/test/ce/ve.ce.Node.test.js',
				'lib/ve/modules/ve/test/ce/ve.ce.BranchNode.test.js',
				'lib/ve/modules/ve/test/ce/ve.ce.ContentBranchNode.test.js',
				'modules/ve-mw/test/ce/ve.ce.ContentBranchNode.test.js',
				'lib/ve/modules/ve/test/ce/ve.ce.LeafNode.test.js',
				'lib/ve/modules/ve/test/ce/nodes/ve.ce.TextNode.test.js',
				// VisualEditor Actions Tests
				'lib/ve/modules/ve/test/ui/actions/ve.ui.FormatAction.test.js',
				'modules/ve-mw/test/ui/actions/ve.ui.FormatAction.test.js',
				'lib/ve/modules/ve/test/ui/actions/ve.ui.IndentationAction.test.js',
				'lib/ve/modules/ve/test/ui/actions/ve.ui.ListAction.test.js',
				// VisualEditor initialization Tests
				'lib/ve/modules/ve/test/init/ve.init.Platform.test.js',
				'modules/ve-mw/test/init/targets/ve.init.mw.ViewPageTarget.test.js',
				// IME tests
				'lib/ve/modules/ve/test/ce/ve.ce.TestRunner.js',
				'lib/ve/modules/ve/test/ce/ve.ce.imetests.test.js',
				'lib/ve/modules/ve/test/ce/imetests/backspace-chromium-ubuntu-none.js',
				'lib/ve/modules/ve/test/ce/imetests/backspace-firefox-ubuntu-none.js',
				'lib/ve/modules/ve/test/ce/imetests/backspace-ie-win-none.js',
				'lib/ve/modules/ve/test/ce/imetests/input-chrome-win-chinese-traditional-handwriting.js',
				'lib/ve/modules/ve/test/ce/imetests/input-chrome-win-greek.js',
				'lib/ve/modules/ve/test/ce/imetests/input-chrome-win-welsh.js',
				'lib/ve/modules/ve/test/ce/imetests/input-chromium-ubuntu-ibus-chinese-cantonese.js',
				'lib/ve/modules/ve/test/ce/imetests/input-chromium-ubuntu-ibus-japanese-anthy--hiraganaonly.js',
				'lib/ve/modules/ve/test/ce/imetests/input-chromium-ubuntu-ibus-korean-korean.js',
				'lib/ve/modules/ve/test/ce/imetests/input-chromium-ubuntu-ibus-malayalam-swanalekha.js',
				'lib/ve/modules/ve/test/ce/imetests/input-firefox-ubuntu-ibus-chinese-cantonese.js',
				'lib/ve/modules/ve/test/ce/imetests/input-firefox-ubuntu-ibus-japanese-anthy--hiraganaonly.js',
				'lib/ve/modules/ve/test/ce/imetests/input-firefox-ubuntu-ibus-korean-korean.js',
				'lib/ve/modules/ve/test/ce/imetests/input-firefox-ubuntu-ibus-malayalam.swanalekha.js',
				'lib/ve/modules/ve/test/ce/imetests/input-firefox-win-chinese-traditional-handwriting.js',
				'lib/ve/modules/ve/test/ce/imetests/input-firefox-win-greek.js',
				'lib/ve/modules/ve/test/ce/imetests/input-firefox-win-welsh.js',
				'lib/ve/modules/ve/test/ce/imetests/input-ie-win-chinese-traditional-handwriting.js',
				'lib/ve/modules/ve/test/ce/imetests/input-ie-win-greek.js',
				'lib/ve/modules/ve/test/ce/imetests/input-ie-win-korean.js',
				'lib/ve/modules/ve/test/ce/imetests/input-ie-win-welsh.js',
				'lib/ve/modules/ve/test/ce/imetests/leftarrow-chromium-ubuntu-none.js',
				'lib/ve/modules/ve/test/ce/imetests/leftarrow-firefox-ubuntu-none.js',
				'lib/ve/modules/ve/test/ce/imetests/leftarrow-ie-win-none.js',
			),
			'dependencies' => array(
				'unicodejs.wordbreak',
				'ext.visualEditor.standalone',
				'ext.visualEditor.core',
				'ext.visualEditor.experimental',
				'ext.visualEditor.viewPageTarget.init',
				'ext.visualEditor.viewPageTarget',
			),
			'localBasePath' => __DIR__,
			'remoteExtPath' => 'VisualEditor',
		);

		return true;
	}

	/**
	 * Ensures that we know whether we're running inside a parser test.
	 */
	public static function onParserTestGlobals( array &$settings ) {
		$settings['wgVisualEditorInParserTests'] = true;
	}
}
