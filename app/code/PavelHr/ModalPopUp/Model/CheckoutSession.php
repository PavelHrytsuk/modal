<?php

namespace PavelHr\ModalPopUp\Model;

use Magento\Checkout\Model\Cart;
use Magento\Catalog\Model\ProductCategoryList;
use PavelHr\ModalPopUp\Model\FetchProducts;

class CheckoutSession
{
    private Cart $cart;
    private ProductCategoryList $productCategory;
    private FetchProducts $fetchProducts;

    public function __construct(Cart $cart, ProductCategoryList $productCategory, FetchProducts $fetchProducts)
    {
        $this->cart = $cart;
        $this->productCategory = $productCategory;
        $this->fetchProducts = $fetchProducts;
    }

    public function getLastAddedProduct()
    {
        $cartProductsInfo = $this->cart->getQuote()->getItems();

        $info = [];

        foreach ($cartProductsInfo as $key => $productItem)
        {
            $info[$key]['data'] = $productItem->getData();
        }

        $lastProductId = $this->getLastAddedProductId($info);

        $categoryId = $this->getProductCategoryId($lastProductId['product_id'])[0];

        $lastProductInfo = array(['product_id' => $lastProductId['product_id'], 'category_id' => $categoryId,
            'sku' => $lastProductId['sku'], 'custom_attribute' => false]);

        $allProducts = $this->fetchProducts->getProducts();

        $checkLastProductInfo = $this->checkSuggestAttribute($lastProductInfo, $allProducts);
        return $checkLastProductInfo;

    }


    private function getProductCategoryId($productId)
    {

           return $this->productCategory->getCategoryIds($productId);

    }

    private function getLastAddedProductId($infoArray)
    {
        $date = '';

        foreach ($infoArray as $key => $item){

            if($item['data']['updated_at'] > $date){
                $lastAddedProduct['product_id'] = $item['data']['product_id'];
                $lastAddedProduct['sku'] = $item['data']['sku'];
                $date = $item['data']['updated_at'];
            }
        }

        return $lastAddedProduct;
    }

    private function checkSuggestAttribute($product, $allProduct)
    {

        foreach ($allProduct as $key => $productItem)
        {
            if(($product[0]['sku'] == $productItem['data']['sku']) and (isset($productItem['data']['sample_attribute']) and $productItem['data']['sample_attribute'] == 1)){
                $product[0]['custom_attribute'] = true;
            }
        }

        return $product;
    }
}

