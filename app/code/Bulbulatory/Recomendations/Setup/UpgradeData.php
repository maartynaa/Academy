<?php

namespace Bulbulatory\Recomendations\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeData implements UpgradeDataInterface
{
	protected $date;

	public function __construct(\Magento\Framework\Stdlib\DateTime\DateTime $date)
	{
		$this->date = $date;
	}

	public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
	{
		if (version_compare($context->getVersion(), '1.0.3', '<')) {
			$dataNewsRows = [
                [
                    'recommender_id' => 1,
                    'email' => 'biuro@mail.com',
                    'hash' => 'as4nj4wp23',
                    'confirmed_at' => null
                ],
                [
                    'recommender_id' => 2,
                    'email' => 'biuro@mail.com',
                    'hash' => 'kr9qo95jnw',
                    'status' => 1,
                    'confirmed_at' => $this->date->date()
                ],
                [
                    'recommender_id' => 3,
                    'email' => 'office@mail.com',
                    'hash' => 'aa9qo95jxx',
                    'status' => 1,
                    'confirmed_at' => $this->date->date()
                ],
                [
                    'recommender_id' => 1,
                    'email' => 'xyz@mail.com',
                    'hash' => 'pqwnj4w5tr',
                    'confirmed_at' => null
                ],
                [
                    'recommender_id' => 3,
                    'email' => 'anna@mail.com',
                    'hash' => 'p11nj4wn4a',
                    'confirmed_at' => null
                ]
                
            ];
            
			foreach ($dataNewsRows as $row) {
                $setup->getConnection()->insert($setup->getTable('bulbulatory_recomendations'), $row);
            }
		}
	}
}