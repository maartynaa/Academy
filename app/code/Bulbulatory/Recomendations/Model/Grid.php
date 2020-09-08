<?php

namespace Bulbulatory\Recomendations\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;

class Grid extends AbstractModel implements IdentityInterface
{
	const CACHE_TAG = 'bulbulatory_recomendations_recommendation';
	protected $_cacheTag = 'bulbulatory_recomendations_recommendation';
	protected $_eventPrefix = 'bulbulatory_recomendations_recommendation';

	protected function _construct()
	{
		$this->_init(Bulbulatory\Recomendations\Model\ResourceModel\Grid::Class);
	}

	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	public function getDefaultValues()
	{
		return [];
	}
}
