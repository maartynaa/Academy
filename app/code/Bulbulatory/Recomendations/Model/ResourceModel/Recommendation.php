<?php

namespace Bulbulatory\Recomendations\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Recommendation extends AbstractDb
{
	
	protected function _construct()
	{
		$this->_init('bulbulatory_recomendations', 'recommendation_id');
	}
	
}