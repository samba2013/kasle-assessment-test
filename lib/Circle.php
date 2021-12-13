<?php


class Circle implements IShape
{

	private $radius;

	public function __construct($arguments)
	{
		$this->radius = isset($arguments['radius'])?$arguments['radius']:0.0;
	}

	public function getAreaValue()
	{
			$shapeAreaValue = pi() * pow($this->radius, 2);
			return $shapeAreaValue;
	}

	//
}

?>