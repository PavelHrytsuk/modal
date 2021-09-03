<?php

namespace PavelHr\ModalPopUp\Controller\Ajax;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;
use PavelHr\ModalPopUp\Model\GetResponse;


class GetSuggestProduct implements HttpGetActionInterface
{
    private Context $context;
    private JsonFactory $_resultJsonFactory;
    private GetResponse $getResponse;


    public function __construct(Context $context, JsonFactory $jsonFactory, GetResponse $getResponse)
    {

        $this->_resultJsonFactory = $jsonFactory;
        $this->context = $context;
        $this->getResponse = $getResponse;
    }


    public function execute()
    {
        $data = $this->getResponse->getResponse();
        $resultJson = $this->_resultJsonFactory->create();
        return $resultJson->setData($data);

    }

}
