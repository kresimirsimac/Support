<?php

namespace Iweb\Support\Block\Adminhtml\Reply\Grid\Column\Renderer;

class Replies extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer 
{
    protected $replyCollectionFactory;
    
    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Iweb\Support\Model\ResourceModel\Reply\CollectionFactory $replyCollectionFactory,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->replyCollectionFactory = $replyCollectionFactory;

    }
    
    public function render(\Magento\Framework\DataObject $row)
    {
        $reply = $this->replyCollectionFactory->create()
               ->addFieldToFilter('support_id', $row->getId());
        
        return $reply->getSize();
    }
}
