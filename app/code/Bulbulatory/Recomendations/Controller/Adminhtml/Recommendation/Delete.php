<?php

namespace Bulbulatory\Recomendations\Controller\Adminhtml\Recommendation;

use Magento\Backend\App\Action\Context;
use Bulbulatory\Recomendations\Api\RecommendationRepositoryInterface;

class Delete extends \Magento\Backend\App\Action
{
    protected $context;
    protected $recommendationRepository;

    public function __construct(
        Context $context,
        RecommendationRepositoryInterface $recommendationRepository
    )
    {
        parent::__construct($context);
        $this->recommendationRepository = $recommendationRepository;
    }

    public function execute()
    {

        $id = $this->getRequest()->getParam('recommendation_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        
        if ($id) {
            try {
                $recommendation = $this->recommendationRepository->getById($id);
                $this->recommendationRepository->delete($recommendation);
                $this->messageManager->addSuccessMessage(__('The recommendation has been deleted.'));
            } catch (LocalizedException $exception) {
                $this->messageManager->addErrorMessage(__('Cannot delete recommendation.'));
            }
        }
        else {
            $this->messageManager->addErrorMessage(__('The recommendation could not be found.'));
        }
        

        return $resultRedirect->setPath('*/*/');
    }
}
