<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Signature Entity
 *
 * @property int $signature_id
 * @property int $user_id
 * @property int $document_id
 * @property bool $signed
 * @property string $signature_text
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Signature $signature
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Document $document
 */
class Signature extends Entity
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
        'signature_id' => false
    ];
}
