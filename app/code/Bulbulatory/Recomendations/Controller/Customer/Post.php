<?php
namespace Bulbulatory\Recomendations\Controller\Customer;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Math\Random;
use Psr\Log\LoggerInterface;
use Bulbulatory\Recomendations\Helper\Email;
use Bulbulatory\Recomendations\Api\RecommendationRepositoryInterface;

 
class Post extends \Magento\Framework\App\Action\Action
{     
    protected $_logLoggerInterface;
    protected $helperEmail;
    protected $recommendationRepository;	
    protected $customer;
    protected $random;
     
    public function __construct(
        Context $context,
        LoggerInterface $loggerInterface,
        Email $helperEmail,
        RecommendationRepositoryInterface $recommendationRepository,
        Session $customer,
        Random $random
        )
    {
        $this->_logLoggerInterface = $loggerInterface;
        $this->helperEmail = $helperEmail;
        $this->recommendationRepository = $recommendationRepository;
        $this->customer = $customer;
        $this->random = $random;
        $this->messageManager = $context->getMessageManager();
        parent::__construct($context);
 
    }
     
    public function execute()
    {
        $post = $this->getRequest()->getPost();
        $customer = $this->customer;
        $customerId = $customer->getId(); 
        $email = $post['email'];
        $hash = $this->random->getRandomString(10);

        try {
            $this->recommendationRepository->create($customerId, $email, $hash);
            $this->messageManager->addSuccessMessage(__('Recommendation saved successfully.'));
        } catch (NoSuchEntityException $exception) {
            $this->messageManager->addErrorMessage(__('Cannot save recommendation'));
            $this->logger->critical('Error message', ['exception' => $exception]);
        }

        try
        {
            $this->helperEmail->sendEmail($email, $hash);
            $this->messageManager->addSuccess('Email sent successfully');
            $this->_redirect('customer/account');
                 
        } catch(\Exception $e){
            $this->messageManager->addErrorMessage(__('Cannot send email'));
            $this->_logLoggerInterface->error($e->getMessage());
            exit;
        }
         
         
         
    }
}