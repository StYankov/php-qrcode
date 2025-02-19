<?php
/**
 * Class QRStringJSON
 *
 * @created      25.10.2023
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2023 smiley
 * @license      MIT
 *
 * @noinspection PhpComposerExtensionStubsInspection
 */

namespace wowcher\chillerlan\QRCode\Output;

use function json_encode;

/**
 *
 */
class QRStringJSON extends QROutputAbstract{

	public const MIME_TYPE = 'application/json';

	/**
	 * @inheritDoc
	 * @throws \JsonException
	 */
	public function dump(string $file = null):string{
		$matrix = $this->matrix->getMatrix($this->options->jsonAsBooleans);
		$data   = json_encode($matrix, $this->options->jsonFlags);;

		$this->saveToFile($data, $file);

		return $data;
	}

	/**
	 * unused - required by interface
	 *
	 * @inheritDoc
	 */
	protected function prepareModuleValue($value):string{
		return '';
	}

	/**
	 * unused - required by interface
	 *
	 * @inheritDoc
	 */
	protected function getDefaultModuleValue(bool $isDark):string{
		return '';
	}

	/**
	 * unused - required by interface
	 *
	 * @inheritDoc
	 */
	public static function moduleValueIsValid($value):bool{
		return true;
	}

}
