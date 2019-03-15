<?php

namespace Gamma\Vendor\Controller\Index;

class Vendor extends \Magento\Framework\App\Action\Action
{
    
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
    
    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
        ) {
            parent::__construct($context);
            $this->resultPageFactory = $resultPageFactory;
    }
    
    public function execute()
    {
        
        
        
        $id = $this->getRequest()->getParam('id');
        
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getLayout()->initMessages();
        
        $resultPage->getLayout()->getBlock('vendor_index_vendor')->setVendorId($id);
        
        return $resultPage;
        
    }
}