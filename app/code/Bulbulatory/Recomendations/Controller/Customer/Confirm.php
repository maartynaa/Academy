<?php
namespace Bulbulatory\Recomendations\Controller\Customer;

use Bulbulatory\Recomendations\Api\RecommendationRepositoryInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Confirm extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;
	protected $recommendationRepository;

	public function __construct(
		Context $context,
		PageFactory $pageFactory,
		RecommendationRepositoryInterface $recommendationRepository)
	{
		$this->_pageFactory = $pageFactory;
		$this->recommendationRepository = $recommendationRepository;
		return parent::__construct($context);
	}

	public function execute()
	{
		$hash = $this->getRequest()->getParam('hash');
		$recommendation = $this->recommendationRepository->getByHash($hash);

		try {
            $this->recommendationRepository->confirm($recommendation);
			$this->messageManager->addSuccessMessage(__('Recommendation confirmed successfully.'));
			$this->_redirect('/');
        } catch (NoSuchEntityException $exception) {
            $this->messageManager->addErrorMessage(__('Cannot confirm recommendation'));
            $this->logger->critical('Error message', ['exception' => $exception]);
        }
	}
}