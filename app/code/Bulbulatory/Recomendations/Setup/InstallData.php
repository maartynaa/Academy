<?php

namespace Bulbulatory\Recomendations\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
	protected $date;

	public function __construct(\Magento\Framework\Stdlib\DateTime\DateTime $date)
	{
		$this->date = $date;
	}

	public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
	{
		$dataNewsRows = [
            [
                'recommender_id' => 2,
                'e-mail' => 'jkowalski@mail.com',
                'hash' => 'e23nj44pak',
                'confirmed_at' => null
            ],
            [
                'recommender_id' => 3,
                'e-mail' => 'mnowak@mail.com',
                'hash' => 'x8iqo98n23',
                'status' => 1,
                'confirmed_at' => $this->date->date()
            ]
        ];
        

		foreach ($dataNewsRows as $row) {
            $setup->getConnection()->insert($setup->getTable('bulbulatory_recomendations'), $row);
        }
	}
}
