<?php

namespace Bulbulatory\Recomendations\Controller\Adminhtml\Recommendation;

use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\Controller\ResultFactory;
use Bulbulatory\Recomendations\Model\ResourceModel\Recommendation\CollectionFactory;
use Bulbulatory\Recomendations\Api\RecommendationRepositoryInterface;


class MassDelete extends \Magento\Backend\App\Action 
{  
    protected $_filter;
    protected $_collectionFactory;
    protected $_recommendationRepository; 
   
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        RecommendationRepositoryInterface $recommendationRepository
   ) {
        $this->_filter = $filter;
        $this->_collectionFactory = $collectionFactory;
        $this->_recommendationRepository = $recommendationRepository;
        parent::__construct($context);
   }

   public function execute()
    {
        
        $collection = $this->_filter->getCollection($this->_collectionFactory->create());
        $collectionSize = $collection->getSize();
        $recommendationDeleted = 0;

        foreach ($collection as $recommendation) {
            try {
                $id = $recommendation['recommendation_id'];
                $recommendation = $this->_recommendationRepository->getById($id);
                $this->_recommendationRepository->delete($recommendation);
                $recommendationDeleted++;
            } catch (LocalizedException $exception) {
                $this->messageManager->addErrorMessage(__('Cannot delete all selected recommendations.'));
            }
        }

        $this->messageManager->addSuccessMessage(__('A total of %1 element(s) have been deleted.', $recommendationDeleted));

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}