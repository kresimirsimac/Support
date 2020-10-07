<?php

namespace Iweb\Support\Block\Adminhtml\Reply;

class Replydata extends \Magento\Framework\View\Element\Template
{
    protected $adminSession;
    
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Iweb\Support\Model\Reply $replyData,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Backend\Model\Auth\Session $adminSession
    )
    {
        parent::__construct($context);
        
        $this->adminSession = $adminSession;
        $this->replyData = $replyData;
        $this->request = $request;
    }
    
    public function getPostActionUrl()
    {
        return $this->_urlBuilder->getUrl('iweb_support/reply/newreplypost');
    }
    
    public function getCurrentId()
    {
        return $this->request->getParam('support_id');
    }
    
    public function getAdminId()
    {
        $adminId = $this->adminSession->getId();
        return $adminId;
    }
}
