<?php

namespace Iweb\Support\Helper;

use Magento\Store\Model\ScopeInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_SUPPORT = 'support/';
    
    const XML_PATH_SUPPORT_MAIL_NEW_TICKET_NOTIFICATION_ENABLED        = 'support_mail/new_ticket_notification/enabled';
    const XML_PATH_SUPPORT_MAIL_NEW_TICKET_NOTIFICATION_EMAIL_IDENTITY = 'support_mail/new_ticket_notification/email_identity';
    const XML_PATH_SUPPORT_MAIL_NEW_TICKET_NOTIFICATION_EMAIL_TEMPLATE = 'support_mail/new_ticket_notification/email_template';
    
    const XML_PATH_SUPPORT_MAIL_ADMIN_REPLY_TICKET_NOTIFICATION_ENABLED        = 'support_mail/admin_reply_ticket_notification/enabled';
    const XML_PATH_SUPPORT_MAIL_ADMIN_REPLY_TICKET_NOTIFICATION_EMAIL_IDENTITY = 'support_mail/admin_reply_ticket_notification/email_identity';
    const XML_PATH_SUPPORT_MAIL_ADMIN_REPLY_TICKET_NOTIFICATION_EMAIL_TEMPLATE = 'support_mail/admin_reply_ticket_notification/email_template';
    
    const XML_PATH_SUPPORT_MAIL_NEW_CUSTOMER_REPLY_NOTIFICATION_ENABLED        = 'support_mail/new_customer_reply_notification/enabled';
    const XML_PATH_SUPPORT_MAIL_NEW_CUSTOMER_REPLY_NOTIFICATION_EMAIL_IDENTITY = 'support_mail/new_customer_reply_notification/email_identity';
    const XML_PATH_SUPPORT_MAIL_NEW_CUSTOMER_REPLY_NOTIFICATION_EMAIL_TEMPLATE = 'support_mail/new_customer_reply_notification/email_template';
    
    const XML_PATH_SUPPORT_MAIL_CUSTOMER_EDIT_REPLY_NOTIFICATION_ENABLED        = 'support_mail/customer_edit_reply_notification/enabled';
    const XML_PATH_SUPPORT_MAIL_CUSTOMER_EDIT_REPLY_NOTIFICATION_EMAIL_IDENTITY = 'support_mail/customer_edit_reply_notification/email_identity';
    const XML_PATH_SUPPORT_MAIL_CUSTOMER_EDIT_REPLY_NOTIFICATION_EMAIL_TEMPLATE = 'support_mail/customer_edit_reply_notification/email_template';
    
    const XML_PATH_SUPPORT_MAIL_CUSTOMER_DELETE_REPLY_NOTIFICATION_ENABLED        = 'support_mail/customer_delete_reply_notification/enabled';
    const XML_PATH_SUPPORT_MAIL_CUSTOMER_DELETE_REPLY_NOTIFICATION_EMAIL_IDENTITY = 'support_mail/customer_delete_reply_notification/email_identity';
    const XML_PATH_SUPPORT_MAIL_CUSTOMER_DELETE_REPLY_NOTIFICATION_EMAIL_TEMPLATE = 'support_mail/customer_delete_reply_notification/email_template';
    
    protected $inlineTranslation;
    protected $transportBuilder;
    protected $storeManager;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    )
    {
        parent::__construct($context);
        
        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilder  = $transportBuilder;
        $this->storeManager      = $storeManager;
    }
    
    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }
    
    public function getGeneralConfig($code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_SUPPORT . 'general/' . $code, $storeId);
    }
    
    public function isSupportTicketNotificationEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_SUPPORT_MAIL_NEW_TICKET_NOTIFICATION_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }
    
    public function getSupportTicketNotificationEmailIdentity()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_SUPPORT_MAIL_NEW_TICKET_NOTIFICATION_EMAIL_IDENTITY,
            ScopeInterface::SCOPE_STORE
        );
    }
    
    public function getSupportTicketNotificationEmailTemplate()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_SUPPORT_MAIL_NEW_TICKET_NOTIFICATION_EMAIL_TEMPLATE,
            ScopeInterface::SCOPE_STORE
        );
    }
    
    public function sendSupportTicketNotificationEmails($title, $customerName, $customerEmail)
    {
        if ($this->isSupportTicketNotificationEnabled()) {
            $emailTemplate = $this->getSupportTicketNotificationEmailTemplate();
            $emailSender   = $this->getSupportTicketNotificationEmailIdentity();
            
            if (!$emailTemplate || !$emailSender) {
                return;
            }
            
            $this->inlineTranslation->suspend();
            
            $this->transportBuilder
                ->setTemplateIdentifier($emailTemplate)
                ->setTemplateOptions([
                    'area'  => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store' => $this->storeManager->getStore()->getId() 
                ])
                ->setTemplateVars([
                    'topic' => $title,
                    'name'  => $customerName
                ])
                ->setFrom($emailSender)
                ->addTo($customerEmail);
            
            $transport = $this->transportBuilder->getTransport();
            $transport->sendMessage();
        }
        
        $this->inlineTranslation->resume();
    }
    
    public function isAdminReplyTicketNotificationEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_SUPPORT_MAIL_ADMIN_REPLY_TICKET_NOTIFICATION_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }
    
    public function getAdminReplyTicketNotificationEmailIdentity()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_SUPPORT_MAIL_ADMIN_REPLY_TICKET_NOTIFICATION_EMAIL_IDENTITY,
            ScopeInterface::SCOPE_STORE
        );
    }
    
    public function getAdminReplyTicketNotificationEmailTemplate()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_SUPPORT_MAIL_ADMIN_REPLY_TICKET_NOTIFICATION_EMAIL_TEMPLATE,
            ScopeInterface::SCOPE_STORE
        );
    }
    
    public function sendAdminReplyTicketNotificationEmails($title, $customerName, $customerEmail)
    {
        if ($this->isAdminReplyTicketNotificationEnabled()) {
            $emailTemplate = $this->getAdminReplyTicketNotificationEmailTemplate();
            $emailSender   = $this->getAdminReplyTicketNotificationEmailIdentity();
            
            if (!$emailTemplate || !$emailSender) {
                return;
            }
            
            $this->inlineTranslation->suspend();
            
            $this->transportBuilder
                ->setTemplateIdentifier($emailTemplate)
                ->setTemplateOptions([
                    'area'  => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store' => $this->storeManager->getStore()->getId() 
                ])
                ->setTemplateVars([
                    'topic' => $title,
                    'name'  => $customerName
                ])
                ->setFrom($emailSender)
                ->addTo($customerEmail);
            
            $transport = $this->transportBuilder->getTransport();
            $transport->sendMessage();
        }
        
        $this->inlineTranslation->resume();
    }
    
    public function isCustomerReplyNotificationEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_SUPPORT_MAIL_NEW_CUSTOMER_REPLY_NOTIFICATION_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }
    
    public function getCustomerReplyNotificationEmailIdentity()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_SUPPORT_MAIL_NEW_CUSTOMER_REPLY_NOTIFICATION_EMAIL_IDENTITY,
            ScopeInterface::SCOPE_STORE
        );
    }
    
    public function getCustomerReplyNotificationEmailTemplate()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_SUPPORT_MAIL_NEW_CUSTOMER_REPLY_NOTIFICATION_EMAIL_TEMPLATE,
            ScopeInterface::SCOPE_STORE
        );
    }
    
    public function sendCustomerReplyNotificationEmails($title, $customerName, $customerEmail)
    {
        if ($this->isCustomerReplyNotificationEnabled()) {
            $emailTemplate = $this->getCustomerReplyNotificationEmailTemplate();
            $emailSender   = $this->getCustomerReplyNotificationEmailIdentity();
            
            if (!$emailTemplate || !$emailSender) {
                return;
            }
            
            $this->inlineTranslation->suspend();
            
            $this->transportBuilder
                ->setTemplateIdentifier($emailTemplate)
                ->setTemplateOptions([
                    'area'  => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store' => $this->storeManager->getStore()->getId() 
                ])
                ->setTemplateVars([
                    'topic' => $title,
                    'name'  => $customerName
                ])
                ->setFrom($emailSender)
                ->addTo($customerEmail);
            
            $transport = $this->transportBuilder->getTransport();
            $transport->sendMessage();
        }
        
        $this->inlineTranslation->resume();
    }
    
    public function isCustomerEditReplyNotificationEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_SUPPORT_MAIL_CUSTOMER_EDIT_REPLY_NOTIFICATION_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }
    
    public function getCustomerEditReplyNotificationEmailIdentity()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_SUPPORT_MAIL_CUSTOMER_EDIT_REPLY_NOTIFICATION_EMAIL_IDENTITY,
            ScopeInterface::SCOPE_STORE
        );
    }
    
    public function getCustomerEditReplyNotificationEmailTemplate()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_SUPPORT_MAIL_CUSTOMER_EDIT_REPLY_NOTIFICATION_EMAIL_TEMPLATE,
            ScopeInterface::SCOPE_STORE
        );
    }
    
    public function sendCustomerEditReplyNotificationEmails($title, $customerName, $customerEmail)
    {
        if ($this->isCustomerEditReplyNotificationEnabled()) {
            $emailTemplate = $this->getCustomerEditReplyNotificationEmailTemplate();
            $emailSender   = $this->getCustomerEditReplyNotificationEmailIdentity();
            
            if (!$emailTemplate || !$emailSender) {
                return;
            }
            
            $this->inlineTranslation->suspend();
            
            $this->transportBuilder
                ->setTemplateIdentifier($emailTemplate)
                ->setTemplateOptions([
                    'area'  => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store' => $this->storeManager->getStore()->getId() 
                ])
                ->setTemplateVars([
                    'topic' => $title,
                    'name'  => $customerName
                ])
                ->setFrom($emailSender)
                ->addTo($customerEmail);
            
            $transport = $this->transportBuilder->getTransport();
            $transport->sendMessage();
        }
        
        $this->inlineTranslation->resume();
    }
    
    public function isCustomerDeleteReplyNotificationEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_SUPPORT_MAIL_CUSTOMER_DELETE_REPLY_NOTIFICATION_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }
    
    public function getCustomerDeleteReplyNotificationEmailIdentity()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_SUPPORT_MAIL_CUSTOMER_DELETE_REPLY_NOTIFICATION_EMAIL_IDENTITY,
            ScopeInterface::SCOPE_STORE
        );
    }
    
    public function getCustomerDeleteReplyNotificationEmailTemplate()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_SUPPORT_MAIL_CUSTOMER_DELETE_REPLY_NOTIFICATION_EMAIL_TEMPLATE,
            ScopeInterface::SCOPE_STORE
        );
    }
    
    public function sendCustomerDeleteReplyNotificationEmails($title, $customerName, $customerEmail)
    {
        if ($this->isCustomerDeleteReplyNotificationEnabled()) {
            $emailTemplate = $this->getCustomerDeleteReplyNotificationEmailTemplate();
            $emailSender   = $this->getCustomerDeleteReplyNotificationEmailIdentity();
            
            if (!$emailTemplate || !$emailSender) {
                return;
            }
            
            $this->inlineTranslation->suspend();
            
            $this->transportBuilder
                ->setTemplateIdentifier($emailTemplate)
                ->setTemplateOptions([
                    'area'  => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store' => $this->storeManager->getStore()->getId() 
                ])
                ->setTemplateVars([
                    'topic' => $title,
                    'name'  => $customerName
                ])
                ->setFrom($emailSender)
                ->addTo($customerEmail);
            
            $transport = $this->transportBuilder->getTransport();
            $transport->sendMessage();
        }
        
        $this->inlineTranslation->resume();
    }
}
