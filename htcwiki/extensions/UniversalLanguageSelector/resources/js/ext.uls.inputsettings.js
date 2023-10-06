/**
 * ULS-based ime settings panel
 *
 * Copyright (C) 2012 Alolita Sharma, Amir Aharoni, Arun Ganesh, Brandon Harris,
 * Niklas Laxström, Pau Giner, Santhosh Thottingal, Siebrand Mazeland and other
 * contributors. See CREDITS for a list.
 *
 * UniversalLanguageSelector is dual licensed GPLv2 or later and MIT. You don't
 * have to do anything special to choose one license or the other and you don't
 * have to notify anyone which license you are using. You are free to use
 * UniversalLanguageSelector in commercial projects as long as the copyright
 * header is left intact. See files GPL-LICENSE and MIT-LICENSE for details.
 *
 * @file
 * @ingroup Extensions
 * @licence GNU General Public Licence 2.0 or later
 * @licence MIT License
 */

( function ( $, mw, undefined ) {
	'use strict';

	var template = '<div class="uls-input-settings">'
		+ '<div class="row">' // Top "Display settings" title
		+ '<div class="twelve columns">'
		+ '<h3 data-i18n="ext-uls-input-settings-title"></h3>'
		+ '</div>'
		+ '</div>'

		// "Language for ime", title above the buttons row
		+ '<div class="row uls-input-settings-languages-title">'
		+ '<div class="eleven columns">'
		+ '<h4 data-i18n="ext-uls-input-settings-ui-language"></h4>'
		+ '</div>'
		+ '</div>'

		// UI languages buttons row
		+ '<div class="row">'
		+ '<div class="uls-ui-languages eleven columns"></div>'
		+ '</div>'

		// Web IMEs enabling chechbox with label
		+ '<div class="row">'
		+ '<div class="eleven columns uls-input-settings-inputmethods-list">'
		// "Input settings for language xyz" title
		+ '<h4 class="ext-uls-input-settings-imes-title"></h4>'
		+ '</div>'
		+ '</div>'

		// Disable IME system button
		+ '<div class="row">'
		+ '<div class="eleven columns button uls-input-settings-disable-info"></div>'
		+ '<div class="six columns button uls-input-settings-toggle">'
		+ '<button class="active green button uls-input-toggle-button"></button>'
		+ '</div>'
		+ '</div>'

		// Separator
		+ '<div class="row"></div>'

		// Apply and Cancel buttons
		+ '<div class="row language-settings-buttons">'
		+ '<div class="eleven columns">'
		+ '<button class="button uls-input-settings-close" data-i18n="ext-uls-language-settings-cancel"></button>'
		+ '<button class="active blue button uls-input-settings-apply" data-i18n="ext-uls-language-settings-apply" disabled></button>'
		+ '</div>'
		+ '</div>'
		+ '</div>';

	function InputSettings( $parent ) {
		this.name = $.i18n( 'ext-uls-input-settings-title-short' );
		this.description = $.i18n( 'ext-uls-input-settings-desc' );
		this.$template = $( template );
		this.imeLanguage = this.getImeLanguage();
		this.contentLanguage = this.getContentLanguage();
		this.$imes = null;
		this.$parent = $parent;
	}

	InputSettings.prototype = {

		Constructor: InputSettings,

		/**
		 * Render the module into a given target
		 */
		render: function () {
			this.$parent.$settingsPanel.empty();
			this.$imes = $( 'body' ).data( 'ime' );
			this.$parent.$settingsPanel.append( this.$template );
			if ( $.ime.preferences.isEnabled() ) {
				this.prepareLanguages();
				this.prepareInputmethods( this.imeLanguage );
			} else {

				// Hide the language list
				this.$template.find( 'div.uls-input-settings-languages-title' ).hide();
				this.$template.find( 'div.uls-ui-languages' ).hide();

				// Hide input methods
				this.$template.find( 'div.uls-input-settings-inputmethods-list' ).hide();
			}
			this.prepareToggleButton();
			this.$template.i18n();
			this.listen();
		},

		/**
		 * Enable the apply button.
		 * Useful in many places when something changes.
		 */
		enableApplyButton: function () {
			this.$template.find( 'button.uls-input-settings-apply' ).removeAttr( 'disabled' );
		},

		prepareInputmethods: function ( language ) {
			var index = 0,
				inputSettings, $imeListContainer, defaultInputmethod, imes, selected, imeId,
				$imeListTitle;

			imes = $.ime.languages[language];
			this.imeLanguage = language;

			$imeListTitle = this.$template.find( '.ext-uls-input-settings-imes-title' );

			$imeListContainer = this.$template.find( '.uls-input-settings-inputmethods-list' );
			$imeListContainer.show();

			$imeListContainer.find( 'label' ).remove();

			if ( !imes ) {
				$imeListContainer.append( $( '<label>' )
					.addClass( 'uls-input-settings-no-inputmethods' )
					.text( $.i18n( 'ext-uls-input-settings-noime' ) ) );
				$imeListTitle.text( '' );
				return;
			}

			$imeListTitle.text( $.i18n( 'ext-uls-input-settings-ime-settings',
				$.uls.data.getAutonym( language ) ) );

			inputSettings = this;

			defaultInputmethod = $.ime.preferences.getIM( language ) || imes.inputmethods[0];

			for ( index in imes.inputmethods ) {
				imeId = imes.inputmethods[index];
				selected = defaultInputmethod === imeId;
				//$.ime.load( imeId, function () {
				$imeListContainer.append( inputSettings.renderInputmethodOption( imeId,
					selected ) );
				//} );
			}

			$imeListContainer.append( inputSettings.renderInputmethodOption( 'system',
				defaultInputmethod === 'system' ) );
		},

		renderInputmethodOption: function ( imeId, selected ) {
			var $imeLabel, name, description, inputmethod, $inputMethodItem;

			$imeLabel = $( '<label>' ).attr( {
				'for': imeId,
				'class': 'imelabel'
			} );

			$inputMethodItem = $( '<input type="radio">' ).attr( {
				name: 'ime',
				id: imeId,
				value: imeId,
				checked: selected
			} );

			$imeLabel.append( $inputMethodItem );

			if ( imeId === 'system' ) {
				name = $.i18n( 'ext-uls-disable-input-method' );
				description = $.i18n( 'ext-uls-disable-input-method-desc' );
			} else {
				inputmethod = $.ime.inputmethods[imeId];
				if ( !inputmethod ) {
					// Delay in registration?
					name = $.ime.sources[imeId].name;
					description = '';
				} else {
					name = inputmethod.name;
					description = $.ime.inputmethods[imeId].description;
				}
			}

			$imeLabel
				.append( $( '<strong>' ).text( name ) )
				.append( $( '<span>' ).text( description ) );

			return $imeLabel;
		},

		/**
		 * Prepare the UI language selector
		 */
		prepareLanguages: function () {
			var inputSettings = this,
				languagesForButtons, $languages, suggestedLanguages,
				SUGGESTED_LANGUAGES_NUMBER, lang, i, language, $button, $caret;

			SUGGESTED_LANGUAGES_NUMBER = 3;
			$languages = this.$template.find( 'div.uls-ui-languages' );
			this.$template.find( 'div.uls-ui-languages' ).show();
			this.$template.find( 'div.uls-input-settings-languages-title' ).show();

			suggestedLanguages = this.frequentLanguageList()
				// Common world languages, for the case that there are
				// too few suggested languages
				.concat( [ 'en', 'zh', 'fr' ] );

			// Content language is always on the first button
			languagesForButtons = [ this.contentLanguage ];

			// This is needed when drawing the panel for the second time
			// after selecting a different language
			$languages.empty();

			// UI language must always be present
			if ( this.imeLanguage !== this.contentLanguage ) {
				languagesForButtons.push( this.imeLanguage );
			}

			for ( lang in suggestedLanguages ) {
				// Skip already found languages
				if ( $.inArray( suggestedLanguages[lang], languagesForButtons ) > -1 ) {
					continue;
				}

				languagesForButtons.push( suggestedLanguages[lang] );

				// No need to add more languages than buttons
				if ( languagesForButtons.length === SUGGESTED_LANGUAGES_NUMBER ) {
					break;
				}
			}

			function buttonHandler( button ) {
				return function () {
					var selectedLanguage = button.data( 'language' ) || inputSettings.imeLanguage;

					inputSettings.enableApplyButton();
					$.ime.preferences.setLanguage( selectedLanguage );
					$( 'div.uls-ui-languages button.button' ).removeClass( 'down' );
					button.addClass( 'down' );
					inputSettings.prepareInputmethods( selectedLanguage );
				};
			}

			// Add the buttons for the most likely languages
			for ( i = 0; i < SUGGESTED_LANGUAGES_NUMBER; i++ ) {
				language = languagesForButtons[i];
				$button = $( '<button>' )
					.addClass( 'button uls-language-button' )
					.text( $.uls.data.getAutonym( language ) )
					.prop( {
						lang: language,
						dir: $.uls.data.getDir( language )
					} );

				if ( language === this.imeLanguage ) {
					$button.addClass( 'down' );
				}

				$button.data( 'language', language );
				$caret = $( '<span>' ).addClass( 'uls-input-settings-caret' );

				$languages.append( $button ).append( $caret );

				$button.on( 'click', buttonHandler( $button ) );
			}

			this.prepareMoreLanguages();
		},

		/**
		 * Prepare the more languages button. It is a ULS trigger
		 */
		prepareMoreLanguages: function () {
			var inputSettings = this,
				$languages, $moreLanguagesButton;

			$languages = this.$template.find( 'div.uls-ui-languages' );
			$moreLanguagesButton = $( '<button>' )
				.prop( 'id', 'uls-more-languages' )
				.addClass( 'button' ).text( '...' );

			$languages.append( $moreLanguagesButton );
			// Show the long language list to select a language for ime settings
			$moreLanguagesButton.uls( {
				left: inputSettings.$parent.left,
				top: inputSettings.$parent.top,
				onReady: function () {
					var uls = this,
						$back = $( '<a>' )
							.data( 'i18n', 'ext-uls-back-to-input-settings' )
							.i18n();

					$back.click( function () {
						uls.hide();
						inputSettings.$parent.show();
					} );

					uls.$menu.find( 'div.uls-title-region' ).append( $back );
					uls.$menu.find( 'h1.uls-title' )
						.data( 'i18n', 'ext-uls-input-settings-ui-language' )
						.i18n();
				},
				onSelect: function ( langCode ) {
					inputSettings.enableApplyButton();
					inputSettings.imeLanguage = langCode;
					inputSettings.$parent.show();
					inputSettings.prepareLanguages();
					inputSettings.prepareInputmethods( langCode );
				},
				languages: mw.ime.getLanguagesWithIME(),
				lazyload: false
			} );

			$moreLanguagesButton.on( 'click', function () {
				inputSettings.$parent.hide();
			} );
		},

		prepareToggleButton: function () {
			var inputSettings, $toggleButton, $toggleButtonDesc;

			inputSettings = this;

			$toggleButton = inputSettings.$template
				.find( 'button.uls-input-toggle-button' );

			$toggleButtonDesc = inputSettings.$template
				.find( 'div.uls-input-settings-disable-info' );

			if ( $.ime.preferences.isEnabled() ) {
				$toggleButton.data( 'i18n', 'ext-uls-input-disable' );
				$toggleButtonDesc.hide();
			} else {
				$toggleButton.data( 'i18n', 'ext-uls-input-enable' );
				$toggleButtonDesc.data( 'i18n', 'ext-uls-input-disable-info' ).show();
			}

			$toggleButton.i18n();
			$toggleButtonDesc.i18n();
		},

		/**
		 * Get previous languages
		 * @returns {Array}
		 */
		frequentLanguageList: function () {
			return mw.uls.getFrequentLanguageList();
		},

		/**
		 * Get the current user interface language.
		 * @returns String Current UI language
		 */
		// XXX: Probably bad name
		getImeLanguage: function () {
			return mw.config.get( 'wgUserLanguage' );
		},

		/**
		 * Get the current content language.
		 * @returns String Current content language
		 */
		getContentLanguage: function () {
			return mw.config.get( 'wgContentLanguage' );
		},

		/**
		 * Register general event listeners
		 */
		listen: function () {
			var inputSettings = this,
				$imeListContainer;

			$imeListContainer = this.$template.find( '.uls-input-settings-inputmethods-list' );

			// Apply and close buttons
			inputSettings.$template.find( 'button.uls-input-settings-apply' ).on( 'click', function () {
				inputSettings.apply();
			} );

			inputSettings.$template.find( 'button.uls-input-settings-close' ).on( 'click', function () {
				inputSettings.close();
			} );

			$imeListContainer.on( 'change', 'input:radio[name=ime]:checked', function () {
				inputSettings.enableApplyButton();
				$.ime.preferences.setLanguage( inputSettings.imeLanguage );
				$.ime.preferences.setIM( $( this ).val() );
			} );

			inputSettings.$template.find( 'button.uls-input-toggle-button' )
				.on( 'click', function () {
					inputSettings.enableApplyButton();
					if ( $.ime.preferences.isEnabled() ) {
						inputSettings.disableInputTools();
					} else {
						inputSettings.enableInputTools();
					}
				} );
		},

		/**
		 * Disable input tools
		 */
		disableInputTools: function () {
			var inputSettings = this;

			$.ime.preferences.disable();
			$.ime.preferences.save( function () {
				mw.ime.disable();
				// render this again.
				inputSettings.render();
			} );
		},

		/**
		 * Enable input tools
		 */
		enableInputTools: function () {
			var inputSettings = this;

			$.ime.preferences.enable();
			$.ime.preferences.save( function () {
				mw.ime.setup();
				// render this again.
				inputSettings.render();
			} );

		},

		/**
		 * Hide this window.
		 * Used while navigating to language selector and need coming back
		 */
		hide: function () {
			this.$parent.hide();
		},

		/**
		 * Close the language settings window.
		 * Depending on the context, actions vary.
		 */
		close: function () {
			this.$parent.close();
		},

		/**
		 * Callback for save preferences
		 */
		onSave: function ( success ) {
			if ( success ) {
				// Live ime update
				this.$parent.hide();
			} else {
				// FIXME failure. what to do?!
			}
		},

		/**
		 * Handle the apply button press
		 */
		apply: function () {
			var inputSettings = this;

			// Save the preferences
			$.ime.preferences.save( function ( result ) {
				// closure for not losing the scope
				inputSettings.onSave( result );
			} );
		}
	};

	// Register this module to language settings modules
	$.fn.languagesettings.modules = $.extend( $.fn.languagesettings.modules, {
		input: InputSettings
	} );

} ( jQuery, mediaWiki ) );

