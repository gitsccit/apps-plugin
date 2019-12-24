<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Cake\Collection\CollectionInterface $entities
 */

if ($entities->count() === 0) {
    $plugin = $this->getPlugin();
    $controller = $this->getName();
    $entities = is_null($plugin) ? $controller : "$plugin.$controller";
}
?>

<h1><?= $title ?></h1>
<hr>

<?= $this->element('Apps.table_filter', [
    'links' => $links ?? [$this->Html->link('Add', ['action' => 'add'], ['class' => 'button add'])],
]) ?>

<?= $this->Utils->createTable($entities) ?>
