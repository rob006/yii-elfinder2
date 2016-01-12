<?php

/**
 * Helper class for elFinder widgets
 *
 * @author Robert Korulczyk <robert@korulczyk.pl>
 * @link http://rob006.net/
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
class ElFinderHelper extends CComponent {

	/**
	 * Available elFinder translations
	 * @see directory: assets/js/i18n
	 * @var array
	 */
	public static $availableLanguages = array(
		'ar',
		'bg',
		'ca',
		'cs',
		'da',
		'de',
		'el',
		'es',
		'fa',
		'fr',
		'he',
		'hu',
		'id',
		'it',
		'jp',
		'ko',
		'nl',
		'no',
		'pl',
		'pt_BR',
		'ro',
		'ru',
		'sk',
		'sl',
		'sr',
		'sv',
		'tr',
		'uk',
		'vi',
		'zh_CN',
		'zh_TW',
	);

	/**
	 * Register necessary elFinder scripts and styles
	 */
	public static function registerAssets() {
		self::registerAlias();
		$dir = Yii::getPathOfAlias('elFindervendor.assets');
		$assetsDir = Yii::app()->getAssetManager()->publish($dir);
		$cs = Yii::app()->getClientScript();

		if (Yii::app()->getRequest()->enableCsrfValidation) {
			$csrfTokenName = Yii::app()->request->csrfTokenName;
			$csrfToken = Yii::app()->request->csrfToken;
			$cs->registerMetaTag($csrfToken, 'csrf-token', null, array(), 'csrf-token');
			$cs->registerMetaTag($csrfTokenName, 'csrf-param', null, array(), 'csrf-param');
		}

		// jQuery and jQuery UI
		$cs->registerCoreScript('jquery');
		$cs->registerCoreScript('jquery.ui');
		$cs->registerCssFile($cs->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css');

		// elFinder CSS
		if (YII_DEBUG) {
			$cs->registerCssFile($assetsDir . '/css/elfinder.full.css');
		} else {
			$cs->registerCssFile($assetsDir . '/css/elfinder.min.css');
		}

		// elFinder JS
		if (YII_DEBUG) {
			$cs->registerScriptFile($assetsDir . '/js/elfinder.full.js');
		} else {
			$cs->registerScriptFile($assetsDir . '/js/elfinder.min.js');
		}

		// elFinder translation
		$lang = Yii::app()->language;
		if (!in_array($lang, self::$availableLanguages)) {
			if (strpos($lang, '_')) {
				$lang = substr($lang, 0, strpos($lang, '_'));
				if (!in_array($lang, self::$availableLanguages)) {
					$lang = false;
				}
			} else {
				$lang = false;
			}
		}
		if ($lang !== false) {
			$cs->registerScriptFile($assetsDir . '/js/i18n/elfinder.' . $lang . '.js');
		}

		// some css fixes
		Yii::app()->clientScript->registerCss('elfinder-file-bg-fixer', '.elfinder-cwd-file,.elfinder-cwd-file .elfinder-cwd-file-wrapper,.elfinder-cwd-file .elfinder-cwd-filename{background-image:none !important;}');
	}

	public static function registerAlias() {
		if (!Yii::getPathOfAlias('elFinder')) {
			Yii::setPathOfAlias('elFinder', dirname(__FILE__));
		}
		if (!Yii::getPathOfAlias('elFindervendor')) {
			Yii::setPathOfAlias('elFindervendor', Yii::getPathOfAlias('elFinder.vendor'));
		}
	}

}
