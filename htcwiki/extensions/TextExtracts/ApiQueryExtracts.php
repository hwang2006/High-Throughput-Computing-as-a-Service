<?php
/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

class ApiQueryExtracts extends ApiQueryBase {
	/**
	 * @var ParserOptions
	 */
	private $parserOptions;
	private $params;
	/**
	 * @var Config
	 */
	private $config;

	public function __construct( $query, $moduleName, Config $conf ) {
		parent::__construct( $query, $moduleName, 'ex' );
		$this->config = $conf;
	}

	public function execute() {
		wfProfileIn( __METHOD__ );
		$titles = $this->getPageSet()->getGoodTitles();
		if ( count( $titles ) == 0 ) {
			wfProfileOut( __METHOD__ );
			return;
		}
		$isXml = $this->getMain()->isInternalMode() || $this->getMain()->getPrinter()->getFormat() == 'XML';
		$result = $this->getResult();
		$params = $this->params = $this->extractRequestParams();
		$this->requireMaxOneParameter( $params, 'chars', 'sentences' );
		$continue = 0;
		$limit = intval( $params['limit'] );
		if ( $limit > 1 && !$params['intro'] ) {
			$limit = 1;
			$result->setWarning( "exlimit was too large for a whole article extracts request, lowered to $limit" );
		}
		if ( isset( $params['continue'] ) ) {
			$continue = intval( $params['continue'] );
			if ( $continue < 0 || $continue > count( $titles ) ) {
				$this->dieUsageMsg( '_badcontinue' );
			}
			$titles = array_slice( $titles, $continue, null, true );
		}
		$count = 0;
		/** @var Title $t */
		foreach ( $titles as $id => $t ) {
			if ( ++$count > $limit ) {
				$this->setContinueEnumParameter( 'continue', $continue + $count - 1 );
				break;
			}
			$text = $this->getExtract( $t );
			$text = $this->truncate( $text );
			if ( $this->params['plaintext'] ) {
				$text = $this->doSections( $text );
			}

			if ( $isXml ) {
				$fit = $result->addValue( array( 'query', 'pages', $id ), 'extract', array( '*' => $text ) );
			} else {
				$fit = $result->addValue( array( 'query', 'pages', $id ), 'extract', $text );
			}
			if ( !$fit ) {
				$this->setContinueEnumParameter( 'continue', $continue + $count - 1 );
				break;
			}
		}
		wfProfileOut( __METHOD__ );
	}

	public function getCacheMode( $params ) {
		return 'public';
	}

	/**
	 * OpenSearchXml hook handler
	 * @param array $results
	 * @return bool
	 */
	public static function onOpenSearchXml( &$results ) {
		$config = ConfigFactory::getDefaultInstance()->makeConfig( 'textextracts' );
		if ( !$config->get( 'ExtractsExtendOpenSearchXml' ) || !count( $results ) ) {
			return true;
		}
		$pageIds = array_keys( $results );
		$api = new ApiMain( new FauxRequest(
			array(
				'action' => 'query',
				'prop' => 'extracts',
				'explaintext' => true,
				'exintro' => true,
				'exlimit' => count( $results ),
				'pageids' => implode( '|', $pageIds ),
			) )
		);
		$api->execute();
		$data = $api->getResultData();
		foreach ( $pageIds as $id ) {
			if ( isset( $data['query']['pages'][$id]['extract']['*'] ) ) {
				$results[$id]['extract'] = $data['query']['pages'][$id]['extract']['*'];
				$results[$id]['extract trimmed'] = false;
			}
		}
		return true;
	}

	/**
	 * Returns a processed, but not trimmed extract
	 * @param Title $title
	 * @return string
	 */
	private function getExtract( Title $title ) {
		wfProfileIn( __METHOD__ );
		$page = WikiPage::factory( $title );

		$introOnly = $this->params['intro'];
		$text = $this->getFromCache( $page, $introOnly );
		// if we need just first section, try retrieving full page and getting first section out of it
		if ( $text === false && $introOnly ) {
			$text = $this->getFromCache( $page, false );
			if ( $text !== false ) {
				$text = $this->getFirstSection( $text, $this->params['plaintext'] );
			}
		}
		if ( $text === false ) {
			$text = $this->parse( $page );
			$text = $this->convertText( $text, $title, $this->params['plaintext'] );
			$this->setCache( $page, $text );
		}
		wfProfileOut( __METHOD__ );
		return $text;
	}

	private function cacheKey( WikiPage $page, $introOnly ) {
		return wfMemcKey( 'mf', 'extract', $page->getLatest(),
			$page->getTitle()->getPageLanguage()->getPreferredVariant(),
			$this->params['plaintext'], $introOnly
		);
	}

	private function getFromCache( WikiPage $page, $introOnly ) {
		global $wgMemc;

		$key = $this->cacheKey( $page, $introOnly );
		return $wgMemc->get( $key );
	}

	private function setCache( WikiPage $page, $text ) {
		global $wgMemc;

		$key = $this->cacheKey( $page, $this->params['intro'] );
		$wgMemc->set( $key, $text );
	}

	private function getFirstSection( $text, $plainText ) {
		if ( $plainText ) {
			$regexp = '/^(.*?)(?=' . ExtractFormatter::SECTION_MARKER_START . ')/s';
		} else {
			$regexp = '/^(.*?)(?=<h[1-6]\b)/s';
		}
		if ( preg_match( $regexp, $text, $matches ) ) {
			$text = $matches[0];
		}
		return $text;
	}

	/**
	 * Returns page HTML
	 * @param WikiPage $page
	 * @return string
	 */
	private function parse( WikiPage $page ) {
		wfProfileIn( __METHOD__ );
		if ( !$this->parserOptions ) {
			$this->parserOptions = new ParserOptions( new User( '127.0.0.1' ) );
		}
		// first try finding full page in parser cache
		if ( $page->isParserCacheUsed( $this->parserOptions, 0 ) ) {
			$pout = ParserCache::singleton()->get( $page, $this->parserOptions );
			if ( $pout ) {
				$pout->setTOCEnabled( false );
				$text = $pout->getText();
				if ( $this->params['intro'] ) {
					$text = $this->getFirstSection( $text, false );
				}
				wfProfileOut( __METHOD__ );
				return $text;
			}
		}
		$request = array(
			'action' => 'parse',
			'page' => $page->getTitle()->getPrefixedText(),
			'prop' => 'text'
		);
		if ( $this->params['intro'] ) {
			$request['section'] = 0;
		}
		// in case of cache miss, render just the needed section
		$api = new ApiMain( new FauxRequest( $request )	);
		$api->execute();
		$data = $api->getResultData();
		wfProfileOut( __METHOD__ );
		return $data['parse']['text']['*'];
	}

	/**
	 * Converts page HTML into an extract
	 * @param string $text
	 * @return string
	 */
	private function convertText( $text ) {
		wfProfileIn( __METHOD__ );
		$fmt = new ExtractFormatter(
			$text,
			$this->params['plaintext'],
			$this->config
		);
		$text = $fmt->getText();

		wfProfileOut( __METHOD__ );
		return trim( $text );
	}

	/**
	 * Truncate the given text to a certain number of characters or sentences
	 * @param string $text The text to truncate
	 * @return string
	 */
	private function truncate( $text ) {
		if ( $this->params['chars'] ) {
			return $this->getFirstChars( $text, $this->params['chars'] );
		} elseif ( $this->params['sentences'] ) {
			return $this->getFirstSentences( $text, $this->params['sentences'] );
		}
		return $text;
	}

	/**
	 * Returns no more than a requested number of characters
	 * @param string $text
	 * @param int $requestedLength
	 * @return string
	 */
	private function getFirstChars( $text, $requestedLength ) {
		wfProfileIn( __METHOD__ );
		$text = ExtractFormatter::getFirstChars( $text, $requestedLength );
		// Fix possibly unclosed tags
		$text = $this->tidy( $text );
		$text .= wfMessage( 'ellipsis' )->inContentLanguage()->text();
		wfProfileOut( __METHOD__ );
		return $text;
	}

	/**
	 * @param string $text
	 * @param int $requestedSentenceCount
	 * @return string
	 */
	private function getFirstSentences( $text, $requestedSentenceCount ) {
		wfProfileIn( __METHOD__ );

		$text = ExtractFormatter::getFirstSentences( $text, $requestedSentenceCount );
		$text = $this->tidy( $text );
		wfProfileOut( __METHOD__ );
		return $text;
	}

	/**
	 * A simple wrapper around tidy
	 * @param string $text
	 * @return string
	 */
	private function tidy( $text ) {
		wfProfileIn( __METHOD__ );
		if ( $this->getConfig()->get( 'UseTidy' ) && !$this->params['plaintext'] ) {
			$text = trim ( MWTidy::tidy( $text ) );
		}
		wfProfileOut( __METHOD__ );
		return $text;
	}

	private function doSections( $text ) {
		$text = preg_replace_callback(
			"/" . ExtractFormatter::SECTION_MARKER_START . '(\d)'. ExtractFormatter::SECTION_MARKER_END . "(.*?)$/m",
			array( $this, 'sectionCallback' ),
			$text
		);
		return $text;
	}

	private function sectionCallback( $matches ) {
		if ( $this->params['sectionformat'] == 'raw' ) {
			return $matches[0];
		}
		$func = __CLASS__ . "::doSection_{$this->params['sectionformat']}";
		return call_user_func( $func, $matches[1], trim( $matches[2] ) );
	}

	private static function doSection_wiki( $level, $text ) {
		$bars = str_repeat( '=', $level );
		return "\n$bars $text $bars";
	}

	private static function doSection_plain( $level, $text ) {
		return "\n$text";
	}

	public function getAllowedParams() {
		return array(
			'chars' => array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_MIN => 1,
			),
			'sentences' => array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_MIN => 1,
				ApiBase::PARAM_MAX => 10,
			),
			'limit' => array(
				ApiBase::PARAM_DFLT => 1,
				ApiBase::PARAM_TYPE => 'limit',
				ApiBase::PARAM_MIN => 1,
				ApiBase::PARAM_MAX => 20,
				ApiBase::PARAM_MAX2 => 20,
			),
			'intro' => false,
			'plaintext' => false,
			'sectionformat' => array(
				ApiBase::PARAM_TYPE => array( 'plain', 'wiki', 'raw' ),
				ApiBase::PARAM_DFLT => 'wiki',
			),
			'continue' => array(
				ApiBase::PARAM_TYPE => 'integer',
			),
			// Used implicitly by LanguageConverter
			'variant' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_DFLT => false,
			),
		);
	}

	public function getParamDescription() {
		return array(
			'chars' => 'How many characters to return, actual text returned might be slightly longer.',
			'sentences' => 'How many sentences to return',
			'limit' => 'How many extracts to return',
			'intro' => 'Return only content before the first section',
			'plaintext' => 'Return extracts as plaintext instead of limited HTML',
			'sectionformat' => array(
				'How to format sections in plaintext mode:',
				' plain - No formatting',
				' wiki - Wikitext-style formatting == like this ==',
				" raw - This module's internal representation (section titles prefixed with <ASCII 1><ASCII 2><section level><ASCII 2><ASCII 1>",
			),
			'continue' => 'When more results are available, use this to continue',
			'variant' => 'Convert content into this language variant`',
		);
	}

	public function getDescription() {
		return 'Returns plain-text or limited HTML extracts of the given page(s)';
	}

	public function getExamples() {
		return array(
			'api.php?action=query&prop=extracts&exchars=175&titles=Therion' => 'Get a 175-character extract',
		);
	}


	public function getHelpUrls() {
		return 'https://www.mediawiki.org/wiki/Extension:TextExtracts#API';
	}
}
