<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Membership extends Entity {

	protected $_accessible = [
		'*' => true,
	];
}