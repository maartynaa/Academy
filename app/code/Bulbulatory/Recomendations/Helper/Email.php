<?php
namespace Bulbulatory\Recomendations\Helper;

use Magento\Framework\UrlInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Escaper;
use Magento\Framework\Mail\Template\TransportBuilder;

class Email extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $inlineTranslation;
    protected $escaper;
    protected $transportBuilder;
    protected $urlInterface;
    protected $logger;

    public function __construct(
        Context $context,
        StateInterface $inlineTranslation,
        Escaper $escaper,
        TransportBuilder $transportBuilder,
        UrlInterface $urlInterface
    ) {
        parent::__construct($context);
        $this->inlineTranslation = $inlineTranslation;
        $this->escaper = $escaper;
        $this->transportBuilder = $transportBuilder;
        $this->urlInterface = $urlInterface;
        $this->logger = $context->getLogger();
    }

    public function sendEmail($email, $hash)
    {

        $templateId = 'recommendation_email_template';
        $fromEmail = 'no-reply@bulbulatory.recomendations.com';  
        $fromName = 'Admin';

        $this->inlineTranslation->suspend();
        $sender = [
            'name' => $this->escaper->escapeHtml($fromName),
            'email' => $this->escaper->escapeHtml($fromEmail),
        ];
        $templateVars = [
            'url' => $this->urlInterface->getUrl('recomendations/customer/confirm',['hash' => $hash])
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
            ->addTo($email)
            ->getTransport();
        $transport->sendMessage();
        $this->inlineTranslation->resume();
    }
}