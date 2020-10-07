<?php

namespace Iweb\Support\Controller\Index;

class Config extends \Magento\Framework\App\Action\Action
{
    protected $helperData;
    
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Iweb\Support\Helper\Data $helperData
    )
    {
        $this->helperData = $helperData;
        return parent::__construct($context);
    }
    
    public function execute() 
    {
        // TODO implement execute() method
        echo $this->helperData->getGeneralConfig('enable');
        echo $this->helperData->getGeneralConfig('display_text');
        exit();            
    }
}