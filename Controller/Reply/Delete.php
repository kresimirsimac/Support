<?php

namespace Iweb\Support\Controller\Reply;

class Delete extends \Magento\Framework\App\Action\Action
{
    protected $replyFactory;
    protected $supportFactory;
    protected $helper;
    protected $customerFactory;
    
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Iweb\Support\Model\ReplyFactory $replyFactory,
        \Iweb\Support\Model\SupportFactory $supportFactory,
        \Iweb\Support\Helper\Data $helper,
        \Magento\Customer\Model\CustomerFactory $customerFactory
    )
    {      
        $this->replyFactory    = $replyFactory;
        $this->supportFactory  = $supportFactory;
        $this->helper          = $helper;
        $this->customerFactory = $customerFactory;
        
        parent::__construct($context);
    }
    
    public function execute() 
    {
        $reply = $this->replyFactory->create()
               ->load($this->getRequest()->getParam('id'));
        $supportId = $reply->getSupportId();
        $reply->delete();
        
        $support       = $this->supportFactory->create()->load($supportId);
        $title         = $support->getTitle();
        $customerId    = $support->getCustomerId();
        $customer      = $this->customerFactory->create()->load($customerId);
        $customerName  = $customer->getFirstname() . ' ' . $customer->getLastname();
        $customerEmail = $customer->getEmail();

        $this->helper->sendCustomerDeleteReplyNotificationEmails($title, $customerName, $customerEmail);
        
        $this->_redirect('support/reply/replylist/', ['id' => $supportId]);
    }
}
