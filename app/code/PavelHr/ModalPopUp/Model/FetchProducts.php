<?php

namespace PavelHr\ModalPopUp\Model;

use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

class FetchProducts
{

    private CollectionFactory $productCollectionFactory;
    private Status $productStatus;
    private Visibility $productVisibility;


    public function __construct(
        CollectionFactory $productCollectionFactory,
        Status $productStatus,
        Visibility $productVisibility
    ) {

        $this->productCollectionFactory = $productCollectionFactory;
        $this->productStatus = $productStatus;
        $this->productVisibility = $productVisibility;
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getProducts()
    {

        $collection = $this->createCollection()->addAttributeToSelect('sample_attribute')->getItems();
        $productArr = $this->getProductData($collection);

        return $productArr;
    }

    public function getCurrentCategoryProduct($categoryId){

        $filterCollection = $this->createCollection()->addCategoriesFilter(['eq' => [$categoryId]])->getItems();

        $infoArray = $this->getProductData($filterCollection);

        return $infoArray;

    }

    private function createCollection(): \Magento\Catalog\Model\ResourceModel\Product\Collection
    {

        $collection = $this->productCollectionFactory->create();
        $collection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner');
        $collection->joinAttribute('visibility', 'catalog_product/visibility', 'entity_id', null, 'inner');
        $collection->addAttributeToFilter('status', ['in' => $this->productStatus->getVisibleStatusIds()])
            ->addAttributeToFilter('visibility', ['in' => $this->productVisibility->getVisibleInSiteIds()])
            ->addFieldToSelect('name');
        return $collection;
    }

    private function getProductData($productArray){
        $dataArray = [];

        foreach ($productArray as $key => $productItem) {
            $dataArray[$key]['data'] = $productItem->getData();
            $dataArray[$key]['data']['url'] = $productItem->getProductUrl();
        }

        return $dataArray;
    }
}

