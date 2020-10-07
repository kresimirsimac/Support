<?php

namespace Iweb\Support\Controller\Adminhtml\Ticket;

class View extends \Magento\Backend\App\Action
{
    protected $resultPageFactory = false;
    
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $supportId = $this->getRequest()->getParam('support_id');
    }
    
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__('Replies')));
        
        return $resultPage;
    }
}
