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

    public function getLastAddedCategory()
    {
        $cartProductsInfo = $this->cart->getQuote()->getItems();

        $info = [];
        $lastProductInfo = [];

        foreach ($cartProductsInfo as $key => $productItem)
        {
            $info[$key]['data'] = $productItem->getData();
        }

        $product = $this->getLastAddedId($info);

        $categoryId = $this->getProductCategoryId($product['product_id'])[0];

        $lastProductInfo = array(['product_id' => $product['product_id'], 'category_id' => $categoryId, 'sku' => $product['sku']]);

        $allProducts = $this->fetchProducts->getProducts();

        $checkExists = $this->checkSuggestAttribute($lastProductInfo, $allProducts);
        return $checkExists;

    }


    private function getProductCategoryId($productId)
    {

           return $this->productCategory->getCategoryIds($productId);

    }

    private function getLastAddedId($infoArray)
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
        $checkResponse = 'Does not exist';
        foreach ($allProduct as $key => $productItem)
        {
            if(($product[0]['sku'] == $productItem['data']['sku']) and (isset($productItem['data']['sample_attribute']) and $productItem['data']['sample_attribute'] == 1)){
                $checkResponse = 'Exists';
            }
        }

        return $checkResponse;
    }
}

