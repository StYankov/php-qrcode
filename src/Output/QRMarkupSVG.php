<?php
/**
 * Class QRMarkupSVG
 *
 * @created      06.06.2022
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2022 smiley
 * @license      MIT
 */

namespace chillerlan\QRCode\Output;

use function array_chunk, implode, is_string, preg_match, sprintf, trim;

/**
 * SVG output
 *
 * @see https://github.com/codemasher/php-qrcode/pull/5
 * @see https://developer.mozilla.org/en-US/docs/Web/SVG
 * @see https://www.sarasoueidan.com/demos/interactive-svg-coordinate-system/
 * @see http://apex.infogridpacific.com/SVG/svg-tutorial-contents.html
 */
class QRMarkupSVG extends QRMarkup{

	/**
	 * @todo: XSS proof
	 *
	 * @see https://developer.mozilla.org/en-US/docs/Web/SVG/Attribute/fill
	 * @inheritDoc
	 */
	public static function moduleValueIsValid($value):bool{

		if(!is_string($value)){
			return false;
		}

		$value = trim($value);

		// url(...)
		if(preg_match('~^url\([-/#a-z\d]+\)$~i', $value)){
			return true;
		}

		// otherwise check for standard css notation
		return parent::moduleValueIsValid($value);
	}

	/**
	 * @inheritDoc
	 */
	protected function getOutputDimensions():array{
		return [$this->moduleCount, $this->moduleCount];
	}

	/**
	 * @inheritDoc
	 */
	protected function createMarkup(bool $saveToFile):string{
		$svg = $this->header();

		if(!empty($this->options->svgDefs)){
			$svg .= sprintf('<defs>%1$s%2$s</defs>%2$s', $this->options->svgDefs, $this->eol);
		}

		$svg .= $this->paths();

		// close svg
		$svg .= sprintf('%1$s</svg>%1$s', $this->eol);

		// transform to data URI only when not saving to file
		if(!$saveToFile && $this->options->outputBase64){
			$svg = $this->toBase64DataURI($svg, 'image/svg+xml');
		}

		return $svg;
	}

	/**
	 * returns the value for the SVG viewBox attribute
	 *
	 * @see https://developer.mozilla.org/en-US/docs/Web/SVG/Attribute/viewBox
	 * @see https://css-tricks.com/scale-svg/#article-header-id-3
	 */
	protected function getViewBox():string{
		[$width, $height] = $this->getOutputDimensions();

		return sprintf('0 0 %s %s', $width, $height);
	}

	/**
	 * returns the <svg> header with the given options parsed
	 *
	 * @see https://developer.mozilla.org/en-US/docs/Web/SVG/Element/svg
	 */
	protected function header():string{

		$header = sprintf(
			'<svg xmlns="http://www.w3.org/2000/svg" class="qr-svg %1$s" viewBox="%2$s" preserveAspectRatio="%3$s">%4$s',
			$this->options->cssClass,
			$this->getViewBox(),
			$this->options->svgPreserveAspectRatio,
			$this->eol
		);

		if($this->options->svgAddXmlHeader){
			$header = sprintf('<?xml version="1.0" encoding="UTF-8"?>%s%s', $this->eol, $header);
		}

		return $header;
	}

	/**
	 * returns one or more SVG <path> elements
	 */
	protected function paths():string{
		$paths = $this->collectModules(fn(int $x, int $y, int $M_TYPE):string => $this->module($x, $y, $M_TYPE));
		$svg   = [];

		// create the path elements
		foreach($paths as $M_TYPE => $modules){
			// limit the total line length
			$chunks = array_chunk($modules, 100);
			$chonks = [];

			foreach($chunks as $chunk){
				$chonks[] = implode(' ', $chunk);
			}

			$path = implode($this->eol, $chonks);

			if(empty($path)){
				continue;
			}

			$svg[] = $this->path($path, $M_TYPE);
		}

		return implode($this->eol, $svg);
	}

	/**
	 * renders and returns a single <path> element
	 *
	 * @see https://developer.mozilla.org/en-US/docs/Web/SVG/Element/path
	 */
	protected function path(string $path, int $M_TYPE):string{

		if($this->options->svgUseFillAttributes){
			return sprintf(
				'<path class="%s" fill="%s" d="%s"/>',
				$this->getCssClass($M_TYPE),
				$this->getModuleValue($M_TYPE),
				$path
			);
		}

		return sprintf('<path class="%s" d="%s"/>', $this->getCssClass($M_TYPE), $path);
	}

	/**
	 * @inheritDoc
	 */
	protected function getCssClass(int $M_TYPE = 0):string{
		return implode(' ', [
			'qr-'.($this::LAYERNAMES[$M_TYPE] ?? $M_TYPE),
			$this->matrix->isDark($M_TYPE) ? 'dark' : 'light',
			$this->options->cssClass,
		]);
	}

	/**
	 * returns a path segment for a single module
	 *
	 * @see https://developer.mozilla.org/en-US/docs/Web/SVG/Attribute/d
	 */
	protected function module(int $x, int $y, int $M_TYPE):string{

		if(!$this->drawLightModules && !$this->matrix->isDark($M_TYPE)){
			return '';
		}

		if($this->drawCircularModules && !$this->matrix->checkTypeIn($x, $y, $this->keepAsSquare)){
			$r = $this->circleRadius;

			return sprintf(
				'M%1$s %2$s a%3$s %3$s 0 1 0 %4$s 0 a%3$s %3$s 0 1 0 -%4$s 0Z',
				($x + 0.5 - $r),
				($y + 0.5),
				$r,
				($r * 2)
			);

		}

		return sprintf('M%1$s %2$s h1 v1 h-1Z', $x, $y);
	}

}
