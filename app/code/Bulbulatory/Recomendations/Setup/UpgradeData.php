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
		if (version_compare($context->getVersion(), '1.0.2', '<')) {
			$dataNewsRows = [
                [
                    'recommender_id' => 1,
                    'email' => 'biuro@mail.com',
                    'hash' => 'k23nj4w9nk',
                    'confirmed_at' => null
                ],
                [
                    'recommender_id' => 2,
                    'email' => 'biuro@mail.com',
                    'hash' => 'p2iqo95j7w',
                    'status' => 1,
                    'confirmed_at' => $this->date->date()
                ],
                [
                    'recommender_id' => 3,
                    'email' => 'office@mail.com',
                    'hash' => 'pw5qo95j7w',
                    'status' => 1,
                    'confirmed_at' => $this->date->date()
                ]
                
            ];
            
			foreach ($dataNewsRows as $row) {
                $setup->getConnection()->insert($setup->getTable('bulbulatory_recomendations'), $row);
            }
		}
	}
}