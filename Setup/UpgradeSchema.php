<?php

namespace Iweb\Support\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(
        \Magento\Framework\Setup\SchemaSetupInterface $setup,
        \Magento\Framework\Setup\ModuleContextInterface $context
    )
    {
        $setup->startSetup();
        
        if(version_compare($context->getVersion(), '1.0.3') < 0) {
            $tableName = $setup->getTable('iweb_support');
        }
         
        $columns = [
            'status' => [
                'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => true,
                'comment'  => 'Status'
            ],
        ];
         
        foreach($columns as $columnName => $definition) {
            $setup->getConnection()->addColumn($tableName, $columnName, $definition);
        }
         
        $setup->endSetup();
    }
}
