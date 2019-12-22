<?php
/**
 * Displays a basic, non-interactive data table
 *
 * $header the html header built using $this->Html->tableHeaders
 * $collection an array of rows built using $this->Html->tableCells
 */
?>
<table class="table-list">
    <?php if (!empty($header)) : ?>
        <thead>
        <?= $header ?>
        </thead>
    <?php endif; ?>
    <?php if (!empty($collection)) : ?>
        <tbody>
        <?php foreach ($collection as $row) : ?>
            <?= $row ?>
        <?php endforeach; ?>
        </tbody>
    <?php endif; ?>
</table>