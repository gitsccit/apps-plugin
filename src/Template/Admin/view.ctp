<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Cake\ORM\Entity|array $entity
 */

use Cake\Utility\Inflector;

echo "<div class=\"links-top-right\">";
echo $this->Html->link('Edit', ['action' => 'edit', $entity->id], ['class' => 'button']);
echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $entity->id],
    ['class' => 'button black', 'confirm' => __('Are you sure you want to delete "{0}"?', $entity->$displayField)]
);
echo "</div>";

echo "<h1>" . Inflector::singularize($title) . " #$entity->id</h1>\n";

$data = array_map(function ($fieldChunk) use ($entity) {
    return array_map(function ($field) use ($entity) {
        return ['<label>' . humanize($field) . ':</label>', $this->Utils->display($entity->$field)];
    }, $fieldChunk);
}, array_chunk(array_keys($entity->toArray()), 4));

echo $this->element('Apps.profile', ['title' => $entity->$displayField, 'data' => $data]);

#### Display related properties as tabs ####

if (!isset($associations)) {
    return;
}

$tabs = [];
foreach ($associations as $association => $resultSet) {
    $tabs[humanize($association)] = $this->Utils->createTable($resultSet);
}

echo $this->element('Apps.tabs', ['tabs' => $tabs]);
