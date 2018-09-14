<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TodosTemplate Entity.
 *
 * @property int $todo_template_id
 * @property \App\Model\Entity\TodoTemplate $todo_template
 * @property string $description
 * @property string $long_description
 * @property string $due_description
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class TodosTemplate extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'todo_template_id' => false,
    ];
}
