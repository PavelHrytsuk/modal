<?php

declare(strict_types=1);

namespace PavelHr\ModalPopUp\Model;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Visibility;

class FetchProducts
{
    private CollectionFactory $productCollectionFactory;
    private Status $productStatus;
    private Visibility $productVisibility;


    /**
    * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
    * @param \Magento\Catalog\Model\Product\Attribute\Source\Status $productStatus
    * @param \Magento\Catalog\Model\Product\Visibility $productVisibility
    * @throws \Magento\Framework\Exception\LocalizedException
    */
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
     * @return \Magento\Framework\DataObject[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getProducts()
    {
        /** @var \Magento\Catalog\Model\ResourceModel\Product\Collection $collection */
        $collection = $this->productCollectionFactory->create();
        $collection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner');
        $collection->joinAttribute('visibility', 'catalog_product/visibility', 'entity_id', null, 'inner');
        $collection->addAttributeToFilter('status', ['in' => $this->productStatus->getVisibleStatusIds()])
            ->addAttributeToFilter('visibility', ['in' => $this->productVisibility->getVisibleInSiteIds()])
            ->addAttributeToFilter('sample_attribute', 1)
            ->addFieldToSelect('name');

        $productArr = [];

        foreach ($collection->getItems() as $key => $productItem) {
            $productArr[$key]['data'] = $productItem->getData();
        }

        return $productArr;
    }

}

