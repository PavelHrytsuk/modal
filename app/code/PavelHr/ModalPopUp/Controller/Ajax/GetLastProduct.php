<?php

namespace PavelHr\ModalPopUp\Controller\Ajax;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;
use PavelHr\ModalPopUp\Model\CheckoutSession;


class GetLastProduct implements HttpGetActionInterface
{
    private Context $context;
    private JsonFactory $_resultJsonFactory;
    private CheckoutSession $_indexViewModel;


    public function __construct(Context $context, JsonFactory $jsonFactory, CheckoutSession $indexViewModel)
    {

        $this->_resultJsonFactory = $jsonFactory;
        $this->_indexViewModel = $indexViewModel;
        $this->context = $context;
    }

    public function execute()
    {

        $data = $this->_indexViewModel->getAllQuotedItem();
        $resultJson = $this->_resultJsonFactory->create();
        return $resultJson->setData($data);
    }
}
