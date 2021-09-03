<?php

namespace PavelHr\ModalPopUp\Controller\Ajax;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;
use PavelHr\ModalPopUp\Model\FetchProducts;


class Get implements HttpGetActionInterface
{
    private Context $context;
    private JsonFactory $_resultJsonFactory;
    private FetchProducts $_indexViewModel;


    public function __construct(Context $context, JsonFactory $jsonFactory, FetchProducts $indexViewModel)
    {

        $this->_resultJsonFactory = $jsonFactory;
        $this->_indexViewModel = $indexViewModel;
        $this->context = $context;
    }

    /**
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {

        $data = $this->_indexViewModel->getCurrentCategoryProduct(23);
        $resultJson = $this->_resultJsonFactory->create();
        return $resultJson->setData($data);
    }
}
