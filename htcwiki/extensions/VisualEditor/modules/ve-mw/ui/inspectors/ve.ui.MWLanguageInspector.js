/*!
 * VisualEditor UserInterface LanguageInspector class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MWLanguage inspector.
 *
 * @class
 * @extends ve.ui.LanguageInspector
 *
 * @constructor
 * @param {ve.ui.Surface} surface
 * @param {Object} [config] Configuration options
 */
ve.ui.MWLanguageInspector = function VeUiMWLanguageInspector( surface, config ) {
	// Parent constructor
	ve.ui.LanguageInspector.call( this, surface, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWLanguageInspector, ve.ui.LanguageInspector );

/* Static Properties */

ve.ui.MWLanguageInspector.static.languageInputWidget = ve.ui.MWLanguageInputWidget;

/* Registration */

ve.ui.inspectorFactory.register( ve.ui.MWLanguageInspector );
