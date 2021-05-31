<?php

namespace Shvorak\Action\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('shvorak_action'),
                'short_description',
                [
                    'type' => Table::TYPE_TEXT,
                    'nullable' => true,
                    'comment' => 'Action Short Description'
                ]
            );
        }

        if (version_compare($context->getVersion(), '1.0.2', '<')) {
            $table = $setup->getConnection()->newTable(
                $setup->getTable('shvorak_action_products')
            )->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'ID'
            )->addColumn(
                'action_id',
                Table::TYPE_INTEGER,
                255,
                ['nullable' => false],
                'Action ID'
            )->addColumn(
                'product_id',
                Table::TYPE_INTEGER,
                255,
                ['nullable' => true],
                'Product ID'
            )->addIndex(
                $setup->getIdxName('shvorak_action_products', ['action_id']),
                ['action_id']
            )->setComment('Product list for actions');

            $setup->getConnection()->createTable($table);
        }

        if (version_compare($context->getVersion(), '1.0.3', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('shvorak_action'),
                'image',
                [
                    'type' => Table::TYPE_TEXT,
                    'size' => 255,
                    'nullable' => true,
                    'comment' => 'Action Image'
                ]
            );
        }

        $setup->endSetup();
    }
}
