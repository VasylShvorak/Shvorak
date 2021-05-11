<?php


namespace Shvorak\Action\Setup;


use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $table = $setup->getConnection()->newTable(
            $setup->getTable('shvorak_action')
        )->addColumn(
            'id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'Action ID'
        )->addColumn(
            'name',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Action name'
        )->addColumn(
            'description',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Action Description'
        )->addIndex(
            $setup->getIdxName('shvorak_action', ['name']),
            ['name']
        )->setComment('Actions for Product');

        $setup->getConnection()->createTable($table);
        $setup->endSetup();
    }

}
