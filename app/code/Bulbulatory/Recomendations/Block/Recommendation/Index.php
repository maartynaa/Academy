<?php
 
namespace Bulbulatory\Recomendations\Block\Recommendation;

use Magento\Framework\View\Element\Template;
use Magento\Catalog\Block\Product\Context;
 
class Index extends Template {
 
    public function __construct(Context $context, array $data = []) {
 
        parent::__construct($context, $data);
 
    }

    public function getFormAction()
    {
        return '/recomendations/customer/post';
    }

    protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }
 
}