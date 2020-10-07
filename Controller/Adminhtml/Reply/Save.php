<?php

namespace Iweb\Support\Controller\Adminhtml\Reply;

class Save extends \Magento\Backend\App\Action
{
    protected $replyFactory;
    protected $adminSession;
    
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Iweb\Support\Model\ReplyFactory $replyFactory,
        \Magento\Backend\Model\Auth\Session $adminSession
    )
    {
        parent::__construct($context);
        
        $this->replyFactory = $replyFactory;
        $this->adminSession = $adminSession;
    }
    
    public function execute() 
    {
        $supportId    = $this->getRequest()->getParam('support_id');
        $adminId      = $this->adminSession->getUser()->getId();
        $comment      = $this->getRequest()->getParam('comment');

        $reply = $this->replyFactory->create()
                ->setSupportId($supportId)
                ->setAdminId($adminId)
                ->setComment($comment)
                ->save();
        
        $this->_redirect('iweb_support/ticket/view/', ['support_id' => $supportId]);
    }
}
