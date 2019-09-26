<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Cake\ORM\Entity|array $entity
 */

use Cake\Utility\Inflector;

$this->Breadcrumbs->add('Admin');
$this->Breadcrumbs->add($title, ['action' => 'index']);
$this->Breadcrumbs->add($entity->$displayField, ['action' => 'view', $entity->id]);

echo "<div class=\"links-top-right\">";
echo $this->Html->link('Edit', ['action' => 'edit', $entity->id], ['class' => 'button']);
echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $entity->id],
    ['class' => 'button black', 'confirm' => __('Are you sure you want to delete "{0}"?', $entity->$displayField)]
);
echo "</div>";

echo "<h1>" . Inflector::classify($title) . " #$entity->id</h1>\n";

$data = array_map(function ($fieldChunk) use ($entity) {
    return array_map(function ($field) use ($entity) {
        return ['<label>' . Inflector::humanize($field) . ':</label>', $this->Utils->display($entity->$field)];
    }, $fieldChunk);
}, array_chunk(array_keys($entity->toArray()), 4));

echo $this->element('profile', ['title' => $entity->$displayField, 'data' => $data]);

#### Display related properties as tabs ####

if (!isset($associations)) {
    return;
}

$tabs = [];
foreach ($associations as $association => $resultSet) {
    $association = Inflector::camelize($association);
    $entities = $resultSet->isEmpty() ? $association : $resultSet;
    $tabs[Inflector::humanize(Inflector::underscore($association))] = $this->Utils->createTable($entities);
}

echo $this->element('tabs', ['tabs' => $tabs]);
