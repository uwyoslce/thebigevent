<?php

use Cake\Core\Configure;

?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<?php echo $this->Element('sidebar', ['user_role' => $AuthUser['role']]); ?>
</nav>

<div class="jobs view large-9 medium-8 columns content">
    <h1><?= __("Condition Preferences") ?>
    </h1>
    <p>Editing condition preferences for @<?= h($user->username) ?>. Select <em>Must Have</em> or <em>Can't Have</em> to
        to ensure participant is placed in a job that meets their preferences.
    </p>
	
	<?= $this->Form->create('ConditionPreference') ?>
    <table>
        <thead>
        <tr>
			<?php if (Configure::read('debug')): ?>
                <th>
					<?= __('condition_id') ?>
                </th>
			<?php endif; ?>
            <th>
				<?= __('Condition') ?>
            </th>
            <th>
				<?= __('Preference') ?>
            </th>
        </tr>
        </thead>
        <tbody>
		<?php if ($conditions) : ?>
			<?php foreach ($conditions as $i => $condition): ?>
                <tr>
					<?php if (Configure::read('debug')): ?>
                        <td>
							<?= h($condition->condition_id) ?>
                        </td>
					<?php endif; ?>
                    <td>
						<?= h($condition->title) ?>
                    </td>
                    <td>
						<?php
						$value = '0';
						if (isset($currentPreferences[$condition->condition_id])) {
							$value = $currentPreferences[$condition->condition_id];
						}
						echo $this->Form->hidden("ConditionPreference.$i.user_id", [
							'value' => $user->user_id
						]);
						echo $this->Form->hidden("ConditionPreference.$i.condition_id", [
							'value' => $condition->condition_id
						]);
						echo $this->Form->control("ConditionPreference.$i.preference", [
							'options' => [
								'-1' => __("Can't Have"),
								'0' => __('Can Have'),
								'1' => __("Must Have")
							],
							'value' => $value,
							'label' => false
						])
						
						?>
                    </td>
                </tr>
			
			<?php endforeach; ?>
		<? endif; ?>
        </tbody>
        <tfoot></tfoot>
    </table>

    <p class="text-right">
		<?= $this->Form->button('Save Preferences') ?>
    </p>
	
	<?= $this->Form->end() ?>
	
	
	
	<?php
	
	debug($currentPreferences);
	debug($user);
	debug($conditions->toArray());
	
	?>

</div>