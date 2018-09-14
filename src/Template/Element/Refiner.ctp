<?php
if( !empty($refinerGroups) ) {
	foreach($refinerGroups as $refinerGroupLabel => $refinerGroup) {
		echo $this->Html->tag('dt', $refinerGroupLabel , ['class' => 'refiner__heading']);
		foreach($refinerGroup as $refinerLabel => $refiner) {
			echo $this->Html->tag('dd',
				$this->Html->link($refinerLabel, $refiner['url']), [
					'class' => [
						'refiner__option',
						$refiner['active'] ? 'refiner__option--active active' : 'refiner__option--inactive'
					]
				]
			);
		}
	}
}