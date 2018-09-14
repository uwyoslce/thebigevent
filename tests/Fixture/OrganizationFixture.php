<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrganizationFixture
 *
 */
class OrganizationFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'organization';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'deleted_at' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'org_name' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'access_code' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'flag_indiv' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'flag_indiv_split' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'flag_split' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'flag_fishcamp' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'flag_backup' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'flag_corps' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'account_idx' => ['type' => 'index', 'columns' => ['access_code'], 'length' => []],
            'search_idx' => ['type' => 'index', 'columns' => ['org_name'], 'length' => []],
            'sort_idx' => ['type' => 'index', 'columns' => ['flag_indiv', 'flag_split', 'flag_fishcamp', 'flag_backup', 'flag_corps'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'deleted_at' => '2016-06-15 01:55:39',
            'org_name' => 'Lorem ipsum dolor sit amet',
            'access_code' => 'Lorem ipsum dolor sit amet',
            'flag_indiv' => 1,
            'flag_indiv_split' => 1,
            'flag_split' => 1,
            'flag_fishcamp' => 1,
            'flag_backup' => 1,
            'flag_corps' => 1
        ],
    ];
}
