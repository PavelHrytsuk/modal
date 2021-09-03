<?php

namespace PavelHr\ModalPopUp\Model;

use PavelHr\ModalPopUp\Model\CheckoutSession;
use PavelHr\ModalPopUp\Model\FetchProducts;


class GetResponse
{
    private CheckoutSession $sessionInfo;
    private FetchProducts $fetchProducts;


    public function __construct(CheckoutSession $sessionInfo, FetchProducts $fetchProducts)
    {
        $this->sessionInfo = $sessionInfo;
        $this->fetchProducts = $fetchProducts;
    }

    public function getResponse(){

        $productAddedInfo = $this->sessionInfo->getLastAddedProduct();
        if($productAddedInfo[0]['custom_attribute'] == true){
            $currentCategoryProduct = $this->fetchProducts->getCurrentCategoryProduct($productAddedInfo[0]['category_id']);
            $data = ['answer' => $currentCategoryProduct[array_rand($currentCategoryProduct)]];
        }else{
            $data = ['answer' => false];
        }
        return $data;
    }


}
