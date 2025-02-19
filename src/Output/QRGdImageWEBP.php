<?php
/**
 * Class QRGdImageWEBP
 *
 * @created      25.10.2023
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2023 smiley
 * @license      MIT
 *
 * @noinspection PhpComposerExtensionStubsInspection
 */

namespace wowcher\chillerlan\QRCode\Output;

use function imagewebp;
use function max;
use function min;

/**
 * GdImage webp output
 *
 * @see \imagewebp()
 */
class QRGdImageWEBP extends QRGdImage{

	public const MIME_TYPE = 'image/webp';

	/**
	 * @inheritDoc
	 */
	protected function renderImage():void{
		imagewebp($this->image, null, max(-1, min(100, $this->options->quality)));
	}

}
