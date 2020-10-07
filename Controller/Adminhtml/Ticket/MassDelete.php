<?php

namespace Iweb\Support\Controller\Adminhtml\Ticket;

class MassDelete extends \Magento\Backend\App\Action
{       
    protected $supportFactory;
    protected $replyCollectionFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Iweb\Support\Model\SupportFactory $supportFactory,
        \Iweb\Support\Model\ResourceModel\Reply\CollectionFactory $replyCollectionFactory
    ) {
        $this->supportFactory = $supportFactory;
        $this->replyCollectionFactory = $replyCollectionFactory;
        
        parent::__construct($context);
    }
    
    public function execute()
    {
        $supportIds = $this->getRequest()->getParam('id');
        
        if (!is_array($supportIds) || empty($supportIds)) {
            $this->messageManager->addErrorMessage(__('Please, select replies to delete.'));
            $this->_redirect('iweb_support/ticket/index/');
            return;
        }
        
        try {
            $ticketsDeleted = 0;
            $repliesDeleted = 0;
            
            foreach ($supportIds as $_supportId) {
                $replyCollection = $this->replyCollectionFactory->create()->addFieldToFilter('support_id', $_supportId);
                foreach ($replyCollection as $_reply) {
                    $_reply->delete();
                    $repliesDeleted++;
                }
                
                $support = $this->supportFactory->create()->load($_supportId);
                $support->delete();
                $ticketsDeleted++;
            }
            
            $this->messageManager->addSuccessMessage(__('A total of %1 tickets has been deleted.', $ticketsDeleted));
            $this->messageManager->addSuccessMessage(__('A total of %1 replies has been deleted.', $repliesDeleted));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        
        $this->_redirect('iweb_support/ticket/index/');
    }
}
