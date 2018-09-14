<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Todo Entity.
 *
 * @property int $todo_id
 * @property \App\Model\Entity\Todo $todo
 * @property int $job_id
 * @property \App\Model\Entity\Job $job
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property string $description
 * @property string $long_description
 * @property \Cake\I18n\Time $due
 * @property bool $completed
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class Todo extends Entity
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
        'todo_id' => false,
    ];
}
