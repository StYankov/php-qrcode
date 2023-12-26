<?php
/**
 * Class QRCodeReaderGDTest
 *
 * @created      12.12.2021
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2021 smiley
 * @license      MIT
 */

namespace wowcher\chillerlan\QRCodeTest;

use wowcher\chillerlan\QRCode\Common\GDLuminanceSource;

/**
 * Tests the GD based reader
 */
final class QRCodeReaderGDTest extends QRCodeReaderTestAbstract{

	protected string $FQN = GDLuminanceSource::class;

}
