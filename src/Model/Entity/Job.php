<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Job Entity.
 *
 * @property int $job_id
 * @property \App\Model\Entity\Job $job
 * @property string $contact_first_name
 * @property string $contact_last_name
 * @property string $contact_phone
 * @property string $contact_email
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property string $contact_address_1
 * @property string $contact_address_2
 * @property string $contact_city
 * @property string $contact_state
 * @property string $contact_zip
 * @property string $contact_best_time_to_call
 * @property string $referral
 * @property string $job_description
 * @property \App\Model\Entity\Task[] $tasks
 */
class Job extends Entity
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
        'job_id' => false,
    ];

    protected function getOrDefault(&$get, $default) {
        if( isset($get) & !empty($get) )
            return $get;
        else {
            return $default;
        }
    }

    protected function _getDisplayField() {
        $chunks = [
            $this->_properties['contact_last_name'] . ',',
            $this->_properties['contact_first_name'] . ';',
            $this->_properties['contact_address_1'] . ';',
            $this->_properties['contact_city'] . ',',
            $this->_properties['contact_state'],
            $this->_properties['contact_zip']
        ];
        return implode(' ', $chunks);
    }

}
