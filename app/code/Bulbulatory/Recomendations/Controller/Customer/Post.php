<?php
namespace Bulbulatory\Recomendations\Controller\Customer;

use Magento\Framework\UrlInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Math\Random;
use Psr\Log\LoggerInterface;
use Bulbulatory\Recomendations\Helper\Email;
use Bulbulatory\Recomendations\Api\RecommendationRepositoryInterface;
use Bulbulatory\Recomendations\Api\Data\RecommendationInterface;

 
class Post extends \Magento\Framework\App\Action\Action
{     
    protected $_logLoggerInterface;
    protected $helperEmail;
    protected $recommendationRepository;	
    protected $customer;
    protected $recommendation;
    protected $date;
    protected $random;
    protected $urlInterface;
     
    public function __construct(
        Context $context,
        LoggerInterface $loggerInterface,
        Email $helperEmail,
        RecommendationRepositoryInterface $recommendationRepository,
        Session $customer,
        RecommendationInterface $recommendation,
        DateTime $date,
        Random $random,
        UrlInterface $urlInterface
        )
    {
        $this->_logLoggerInterface = $loggerInterface;
        $this->helperEmail = $helperEmail;
        $this->recommendationRepository = $recommendationRepository;
        $this->customer = $customer;
        $this->recommendation = $recommendation;
        $this->date = $date;
        $this->random = $random;
        $this->urlInterface = $urlInterface;
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
        $date = $this->date->gmtDate();

        $recommendation = $this->recommendation;
        $recommendation->setRecommenderId($customerId);
        $recommendation->setEmail($email);
        $recommendation->setHash($hash);
        $recommendation->setStatus(0);
        $recommendation->setCreatedAt($date);

        $url = $this->urlInterface->getUrl(
            'http://bulbulatory.test/recomendations/customer/confirm',
            [
                'hash' => $hash
            ]
        );

        try {
            $this->recommendationRepository->save($recommendation);
            $this->messageManager->addSuccessMessage(__('Recommendation saved successfully.'));
        } catch (NoSuchEntityException $exception) {
            $this->messageManager->addErrorMessage(__('Cannot save recommendation'));
            $this->logger->critical('Error message', ['exception' => $exception]);
        }

        try
        {
            $this->helperEmail->sendEmail($email, $url);
            $this->messageManager->addSuccess('Email sent successfully');
            $this->_redirect('customer/account');
                 
        } catch(\Exception $e){
            $this->messageManager->addError($e->getMessage());
            $this->_logLoggerInterface->error($e->getMessage());
            exit;
        }
         
         
         
    }
}