<?php

namespace Bulbulatory\Recomendations\Setup;
 
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\DB\Ddl\Table;
 
/**
 * Upgrade the Sales_Order Table to remove extra field
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
 
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '1.0.3', '<')) {
            $setup->getConnection()->changeColumn(
                $setup->getTable('bulbulatory_recomendations'),
                'e-mail',
                'email',
                [
                    'type' => Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' => 'Email the recommendation was sent to'
                ]
            );
        }
        $setup->endSetup();
    }
}