<?php

namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

class User extends Entity
{

    // Make all fields mass assignable except for primary key field "id".
    protected $_accessible = [
        '*' => true,
        'user_id' => false
    ];

    protected function _getFullName() {
        return $this->_properties['first_name'] . ' ' .
            $this->_properties['last_name'];
    }

	protected function _getProfileComplete() {
		$props = [
			'address_1','city', 'shirt_size', 'state', 'transportation', 'zip_code'
		];
		foreach($props as $prop) {
			if( $this->_properties[$prop] == null || $this->_properties[$prop] == "" ) {
				return false;
			}
		}
		return true;
	}

    // ...

    protected function _setPassword($password)
    {
        return (new DefaultPasswordHasher)->hash($password);
    }

    // ...
}
