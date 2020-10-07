<?php

namespace Iweb\Support\Block\Ticket;


class Ticketdata extends \Magento\Framework\View\Element\Template
{
    protected $customerSession;
    protected $replyCollectionFactory;
    protected $supportFactory;
    
    public function __construct(
        \Iweb\Support\Model\Support $ticketData,
        \Iweb\Support\Model\SupportFactory $supportFactory,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Iweb\Support\Model\ResourceModel\Reply\CollectionFactory $replyCollectionFactory
    )
    {    
        parent::__construct($context);
        
        $this->ticketData               = $ticketData;
        $this->supportFactory           = $supportFactory;
        $this->customerSession          = $customerSession;
        $this->replyCollectionFactory   = $replyCollectionFactory;
    }
    
    public function getTicketList()
    {
        $data = $this->ticketData->getCollection();
        return $data;
    }
    
    public function getBackUrl()
    {
        return $this->_urlBuilder->getUrl('support/page/index');
    }
    
    public function getCurrentId()
    {
        $customerId = $this->customerSession->getId();
        return $customerId;
    }
    
    public function noOfReplies($id)
    {
        $reply = $this->replyCollectionFactory->create()
               ->addFieldToFilter('support_id', $id);
        return $reply->getSize();
    }
    
    public function noOfVisibleReplies($id)
    {
        $reply = $this->replyCollectionFactory->create()
               ->addFieldToFilter('support_id', $id)
               ->addFieldToFilter('visible', 'visible');
        return $reply->getSize();
    }
    
    public function ticketStatus($id)
    {
        $ticket = $this->supportFactory->create()->load($id);
                
        return $ticket->getStatus();
    }
}
