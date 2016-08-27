<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserIdentity Entity
 *
 * @property int $user_identity_id
 * @property int $user_id
 * @property string $protocol
 * @property string $realm
 * @property string $identifier
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Userentity $userentity
 * @property \App\Model\Entity\User $user
 */
class UserIdentity extends Entity
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
        'user_identity_id' => false
    ];
}
