<?php
 
namespace Bulbulatory\Recomendations\Model;
 
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\NoSuchEntityException;
use Bulbulatory\Recomendations\Api\Data\RecommendationInterface;
use Bulbulatory\Recomendations\Api\Data\RecommendationSearchResultInterface;
use Bulbulatory\Recomendations\Api\Data\RecommendationSearchResultInterfaceFactory;
use Bulbulatory\Recomendations\Api\RecommendationRepositoryInterface;
use Bulbulatory\Recomendations\Model\ResourceModel\Recommendation\Collection;
use Bulbulatory\Recomendations\Model\ResourceModel\Recommendation;
 
class RecommendationRepository implements RecommendationRepositoryInterface
{
    /**
     * @var RecommendationResource
     */
    private $recommendationResource;
    
    /**
     * @var RecommendationFactory
     */
    private $recommendationFactory;
 
    /**
     * @var RecommendationSearchResultInterfaceFactory
     */
    private $searchResultFactory;
 
    public function __construct(
        Recommendation $recommendationResource,
        RecommendationFactory $recommendationFactory,
        RecommendationSearchResultInterfaceFactory $recommendationSearchResultInterfaceFactory
    ) {
        $this->recommendationResource = $recommendationResource;
        $this->recommendationFactory = $recommendationFactory;
        $this->searchResultFactory = $recommendationSearchResultInterfaceFactory;
    }

    public function getById($id)
    {
        $recommendation = $this->recommendationFactory->create();
        $this->recommendationResource->load($recommendation, $id);
        if (! $recommendation->getId()) {
            throw new NoSuchEntityException(__('Unable to find recomendation with ID "%1"', $id));
        }
        return $recommendation;
    }
    
    public function getByHash($hash)
    {
        $recommendation = $this->recommendationFactory->create();
        $this->recommendationResource->load($recommendation, $hash, 'hash');
        if (! $recommendation->getHash()) {
            throw new NoSuchEntityException(__('Unable to find recomendation with hash "%1"', $hash));
        }
        return $recommendation;
    }

    public function save(RecommendationInterface $recommendation)
    {
        $this->recommendationResource->save($recommendation);
        return $recommendation;
    }
    
    public function delete(RecommendationInterface $recommendation)
    {
        $this->recommendationResource->delete($recommendation);
    }

    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();
 
        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);
 
        $collection->load();
 
        return $this->buildSearchResult($searchCriteria, $collection);
    }
 
    private function addFiltersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
    }
 
    private function addSortOrdersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ((array) $searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() == SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    private function addPagingToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }
 
    private function buildSearchResult(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $searchResults = $this->searchResultFactory->create();
 
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
 
        return $searchResults;
    }

}