<?php
 
namespace Bulbulatory\Recomendations\Block\Recommendation;

use Magento\Customer\Model\Session;
use Bulbulatory\Recomendations\Model\RecommendationRepository;
use Magento\Framework\View\Element\Template;
use Magento\Catalog\Block\Product\Context;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Bulbulatory\Recomendations\Model\ResourceModel\Recommendation\CollectionFactory;
 
class Index extends Template {

    protected $recommendationCollection;
    protected $searchCriteriaBuilder;
    protected $customer;
 
    public function __construct(
        Context $context, 
        CollectionFactory $recommendationCollection,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Session $customer,
        array $data = []
    ) {
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->recommendationCollection = $recommendationCollection;
        $this->customer = $customer->getCustomer();
        parent::__construct($context, $data);
 
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $this->pageConfig->getTitle()->set(__('Recommendation'));

        if ($this->getRecommendationCollection()) {
            $pager = $this->getLayout()->createBlock('Magento\Theme\Block\Html\Pager','custom.recommendation.pager')
                                       ->setAvailableLimit([5 => 5, 10 => 10, 15 => 15, 20 => 20])
                                       ->setShowPerPage(true)
                                       ->setCollection($this->getRecommendationCollection());
            $this->setChild('pager', $pager);
            $this->getRecommendationCollection()->load();
        }
        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    public function getRecommendationCollection()
    {
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        $pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest()->getParam('limit') : 5;

        $customer = $this->customer;
        $recommenderId = $customer->getId();

        $collection = $this->recommendationCollection->create();
        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);
        $collection->addFieldToFilter('recommender_id', $recommenderId);
        return $collection;
    } 

    public function getFormAction()
    {
        return '/recomendations/customer/post';
    }
}