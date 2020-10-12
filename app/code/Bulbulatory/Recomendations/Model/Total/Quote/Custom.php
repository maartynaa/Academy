<?php
namespace Bulbulatory\Recomendations\Model\Total\Quote;

use Magento\Quote\Model\Quote\Address\Total\AbstractTotal;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Api\Data\ShippingAssignmentInterface;
use Magento\Quote\Model\Quote\Address\Total;
use Bulbulatory\Recomendations\Block\Recommendation\Index;

class Custom extends AbstractTotal
{
   protected $_priceCurrency;
   protected $index;

   public function __construct(
      PriceCurrencyInterface $priceCurrency,
      Index $index
   ){
       $this->_priceCurrency = $priceCurrency;
       $this->index = $index;
   }

   public function collect(
       Quote $quote,
       ShippingAssignmentInterface $shippingAssignment,
       Total $total
   )
   {
       parent::collect($quote, $shippingAssignment, $total);

           $percent = $this->index->calculateDiscountPercent();
           $baseDiscount = $total->getSubtotal() * $percent / 100;

           $discount =  $this->_priceCurrency->convert($baseDiscount);
           $total->addTotalAmount('customdiscount', -$discount);
           $total->addBaseTotalAmount('customdiscount', -$baseDiscount);
           $total->setBaseGrandTotal($total->getBaseGrandTotal() - $baseDiscount);
           $quote->setCustomDiscount(-$discount);
       return $this;
   }
}