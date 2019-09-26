<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Cake\Collection\CollectionInterface $entities
 */

$this->Breadcrumbs->add('Admin');
$this->Breadcrumbs->add($title, ['action' => 'index']);

echo "<h1>Admin : $title</h1><hr>";

echo $this->element('table_filter', [
    'links' => [$this->Html->link('Add', ['action' => 'add'], ['class' => 'button add'])],
]);

if ($entities->count() === 0) {
    $entities = $className;
}
echo $this->Utils->createTable($entities);
