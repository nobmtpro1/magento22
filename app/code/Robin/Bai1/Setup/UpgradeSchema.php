<?php

namespace Robin\Bai1\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{

    /**
     * {@inheritdoc}
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.0.3') < 0) {
            $connection = $setup->getConnection();
            $connection->addColumn(
                $setup->getTable('banner'),
                'sort_order',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'length' => 10,
                    'nullable' => false,
                    'default' => 0,
                    'comment' => 'Address field'
                ]
            );
        }

        if (version_compare($context->getVersion(), '1.0.4') < 0) {
            $connection = $setup->getConnection();
            $connection->addColumn(
                $setup->getTable('banner'),
                'status',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                    'nullable' => false,
                    'default' => true,
                    'comment' => 'status'
                ]
            );
        }
    }
}
