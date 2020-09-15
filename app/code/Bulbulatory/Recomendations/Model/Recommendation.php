<?php

namespace Bulbulatory\Recomendations\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Bulbulatory\Recomendations\Api\Data\RecommendationInterface;

class Recommendation extends AbstractExtensibleModel implements RecommendationInterface
{
	// const CACHE_TAG = 'bulbulatory_recomendations_recommendation';
	// protected $_cacheTag = 'bulbulatory_recomendations_recommendation';
	// protected $_eventPrefix = 'bulbulatory_recomendations_recommendation';


	const ID = 'recommendation_id';
    const RECOMMENDER_ID = 'recommender_id';
	const EMAIL = 'email';
	const HASH = 'hash';
	const STATUS = 'status';
	const CREATION_DATE = 'created_at';
	const CONFIRMATION_DATE = 'confirmed_at';
	


	protected function _construct()
	{
		$this->_init(ResourceModel\Recommendation::Class);
	}

	public function getId()
	{
		return $this->_getData(self::ID);
	}

	public function setId($id)
	{
		$this->setData(self::ID, $id);
	}

	public function getRecommenderId()
	{
		return $this->_getData(self::RECOMMENDER_ID);
	}

	public function setRecommenderId($recommender_id)
	{
		$this->setData(self::RECOMMENDER_ID, $recommender_id);
	}

	public function getEmail()
	{
		return $this->_getData(self::EMAIL);
	}

	public function setEmail($email)
	{
		$this->setData(self::EMAIL, $email);
	}

	public function getHash()
	{
		return $this->_getData(self::HASH);
	}

	public function setHash($hash)
	{
		$this->setData(self::HASH, $hash);
	}

	public function getStatus()
	{
		return $this->_getData(self::STATUS);
	}

	public function setStatus($status)
	{
		$this->setData(self::STATUS, $status);
	}

	public function getCreatedAt()
	{
		return $this->_getData(self::CREATION_DATE);
	}

	public function setCreatedAt($created_at)
	{
		$this->setData(self::CREATION_DATE, $created_at);
	}

	public function getConfirmedAt()
	{
		return $this->_getData(self::CONFIRMATION_DATE);
	}

	public function setConfirmedAt($confirmed_at)
	{
		$this->setData(self::CONFIRMATION_DATE, $confirmed_at);
	}

	// public function getIdentities()
	// {
	// 	return [self::CACHE_TAG . '_' . $this->getId()];
	// }

	// public function getDefaultValues()
	// {
	// 	return [];
	// }
}