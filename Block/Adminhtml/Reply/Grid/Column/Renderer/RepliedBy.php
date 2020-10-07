<?php

namespace Iweb\Support\Block\Adminhtml\Reply\Grid\Column\Renderer;

class RepliedBy extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    protected $userFactory;
    protected $supportFactory;
    protected $customerFactory;
    
    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Magento\User\Model\UserFactory $userFactory,
        \Iweb\Support\Model\SupportFactory $supportFactory,    
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        
        $this->userFactory = $userFactory;
        $this->supportFactory = $supportFactory;
        $this->customerFactory = $customerFactory;
        
    }

    public function render(\Magento\Framework\DataObject $row)
    {   
        $adminId = $row->getData($this->getColumn()->getIndex());
        
        if ($adminId) {
            $admin = $this->userFactory->create()->load($adminId);
            
            return $admin->getUsername();
        } else {
            $supportId = $row->getData('support_id');
            $support = $this->supportFactory->create()->load($supportId);
            
            $customerId = $support->getCustomerId();
            $customer = $this->customerFactory->create()->load($customerId);
            
            return $customer->getFirstname() . ' ' . $customer->getLastname();
        }
    }
}
