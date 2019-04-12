(function($) {
    $(document).ready(function() {
        // span parent .yith_wcmv_sold_by_wrapper > small > (venduto da: "a href....")
        // get vendor name $('span.yith_wcmv_sold_by_wrapper small a').text()

        displayErrorCartMsg();
        $(document.body).on('updated_wc_div', displayErrorCartMsg);
    });

    function displayErrorCartMsg() {
        var vendors = [];

        $('span.yith_wcmv_sold_by_wrapper small a').each(function() {
            vendors.push($(this).text());
        });

        var custom_html =
            "<div class='woocommerce-message custom_wc_msg_sm_vsb' role='alert'><i class='far fa-times-circle'></i>Non puoi aggiungere prodotti di aziende differenti. Chiudi prima l'ordine attuale.</div>";

        if ($.unique(vendors).length > 1) {
            console.log('Dovrebbe essere bloccato il checkout');

            $('div.woocommerce').prepend(custom_html);

            $('.cart-collaterals').addClass('cart-collaterals-disabled');

            $(
                '.fusion-apply-coupon, fusion-update-cart, checkout-button'
            ).unbind();
        } else {
            $('.cart-collaterals').removeClass('cart-collaterals-disabled');
        }
    }
})(jQuery);
