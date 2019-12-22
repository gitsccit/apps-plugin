<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Cake\ORM\Entity|array $entity
 */

use Cake\Utility\Inflector;

$profileData = array_map(function ($fieldChunk) use ($entity) {
    return array_map(function ($field) use ($entity) {
        return ['<label>' . humanize($field) . ':</label>', $this->Utils->display($entity->$field)];
    }, $fieldChunk);
}, array_chunk(array_keys($entity->toArray()), 4));

$tabs = [];
foreach ($associations as $association => $resultSet) {
    $tabs[humanize($association)] = $this->Utils->createTable($resultSet);
}
?>

<div class="links-top-right">
    <?= $this->Html->link('Edit', ['action' => 'edit', $entity->id], ['class' => 'button']); ?>
    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $entity->id], [
        'class' => 'button black',
        'confirm' => __('Are you sure you want to delete "{0}"?', $entity->$displayField),
    ]); ?>
</div>
<h1><?= Inflector::singularize($title) . " #$entity->id"; ?></h1>
<hr>

<?= $this->element('Apps.profile', ['title' => $entity->$displayField, 'data' => $profileData]); ?>

<?php if (isset($associations)) : ?>
    <?= $this->element('Apps.tabs', ['tabs' => $tabs]) ?>
<?php endif; ?>
