CategoryTransformer.php


<?php

namespace App\Backend\transformers;

class CategoryTransformer extends Transformer{

	public function transform($category)
	{
		return [
			'category'=> $category['name']
		]
	}
}