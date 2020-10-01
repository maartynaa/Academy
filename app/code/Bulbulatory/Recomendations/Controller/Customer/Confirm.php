<?php
namespace Bulbulatory\Recomendations\Controller\Customer;

use Bulbulatory\Recomendations\Api\RecommendationRepositoryInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Stdlib\DateTime\DateTime;

class Confirm extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;
	protected $recommendationRepository;
	protected $date;

	public function __construct(
		Context $context,
		PageFactory $pageFactory,
		RecommendationRepositoryInterface $recommendationRepository,
		DateTime $date)
	{
		$this->_pageFactory = $pageFactory;
		$this->recommendationRepository = $recommendationRepository;
		$this->date = $date;
		return parent::__construct($context);
	}

	public function execute()
	{
		$hash = $this->getRequest()->getParam('hash');
		$recommendation = $this->recommendationRepository->getByHash($hash);
		$recommendation->setStatus(1);
		$date = $this->date->gmtDate();
		$recommendation->setConfirmedAt($date);

		try {
            $this->recommendationRepository->save($recommendation);
			$this->messageManager->addSuccessMessage(__('Recommendation confirmed successfully.'));
			$this->_redirect('customer/account');
        } catch (NoSuchEntityException $exception) {
            $this->messageManager->addErrorMessage(__('Cannot confirm recommendation'));
            $this->logger->critical('Error message', ['exception' => $exception]);
        }
	}
}