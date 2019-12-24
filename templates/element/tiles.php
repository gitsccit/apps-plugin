<?php
/**
 * Displays data tiles for use with the cakephp Paginator
 *
 * $collection an array of tiles
 */
?>

<div id="data" class="tile-list">
    <?php if (!empty($collection)) : ?>
        <?php foreach ($collection as $tile) : ?>
            <?= $tile ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<div class="paginator">
    <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    <ul class="pagination">
        <?= $this->Paginator->first('<< ' . __('first')) ?>
        <?= $this->Paginator->prev('< ' . __('previous')) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next(__('next') . ' >') ?>
        <?= $this->Paginator->last(__('last') . ' >>') ?>
    </ul>
</div>
