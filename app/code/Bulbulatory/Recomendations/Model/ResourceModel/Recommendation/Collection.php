<?php

namespace Bulbulatory\Recomendations\Model\ResourceModel\Recommendation;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
	protected $_idFieldName = 'recommendation_id';
	protected $_eventPrefix = 'bulbulatory_recomendations_collection';
	protected $_eventObject = 'recomendations_collection';


	protected function _construct()
	{
		$this->_init(Bulbulatory\Recomendations\Model\Recommendation::Class, 
					 Bulbulatory\Recomendations\Model\ResourceModel\Recommendation::Class);
	}

}

