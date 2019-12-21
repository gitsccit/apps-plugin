<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Apps\Model\Entity\News[]|\Cake\Collection\CollectionInterface $news
 */
$this->Html->css('Apps.scc-form.css', ['block' => 'scc-form']);
?>
<section class="width-1200">
    <?php if ($this->fetch('title')): ?>
        <h4><?= $this->fetch('title') ?></h4>

    <?php endif ?>
    <?php if ($this->fetch('links')): ?>
        <div class="margin-50">
            <?= $this->fetch('links') ?>
        </div>
    <?php endif ?>
    <?php if ($this->fetch('buttons')): ?>
        <div class="margin-50">
            <?= $this->fetch('buttons') ?>
        </div>
    <?php endif ?>
    <?php if ($this->fetch('body-form')): ?>

            <div class="padded-box margin-10">
                <?= $this->fetch('body-form') ?>
            </div>

    <?php endif ?>

</section>
