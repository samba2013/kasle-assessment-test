<?php


class Rectangular implements IShape
{

	private $length;
	private $width;
	
	public function __construct($arguments)
	{
		$this->length = isset($arguments['length'])?$arguments['length']:0.0;;
		$this->width = isset($arguments['width'])?$arguments['width']:0.0;;
	}

	public function getAreaValue()
	{
		$shapeAreaValue = floatval($this->length) * floatval($this->width) ;

		return $shapeAreaValue;
	}


	//
}

?>