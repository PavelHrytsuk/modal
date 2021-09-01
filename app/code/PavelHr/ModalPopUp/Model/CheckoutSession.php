<?php

namespace PavelHr\ModalPopUp\Model;

use Magento\Checkout\Model\Session;
use Magento\Checkout\Model\Cart;



class CheckoutSession
{
    /** @var CheckoutSession */
    private Session $checkoutSession;
    private Cart $cart;


    public function getAllQuotedItem()
    {
        $cartProductsInfo = $this->cart->getQuote()->getItems();

        $info = [];

        foreach ($cartProductsInfo as $key => $productItem)
        {
               $info[$key] = $productItem->getData();
        }

        return $info;
    }
}

