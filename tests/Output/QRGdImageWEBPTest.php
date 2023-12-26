<?php
/**
 * Class QRGdImageWEBPTest
 *
 * @created      05.09.2023
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2023 smiley
 * @license      MIT
 */

namespace wowcher\chillerlan\QRCodeTest\Output;

use wowcher\chillerlan\QRCode\Output\QRGdImageWEBP;
use wowcher\chillerlan\QRCode\Output\QROutputInterface;

/**
 *
 */
final class QRGdImageWEBPTest extends QRGdImageTestAbstract{

	protected string $type = QROutputInterface::GDIMAGE_WEBP;
	protected string $FQN  = QRGdImageWEBP::class;

}
