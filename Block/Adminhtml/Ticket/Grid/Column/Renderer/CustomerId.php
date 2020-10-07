<?php

namespace Iweb\Support\Block\Adminhtml\Ticket\Grid\Column\Renderer;

class CustomerId extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    protected $customerFactory;
    
    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        
        $this->customerFactory = $customerFactory;
    }

    public function render(\Magento\Framework\DataObject $row)
    {
        $customerId = $row->getData($this->getColumn()->getIndex());
        $customer = $this->customerFactory->create()->load($customerId);
        
        return $customer->getFirstname() . ' ' . $customer->getLastname();
    }
}
