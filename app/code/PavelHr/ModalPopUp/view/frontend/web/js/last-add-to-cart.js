define([
    'jquery',
    'Magento_Ui/js/modal/modal'
], function ($, modal) {

    $(document).on('ajax:addToCart', function (event, data) {

        let options = {
            type: 'popup',
            responsive: true,
            title: 'Suggest another product',
            buttons: [{
                text: $.mage.__('Ok'),
                class: '',
                click: function () {
                    this.closeModal();
                }
            }]
        };

        let popup = modal(options, $('.modal-block'));
        $.ajax({
            url: "http://magent-learn.loc/allproducts/Ajax/GetSuggestProduct",
            type: "GET",
            success: function(resp){
                if(resp['answer'] !== false){
                    $('.modal-info').remove();
                    const $modalPop = $('.modal-block');
                    $modalPop.css('display', 'block');
                    $modalPop.append("<p class='modal-info'>Also, you can buy <a href='"+ resp['answer']['data']['url'] +"'>" + resp['answer']['data']['name'] + "</a></p>")
                    $modalPop.modal('openModal');
                }
            }
        });
    });
});
