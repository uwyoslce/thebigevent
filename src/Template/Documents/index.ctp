<aside class="large-3 column">
	<?php echo $this->Element('sidebar', ['user_role' => $AuthUser['role']]); ?>
</aside>
<article class="large-9 columns content">

	<h1><?= __( "Manage Documents" ); ?></h1>
	<p>
		<?= __( "You can upload documents to collect digital signatures on.  Once your document is uploaded, \"Distribute\" it to have users begin signing." ) ?>
	</p>

	<p><?= $this->Html->link(__('Upload Document'), ['action' => 'upload'], ['class' => 'button']) ?></p>

	<?php if ( $documents->count() == 0 ): ?>
		<p>
			<?= __('There are no documents in the system at this time.') ?>
			<?= __('Upload a document to begin gathering signatures.') ?>
		</p>
	<?php else: ?>
		<table class="table-auto">
			<thead>
				<tr>
					<th></th>
					<th><?= __('Document Title') ?></th>
					<th><?= __('Distributed') ?></th>
					<th><?= __('Signed') ?></th>
					<th></th>
				</tr>
			</thead>
			<?php foreach ( $documents as $document ): ?>
				<tr>
					<td class="cell-shrink"><div class="button-group"><?php
						echo $this->Html->link( __( 'Summary' ), ['action' => 'view', $document->document_id], ['class'=>'button tiny success'] );
						echo $this->Html->link( __( 'Download' ), $document->path, [ 'class' => 'button tiny secondary' ] ); ?></div></td>
					<td>
						<strong class="u-nowrap"><?= h( $document->title ); ?></strong><br>
						<?= $document->created->nice( $AuthUser['time_zone']) ?>
					</td>
					<td class="cell-shrink"><?= number_format($document->distributed_count) ?></td>
					<td class="cell-shrink"><?= number_format($document->signed_count) ?></td>
					<td class="cell-shrink">
						<div class="button-group">
					<?php
						echo $this->Html->link( __( 'Distribute' ), [
							'action' => 'distribute',
							$document->document_id
						], [ 'class' => 'button tiny' ] );

						echo $this->Html->link( __( 'Withdraw' ), [
							'action' => 'withdraw',
							$document->document_id
						], [ 'class' => 'button tiny secondary' ] );

						echo $this->Form->postLink( __('Delete'), [
							'action' => 'delete',
							$document->document_id
						], ['class' => 'button tiny alert']);
					?>
					</div>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
	<?php endif; ?>
</article>