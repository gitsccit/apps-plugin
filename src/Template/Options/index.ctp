<h1>Admin : Options</h1>
<hr>
<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Apps\Model\Entity\Option[]|\Cake\Collection\CollectionInterface $options
 */

$this->Breadcrumbs->add('Admin');
$this->Breadcrumbs->add('Options', ['action' => 'index']);
$this->Breadcrumbs->add('List', ['action' => 'index']);

echo $this->element('Apps.table_filter', [
    'links' => [$this->Html->link('Add', ['action' => 'add'], ['class' => 'button add'])],
]);

$header = $this->Html->tableHeaders([
    $this->Paginator->sort('name'),
    $this->Paginator->sort('type'),
    $this->Paginator->sort('value'),
    $this->Paginator->sort('timestamp'),
    'Actions'
]);

// priority 0 always shows
$priority = [
    0, // name
    1, // type
    0, // value
    2, // timestamp
    0, // actions
];

$collection = [];
foreach ($options as $option) {

    $row = $this->Html->tableCells([
        $this->Html->link(__($option->name), ['action' => 'view', $option->id]),
        h($option->type),
        $this->element('Apps.option-value', ['type' => $option->type, 'value' => $option->value]),
        h($option->timestamp),
        $this->Html->link(__('Edit'), ['action' => 'edit', $option->id]),
    ]);
    array_push($collection, $row);

}

echo $this->element('Skeleton.table', ['thead' => $header, 'tbody' => $collection, 'priority' => $priority]);
