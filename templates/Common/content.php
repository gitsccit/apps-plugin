<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Apps\Model\Entity\News[]|\Cake\Collection\CollectionInterface $news
 */
?>
<?php if ($this->fetch('banner')) : ?>
    <?= $this->fetch('banner') ?>
<?php endif ?>
<?php if ($this->fetch('title')) : ?>
    <h4><?= $this->fetch('title') ?></h4>
<?php endif ?>
<?php if ($this->fetch('links')) : ?>
    <div class="margin-50">
        <?= $this->fetch('links') ?>
    </div>
<?php endif ?>
<?php if ($this->fetch('buttons')) : ?>
    <div class="margin-50">
        <?= $this->fetch('buttons') ?>
    </div>
<?php endif ?>
<?php if ($this->fetch('body-content')) : ?>
    <?= $this->fetch('body-content') ?>
<?php endif ?>





