<?php

namespace Iweb\Support\Block\Reply;

class Editdata extends \Magento\Framework\View\Element\Template
{
    protected $customerSession;
    protected $replyFactory;
    
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Iweb\Support\Model\Reply $replyData,
        \Iweb\Support\Model\ReplyFactory $replyFactory,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession
    )
    {
        parent::__construct($context);
        
        $this->customerSession = $customerSession;
        $this->replyData       = $replyData;
        $this->replyFactory    = $replyFactory;
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
        return $this->_urlBuilder->getUrl('support/reply/editreplypost');
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
    
    public function getComment($id)
    {
        $comment = $this->replyFactory->create()->load($id);
        
        return $comment;
    }
}
