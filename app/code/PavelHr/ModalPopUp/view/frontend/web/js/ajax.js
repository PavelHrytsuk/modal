define([
    'jquery',
    'mage/url',
], function($, urlBuilder){

    $('.show_result').click(function(){
        console.log('Button was click!');
        $.ajax({
            url: "http://magent-learn.loc/allproducts/Ajax/Get",
            type: "GET",
            success: function(data){
                console.log(data);
            }
        })
    })

    $('.last_product').click(function(){
        console.log('Button was click!');
        $.ajax({
            url: "http://magent-learn.loc/allproducts/Ajax/GetLastProduct",
            type: "GET",
            success: function(data){
                console.log(data);
            }
        })
    })
})
