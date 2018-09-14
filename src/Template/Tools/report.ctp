<div class="column large-3">
	<?php echo $this->Element('sidebar', ['user_role' => $AuthUser['role']]); ?>
</div>
<div class="column large-9 content">
	<h2 class=""><?= __('Tool Count Report'); ?></h2>
	<p class=""><?= __('This report will count tool requirements across all jobs') ?></p>
	<?php if ( empty( $tools ) ) : ?>
		<p>There are no tools being used.</p>
	<?php else : ?>
		<table>
			<thead>
			<tr>
				<th>Tool</th>
				<th>Count</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ( $tools as $tool ): ?>
				<tr>
					<td><?= h( $tool->title ) ?></td>
					<td><?= number_format( $tool->tool_sum, 0, '.', ',' ) ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>

</div>