define(
    [
        'jquery',
        'Magento_Checkout/js/view/summary/abstract-total',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/model/totals'
    ],
    function ($,Component, quote, totals) {
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

                console.log(totals);

                var price = totals.getSegment('customer_discount').value;
                return this.getFormattedPrice(price);
            }
        });
    }
 );