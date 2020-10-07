<?php

namespace Iweb\Support\Model\ResourceModel\Reply\Grid;

class Collection extends \Iweb\Support\Model\ResourceModel\Reply\Collection
{
    protected $request;
    
    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\DB\Adapter\AdapterInterface $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    ) {
        $this->request = $request;
        
        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $connection,
            $resource
        );
    }
    
    protected function _initSelect()
    {
        parent::_initSelect();
        
        $supportId = $this->request->getParam('support_id');
        $this->addFieldToFilter('support_id', $supportId);
        
        return $this;
    }
}
