<h1>Files</h1>
<hr>
<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Apps\Model\Entity\File[]|\Cake\Collection\CollectionInterface $files
 */

$timezone = $this->request->getSession()->read('Auth.User.time_zone.name');

echo $this->element('Apps.table_filter', [
    'links' => [$this->Html->link('Add', ['action' => 'add'], ['class' => 'button add'])],
]);

$header = $this->Html->tableHeaders([
    '',
    $this->Paginator->sort('name'),
    $this->Paginator->sort('mime_type'),
    $this->Paginator->sort('size'),
    $this->Paginator->sort('width'),
    $this->Paginator->sort('height'),
    $this->Paginator->sort('created_at'),
    $this->Paginator->sort('Users.name', 'Uploaded By'),
    $this->Paginator->sort('accessed_at'),
]);

// priority 0 always shows
$priority = [
    0, // name
    1, // type
    4, // mime_type
    2, // size
    6, // width
    7, // height
    3, // created_at
    8, // uploaded by
    5, // accessed_at
];

$collection = [];
foreach ($files as $file) {
    $row = $this->Html->tableCells([
        $this->Html->image(
            ['controller' => 'files', 'action' => 'resize', $file->id, 50, 50],
            ['class' => 'table-thumb']
        ),
        $this->Html->link(__($file->name), ['action' => 'view', $file->id]),
        (empty($file->mime_type->name) ? "" : h($file->mime_type->name)),
        $this->Number->toReadableSize($file->size),
        (string)$file->width,
        (string)$file->height,
        h($file->created_at->setTimezone($timezone)),
        (empty($file->user->display_name) ? "" : h($file->user->display_name)),
        h($file->accessed_at->setTimezone($timezone)),
    ]);
    array_push($collection, $row);
}

echo $this->element('Skeleton.table', ['thead' => $header, 'tbody' => $collection, 'priority' => $priority]);
