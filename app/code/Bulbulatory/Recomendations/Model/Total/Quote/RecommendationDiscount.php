<?php
namespace Bulbulatory\Recomendations\Model\Total\Quote;

use Magento\Quote\Model\Quote\Address\Total\AbstractTotal;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Api\Data\ShippingAssignmentInterface;
use Magento\Quote\Model\Quote\Address\Total;
use Bulbulatory\Recomendations\Block\Recommendation\Index;

class RecommendationDiscount extends AbstractTotal
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

        if ($percent > 0) {
            $baseDiscount = $total->getSubtotal() * $percent / 100;

            $discount =  $this->_priceCurrency->convert($baseDiscount);
            $total->addTotalAmount('recommendation_discount', -$discount);
            $total->addBaseTotalAmount('recommendation_discount', -$baseDiscount);
            $total->setBaseGrandTotal($total->getBaseGrandTotal() - $baseDiscount);
            $quote->setRecommendationDiscount(-$discount);
        }
        
        return $this;
    }

    public function fetch(Quote $quote, Total $total) 
    {
        $percent = $this->index->calculateDiscountPercent();

        if($percent > 0) {
            $discount = $total->getSubtotal() * $percent / 100;
            return [
                'code' => $this->getCode(),
                'title' => $this->getLabel(),
                'value' => -$discount  
            ];
        }

        return null;
        
  	  }
}