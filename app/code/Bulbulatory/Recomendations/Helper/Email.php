<?php
namespace Bulbulatory\Recomendations\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Escaper;
use Magento\Framework\Mail\Template\TransportBuilder;

class Email extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $inlineTranslation;
    protected $escaper;
    protected $transportBuilder;
    protected $logger;

    public function __construct(
        Context $context,
        StateInterface $inlineTranslation,
        Escaper $escaper,
        TransportBuilder $transportBuilder
    ) {
        parent::__construct($context);
        $this->inlineTranslation = $inlineTranslation;
        $this->escaper = $escaper;
        $this->transportBuilder = $transportBuilder;
        $this->logger = $context->getLogger();
    }

    public function sendEmail()
    {

        $templateId = 'recommendation_email_template';
        $fromEmail = 'admin@bulbulatory.com';  
        $fromName = 'Admin';
        $toEmail = 'mac.martyna@poczta.onet.pl';
 
        try {
            $this->inlineTranslation->suspend();
            $sender = [
                'name' => $this->escaper->escapeHtml($fromName),
                'email' => $this->escaper->escapeHtml($fromEmail),
            ];
            $templateVars = [
                'templateVar' => 'test',
            ]; 

            $templateOptions = [
                'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
            ];

            $transport = $this->transportBuilder
                ->setTemplateIdentifier($templateId)
                ->setTemplateOptions($templateOptions)
                ->setTemplateVars($templateVars)
                ->setFrom($sender)
                ->addTo($toEmail)
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
        } catch (\Exception $e) {
            $this->_logger->error($e->getMessage());
        }
    }
}