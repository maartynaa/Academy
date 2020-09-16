<?php

namespace Bulbulatory\Recomendations\Controller\Adminhtml\Recommendation;

use Magento\Backend\App\Action\Context;
use Bulbulatory\Recomendations\Api\RecommendationRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;

class Delete extends \Magento\Backend\App\Action
{
    protected $context;
    protected $recommendationRepository;
    private $logger;

    public function __construct(
        Context $context,
        RecommendationRepositoryInterface $recommendationRepository,
        LoggerInterface $logger
    )
    {
        parent::__construct($context);
        $this->recommendationRepository = $recommendationRepository;
        $this->logger = $logger;
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
            } catch (NoSuchEntityException $exception) {
                $this->messageManager->addErrorMessage(__('Cannot delete recommendation with ID %1.', $id));
                $this->logger->critical('Error message', ['exception' => $exception]);
            }
        }
        else {
            $this->messageManager->addErrorMessage(__('Parametr \'recommendation_id\' is missing.'));
        }
        

        return $resultRedirect->setPath('*/*/');
    }
}
