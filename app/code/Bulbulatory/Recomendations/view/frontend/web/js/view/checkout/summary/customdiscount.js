define(
    [
        'jquery',
        'Magento_Checkout/js/view/summary/abstract-total',
        'Magento_Checkout/js/model/quote'
    ],
    function ($,Component, quote) {
        "use strict";
        return Component.extend({
            defaults: {
                template: 'Bulbulatory_Recomendations/checkout/summary/customdiscount'
            },
            totals: quote.getTotals(),
            isDisplayedCustomdiscount : function(){
                return true;
            },
            getCustomDiscount : function(){

                var price = totals.getSegment('customer_discount').value;
                return this.getFormattedPrice(price);
            }
        });
    }
 );