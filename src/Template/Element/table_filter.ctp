<?php
/**
 * @var \Apps\View\AppView $this
 */
?>

<div class="table-header">
    <div class="table-filters">
        <?php
        echo $this->Form->create(null, ['type' => 'GET']);
        echo $this->Form->select('filter', $filterOptions);
        echo $this->Form->search('key', ['required' => true, 'placeholder' => 'Filter', 'size' => 30]);
        echo $this->Form->button(__('Submit'), ['class' => 'button']);
        echo $this->Form->end();
        ?>
    </div>
    <?php if (!empty($links)): ?>
        <div class="table-links">
            <?php foreach ($links as $link): ?>
                <?= $link ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
