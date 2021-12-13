<?php


class Square implements IShape
{

	private $side_of_length;

	public function __construct($arguments)
	{
		$this->side_of_length = isset($arguments['side_length'])?$arguments['side_length']:0.0;
	}

	public function getAreaValue()
	{
		$shapeAreaValue = pow(floatval($this->side_of_length), 2);
		return $shapeAreaValue;
		
	}


	//
}

?>