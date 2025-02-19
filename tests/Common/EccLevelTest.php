<?php
/**
 * Class EccLevelTest
 *
 * @created      25.07.2022
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2022 smiley
 * @license      MIT
 */

namespace wowcher\chillerlan\QRCodeTest\Common;

use wowcher\chillerlan\QRCode\Common\EccLevel;
use wowcher\chillerlan\QRCode\Common\MaskPattern;
use wowcher\chillerlan\QRCode\QRCodeException;
use PHPUnit\Framework\TestCase;

/**
 * EccLevel coverage test
 */
final class EccLevelTest extends TestCase{

	public function testConstructInvalidEccException():void{
		$this->expectException(QRCodeException::class);
		$this->expectExceptionMessage('invalid ECC level');
		/** @phan-suppress-next-line PhanNoopNew */
		new EccLevel(69);
	}

	public function testToString():void{
		$ecc = new EccLevel(EccLevel::L);

		$this::assertSame('L', (string)$ecc);
	}

	public function testGetLevel():void{
		$ecc = new EccLevel(EccLevel::L);

		$this::assertSame(EccLevel::L, $ecc->getLevel());
	}

	public function testGetOrdinal():void{
		$ecc = new EccLevel(EccLevel::L);

		$this::assertSame(0, $ecc->getOrdinal());
	}

	public function testGetformatPattern():void{
		$ecc = new EccLevel(EccLevel::Q);

		$this::assertSame(0b010010010110100, $ecc->getformatPattern(new MaskPattern(4)));
	}

	public function getMaxBits():void{
		$ecc = new EccLevel(EccLevel::Q);

		$this::assertSame(4096, $ecc->getMaxBits()[21]);
	}

}
