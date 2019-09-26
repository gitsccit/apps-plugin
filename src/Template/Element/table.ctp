<?php
/**
 * Displays an interactive data table for use with the cakephp Paginator
 *
 * $priority an array of numeric column priorities; 0 always shows the lowest numbers get the highest priority
 * $header the html header built using $this->Html->tableHeaders
 * $collection an array of rows built using $this->Html->tableCells
 */
?>
<div id="priority-table" class="table-responsive">
    <table id="data" class="table-list">
        <?php if(!empty($priority)): ?>
        <colgroup>
            <?php foreach($priority as $col): ?>
            <col data-priority="<?= $col ?>"/>
            <?php endforeach; ?>
        </colgroup>
        <?php endif; ?>
        <?php if(!empty($header)): ?>
        <thead>
            <?= $header ?>
        </thead>
        <?php endif; ?>
        <?php if(!empty($collection)): ?>
            <tbody>
            <?php foreach($collection as $row): ?>
            <?= $row ?>
            <?php endforeach; ?>
            </tbody>
        <?php endif; ?>
    </table>
    <div class="paginator">
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
    </div>
</div>