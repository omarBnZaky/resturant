<?php
namespace App\Backend\Transformers;
class CategoryTransformer extends Transformer{
	
	public function transform($category){
		return [
				'category'=> $category['name'],
				'restaurant'=> $category['restaurant']['name']
			];
	}

}