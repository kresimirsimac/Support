<?php

namespace Iweb\Support\Controller\Ticket;

class Newticketpost extends \Magento\Framework\App\Action\Action
{
    protected $supportFactory;
    protected $helper;
    protected $customerFactory;
    
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Iweb\Support\Model\SupportFactory $supportFactory,
        \Magento\Customer\Model\Session $session,
        \Iweb\Support\Helper\Data $helper,
        \Magento\Customer\Model\CustomerFactory $customerFactory
    )
    {
        parent::__construct($context);
        
        $this->supportFactory = $supportFactory;
        $this->session = $session;
        $this->helper = $helper;
        $this->customerFactory = $customerFactory;
    }
    
    public function execute() 
    {       
        $title       = $this->getRequest()->getParam('title');
        $description = $this->getRequest()->getParam('description');
        $status      = 'active';
        $customerId  = $this->session->getId();

        $support = $this->supportFactory->create()
                ->setTitle($title)
                ->setDescription($description)
                ->setCustomerId($customerId)
                ->setStatus($status)
                ->save();
        
        $customer      = $this->customerFactory->create()->load($customerId);            
        $customerName  = $customer->getFirstname() . ' ' . $customer->getLastname();
        $customerEmail = $customer->getEmail();
        
        $this->helper->sendSupportTicketNotificationEmails($title, $customerName, $customerEmail);
        
        $this->_redirect('support/ticket/ticketlist');
    }
}
