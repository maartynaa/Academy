<?php
 
namespace Bulbulatory\Recomendations\Api;
 
use Magento\Framework\Api\SearchCriteriaInterface;
use Bulbulatory\Recomendations\Api\Data\RecommendationInterface;
 
interface RecommendationRepositoryInterface
{
    /**
     * @param int $id
     * @return \Bulbulatory\Recomendations\Api\Data\RecommendationInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);

    /**
     * @param string $hash
     * @return \Bulbulatory\Recomendations\Api\Data\RecommendationInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getByHash($hash);
 
    /**
     * @param \Bulbulatory\Recomendations\Api\Data\RecommendationInterface $recommendation
     * @return \Bulbulatory\Recomendations\Api\Data\RecommendationInterface
     */
    public function save(RecommendationInterface $recommendation);
 
    /**
     * @param \Bulbulatory\Recomendations\Api\Data\RecommendationInterface $recommendation
     * @return void
     */
    public function delete(RecommendationInterface $recommendation);

    /**
     * @param \Bulbulatory\Recomendations\Api\Data\RecommendationInterface $recommendation
     * @return \Bulbulatory\Recomendations\Api\Data\RecommendationInterface
     */
    public function confirm(RecommendationInterface $recommendation);

    /**
     * @param $customerId
     * @param $email
     * @param $hash
     * @return \Bulbulatory\Recomendations\Api\Data\RecommendationInterface
     */
    public function create($customerId, $email, $hash); 
 
    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Bulbulatory\Recomendations\Api\Data\RecommendationSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}