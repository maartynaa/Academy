<?php

namespace Bulbulatory\Recomendations\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;


class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
	{
		$installer = $setup;
        $installer->startSetup();
        
        if (!$installer->tableExists('bulbulatory_recomendations')) {
			$table = $installer->getConnection()->newTable(
				$installer->getTable('bulbulatory_recomendations')
			)
				->addColumn(
					'recommendation_id',
					Table::TYPE_INTEGER,
					null,
					[
						'identity' => true,
						'nullable' => false,
						'primary'  => true,
						'unsigned' => true,
					],
					'Recommendation ID'
                )
                ->addColumn(
					'recommender_id',
					Table::TYPE_INTEGER,
					null,
					[
						'unsigned' => true, 
						'nullable' => false
					],
					'Recommender ID'
                )
                ->addColumn(
					'e-mail',
					Table::TYPE_TEXT,
					255,
					['nullable' => false],
					'Recommendation e-mail'
                )
                ->addColumn(
					'hash',
					Table::TYPE_TEXT,
					255,
					[
						'nullable' => false,
						'unique' => true
					],
					'Recommendation hash'
                )
                ->addColumn(
					'status',
					Table::TYPE_BOOLEAN,
					null,
					['nullable' => false],
					'Recommendation status'
                )
                ->addColumn(
					'created_at',
					Table::TYPE_DATETIME,
					null,
					['nullable' => false],
					'Creation date'
                )
                ->addColumn(
					'confirmed_at',
					Table::TYPE_DATETIME,
					null,
					['nullable' => false],
					'Confirmation date'
				)
				->addForeignKey(
					$installer->getFkName(
						'bulbulatory_recomendations',
						'recommender_id',
						'customer_entity',
						'entity_id'
					),
					'recommender_id',
					$installer->getTable('customer_entity'), 
					'entity_id',
					Table::ACTION_CASCADE
				)
				
				->setComment('Bulbulatory Recommendations Table');
			$installer->getConnection()->createTable($table);
		}

		$installer->endSetup();
	}
}