
<?php

namespace App\Backend\transformers;

abstract class Transformer {
	
	public function transformCollection()
	{
		return array_map([$this,'transform'],$item);
	}

	public abstract function transform($item);
}