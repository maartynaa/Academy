<?php
namespace Bulbulatory\Recomendations\Controller\Customer;

class Index extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;
	protected $_scopeConfig;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
		\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig)
	{
		$this->_pageFactory = $pageFactory;
		$this->_scopeConfig = $scopeConfig;
		return parent::__construct($context);
	}

	public function execute()
	{
		$enable = $this->_scopeConfig->getValue('recomendations/general/enable', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
		
		if ($enable){
			return $this->_pageFactory->create();
		}
		
	}
}