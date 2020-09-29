<?php
namespace Bulbulatory\Recomendations\Controller\Customer;
 
use Magento\Framework\App\Action\Context;
use Psr\Log\LoggerInterface;
use Bulbulatory\Recomendations\Helper\Email;
 
class Post extends \Magento\Framework\App\Action\Action
{     
    protected $_logLoggerInterface;
    protected $helperEmail;
     
    public function __construct(
        Context $context,
        LoggerInterface $loggerInterface,
        Email $helperEmail
        )
    {
        $this->_logLoggerInterface = $loggerInterface;
        $this->helperEmail = $helperEmail;
        $this->messageManager = $context->getMessageManager();
        parent::__construct($context);
 
    }
     
    public function execute()
    {
        $post = $this->getRequest()->getPost();
        try
        {
            $this->helperEmail->sendEmail();
            $this->messageManager->addSuccess('Email sent successfully');
            $this->_redirect('customer/account');
                 
        } catch(\Exception $e){
            $this->messageManager->addError($e->getMessage());
            $this->_logLoggerInterface->error($e->getMessage());
            exit;
        }
         
         
         
    }
}