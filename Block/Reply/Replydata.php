<?php

namespace Iweb\Support\Block\Reply;

class Replydata extends \Magento\Framework\View\Element\Template
{
    protected $customerSession;
    protected $replyData;
    protected $supportFactory;
    protected $replyFactory;
    protected $userFactory;
    protected $customerFactory;
    
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Iweb\Support\Model\Reply $replyData,
        \Iweb\Support\Model\SupportFactory $supportFactory,
        \Iweb\Support\Model\ReplyFactory $replyFactory,
        \Magento\User\Model\UserFactory $userFactory,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession
    )
    {
        parent::__construct($context);
        
        $this->customerSession = $customerSession;
        $this->replyData       = $replyData;
        $this->supportFactory  = $supportFactory;
        $this->replyFactory    = $replyFactory;
        $this->userFactory     = $userFactory;
        $this->customerFactory = $customerFactory;
        $this->request         = $request;
    }
    
    public function getReplyList()
    {
        $data = $this->replyData->getCollection();
        
        return $data;
    }
    
    public function getBackUrl()
    {
        return $this->_urlBuilder->getUrl('support/ticket/ticketlist');
    }
    
    public function getPostActionUrl()
    {
        return $this->_urlBuilder->getUrl('support/reply/newreplypost');
    }
    
    public function getCurrentId()
    {
        return $this->request->getParam('id');
    }
    
    public function getCustomerId()
    {
        $customerId = $this->customerSession->getId();
        return $customerId;
    }
    
    public function repliedBy($id)
    {   
        $admin = $this->userFactory->create()->load($id);        
        
        return $admin->getUsername();
    }
}
