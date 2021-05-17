<?php


namespace Shvorak\Action\Setup;


use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $setup->getConnection()->insert(
            $setup->getTable('shvorak_action'),
            [
                'name' => 'Action 1'
            ]
        );
        $setup->getConnection()->insert(
            $setup->getTable('shvorak_action'),
            [
                'name' => 'Action 2'
            ]
        );
        $setup->endSetup();
    }
}
