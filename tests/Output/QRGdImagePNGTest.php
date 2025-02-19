<?php
/**
 * Class QRGdImagePNGTest
 *
 * @created      11.12.2021
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2021 smiley
 * @license      MIT
 */

namespace wowcher\chillerlan\QRCodeTest\Output;

use wowcher\chillerlan\QRCode\Output\QRGdImagePNG;
use wowcher\chillerlan\QRCode\Output\QROutputInterface;

/**
 *
 */
final class QRGdImagePNGTest extends QRGdImageTestAbstract{

	protected string $type = QROutputInterface::GDIMAGE_PNG;
	protected string $FQN  = QRGdImagePNG::class;

}
