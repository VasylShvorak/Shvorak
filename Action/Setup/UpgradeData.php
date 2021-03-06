<?php


namespace Shvorak\Action\Setup;


use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use function Sodium\compare;

class UpgradeData implements UpgradeDataInterface
{

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if(version_compare($context->getVersion(), '1.0.1', '<')) {
            $setup->getConnection()->update(
                $setup->getTable('shvorak_action'),
                [
                    'description' => "Default description"
                ],
                $setup->getConnection()->quoteInto('id = ?', 1)
            );
        }

        if(version_compare($context->getVersion(), '1.0.2', '<')) {
            $setup->getConnection()->insert(
                $setup->getTable('shvorak_action_products'),
                [
                    'action_id' => 1,
                    'product_id' => 1
                ]
            );
            $setup->getConnection()->insert(
                $setup->getTable('shvorak_action_products'),
                [
                    'action_id' => 1,
                    'product_id' => 2
                ]
            );
            $setup->getConnection()->insert(
                $setup->getTable('shvorak_action_products'),
                [
                    'action_id' => 2,
                    'product_id' => 1
                ]
            );
        }
        $setup->endSetup();
    }
}
