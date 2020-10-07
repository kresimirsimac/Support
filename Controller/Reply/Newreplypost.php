<?php

namespace Iweb\Support\Controller\Reply;

class Newreplypost extends \Magento\Framework\App\Action\Action
{
    protected $replyFactory;
    protected $helper;
    protected $supportFactory;
    protected $customerFactory;
    
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Iweb\Support\Model\ReplyFactory $replyFactory,
        \Iweb\Support\Model\SupportFactory $supportFactory,
        \Iweb\Support\Helper\Data $helper,
        \Magento\Customer\Model\CustomerFactory $customerFactory
    )
    {
        parent::__construct($context);
        
        $this->replyFactory    = $replyFactory;
        $this->supportFactory  = $supportFactory;
        $this->helper          = $helper;
        $this->customerFactory = $customerFactory;
    }
    
    public function execute() 
    {
        $replyId     = $this->getRequest()->getParam('reply_id');
        $supportId   = $this->getRequest()->getParam('support_id');
        $comment     = $this->getRequest()->getParam('comment');
        $visible     = 'visible';

        $reply = $this->replyFactory->create()->load($replyId)
                ->setSupportId($supportId)
                ->setComment($comment)
                ->setVisible($visible)
                ->save();
        
        $support       = $this->supportFactory->create()->load($supportId);
        $title         = $support->getTitle();
        $customerId    = $support->getCustomerId();
        $customer      = $this->customerFactory->create()->load($customerId);
        $customerName  = $customer->getFirstname() . ' ' . $customer->getLastname();
        $customerEmail = $customer->getEmail();
        
        
        $this->helper->sendCustomerReplyNotificationEmails($title, $customerName, $customerEmail);
       
        
        $this->_redirect('support/reply/replylist/', ['id' => $supportId]);
    }
}
