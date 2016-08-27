<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Organization Entity.
 *
 * @property int $id
 * @property \Cake\I18n\Time $deleted_at
 * @property string $org_name
 * @property string $access_code
 * @property bool $flag_indiv
 * @property bool $flag_indiv_split
 * @property bool $flag_split
 * @property bool $flag_fishcamp
 * @property bool $flag_backup
 * @property bool $flag_corps
 * @property \App\Model\Entity\Job[] $job
 * @property \App\Model\Entity\OrganizationHasJob[] $organization_has_job
 * @property \App\Model\Entity\UserHasOrganization[] $user_has_organization
 * @property \App\Model\Entity\UserHasParticipationRequest[] $user_has_participation_request
 */
class Organization extends Entity
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
        'id' => false,
    ];
}
