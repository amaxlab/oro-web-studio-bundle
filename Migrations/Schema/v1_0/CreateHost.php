<?php

/*
 * This file is part of the WebStudioBundle project.
 *
 * (c) AmaxLab 2017 <http://www.amaxlab.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AmaxLab\Oro\WebStudioBundle\Migrations\Schema\v1_0;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\OrderedMigrationInterface;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

/**
 * @author Egor Zyuskin <ezyuskin@amaxlab.ru>
 */
class CreateHost implements Migration, OrderedMigrationInterface
{
    /**
     * @param Schema   $schema
     * @param QueryBag $queries
     *
     * @return void
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        $table = $schema->createTable('web_studio_host');

        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('name', 'string', ['length' => 255, 'notnull' => true]);
        $table->addColumn('host_provider_id', 'integer', ['notnull' => true]);
        $table->addColumn('os', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('cpu', 'integer', ['notnull' => false]);
        $table->addColumn('memory', 'integer', ['notnull' => false]);
        $table->addColumn('hdd', 'integer', ['notnull' => false]);
        $table->addColumn('business_unit_owner_id', 'integer', ['notnull' => false]);
        $table->addColumn('organization_id', 'integer', ['notnull' => false]);
        $table->addColumn('created_at', 'datetime');
        $table->addColumn('updated_at', 'datetime');

        $table->addIndex(['host_provider_id']);
        $table->addIndex(['business_unit_owner_id']);
        $table->addIndex(['organization_id']);

        $table->addForeignKeyConstraint($schema->getTable('web_studio_host_provider'), ['host_provider_id'], ['id'], ['onDelete' => 'restrict', 'onUpdate' => null]);
        $table->addForeignKeyConstraint($schema->getTable('oro_business_unit'), ['business_unit_owner_id'], ['id'], ['onDelete' => 'SET NULL', 'onUpdate' => null]);
        $table->addForeignKeyConstraint($schema->getTable('oro_organization'), ['organization_id'], ['id'], ['onDelete' => 'SET NULL', 'onUpdate' => null]);

        $table->setPrimaryKey(['id']);

        $table = $schema->createTable('web_studio_host_roles');
        $table->addColumn('host_id', 'integer', ['notnull' => true]);
        $table->addColumn('role_id', 'integer', ['notnull' => true]);

        $table->addIndex(['host_id']);
        $table->addIndex(['role_id']);
        $table->setPrimaryKey(['host_id', 'role_id']);

        $table->addForeignKeyConstraint($schema->getTable('web_studio_host'), ['host_id'], ['id'], ['onDelete' => 'CASCADE', 'onUpdate' => null]);
        $table->addForeignKeyConstraint($schema->getTable('web_studio_role'), ['role_id'], ['id'], ['onDelete' => 'CASCADE', 'onUpdate' => null]);
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 70;
    }
}
