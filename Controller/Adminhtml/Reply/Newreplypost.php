<?php

namespace Iweb\Support\Controller\Adminhtml\Reply;

class Newreplypost extends \Magento\Backend\App\Action
{
    protected $replyFactory;
    protected $adminSession;
    protected $helper;
    protected $supportFactory;
    protected $customerFactory;
    
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Iweb\Support\Model\ReplyFactory $replyFactory,
        \Iweb\Support\Model\SupportFactory $supportFactory,
        \Magento\Backend\Model\Auth\Session $adminSession,
        \Iweb\Support\Helper\Data $helper,
        \Magento\Customer\Model\CustomerFactory $customerFactory
    )
    {
        parent::__construct($context);
        
        $this->replyFactory    = $replyFactory;
        $this->supportFactory  = $supportFactory;
        $this->adminSession    = $adminSession;
        $this->helper          = $helper;
        $this->customerFactory = $customerFactory;
    }
    
    public function execute() 
    {
        $supportId    = $this->getRequest()->getParam('support_id');
        $adminId      = $this->adminSession->getUser()->getId();
        $comment      = $this->getRequest()->getParam('comment');
        $visible      = 'visible';

        $reply = $this->replyFactory->create()
                ->setSupportId($supportId)
                ->setAdminId($adminId)
                ->setComment($comment)
                ->setVisible($visible)
                ->save();
        
        $support       = $this->supportFactory->create()->load($supportId);
        $title         = $support->getTitle();
        $customerId    = $support->getCustomerId();
        $customer      = $this->customerFactory->create()->load($customerId);
        $customerName  = $customer->getFirstname() . ' ' . $customer->getLastname();
        $customerEmail = $customer->getEmail();
        
        $this->helper->sendAdminReplyTicketNotificationEmails($title, $customerName, $customerEmail);
        
        $this->_redirect('iweb_support/ticket/view/', ['support_id' => $supportId]);
    }
}
