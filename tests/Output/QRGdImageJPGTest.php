<?php
/**
 * Class QRGdImageJPGTest
 *
 * @created      11.12.2021
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2021 smiley
 * @license      MIT
 */

namespace wowcher\chillerlan\QRCodeTest\Output;

use wowcher\chillerlan\QRCode\Output\QRGdImageJPEG;
use wowcher\chillerlan\QRCode\Output\QROutputInterface;

/**
 *
 */
final class QRGdImageJPGTest extends QRGdImageTestAbstract{

	protected string $type = QROutputInterface::GDIMAGE_JPG;
	protected string $FQN  = QRGdImageJPEG::class;

}
