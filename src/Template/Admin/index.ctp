<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Cake\Collection\CollectionInterface $entities
 */

use Cake\Utility\Inflector;

$this->Breadcrumbs->add($this->getPlugin() ?? Inflector::humanize(basename(ROOT)));
$this->Breadcrumbs->add($title, ['action' => 'index']);

echo "<h1>Admin : $title</h1><hr>";

echo $this->element('Apps.table_filter', [
    'links' => [$this->Html->link('Add', ['action' => 'add'], ['class' => 'button add'])],
]);

if ($entities->count() === 0) {
    $plugin = $this->getPlugin();
    $entities = is_null($plugin) ? $className : "$plugin.$className";
}
echo $this->Utils->createTable($entities);
