<?php

namespace Iweb\Support\Controller\Adminhtml\Posts;

use Iweb\Support\Controller\Adminhtml\Posts;

class MassStatus extends Posts
{
    protected $resPostFactory;
    
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Iweb\Support\Model\ReplyFactory $postsFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Iweb\Support\Model\ResourceModel\ReplyFactory $restPostFactory
    )
    {
        parent::__construct($context, $registry, $resultPageFactory, $postsFactory);
        $this->resPostFactory = $restPostFactory;
    }
    
    public function execute()
    {
        $replyIds = $this->getRequest()->getParam('name', []);
        $status = $this->getRequest()->getParam('status', 0);
        if (count($postIds)) {
            foreach ($postIds as $postId) {
                try {
                    $postModel = $this->postsFactory->create();
                    $resPost = $this->resPostFactory->create();
                    $postModel->setStatus($status)->setId($postId);
                    $resPost->save($postModel);
                } catch (Exception $e) {
                    $this->messageManager->addError($e->getMessage());
                }
            }
        }
        
        if (count($postIds)) {
            $this->messageManager->addSuccess(__('A total of %1 record(s) has been updated.', count($postIds)));            
        }
        
        $this->_redirect('*/*/view');
    }
}