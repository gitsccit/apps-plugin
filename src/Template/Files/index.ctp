<h1>Admin : Files</h1>
<hr>
<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Apps\Model\Entity\File[]|\Cake\Collection\CollectionInterface $files
 */

use Cake\I18n\Number;

$timezone = $this->request->getSession()->read('Auth.User.time_zone.name');

$this->Breadcrumbs->add('Admin');
$this->Breadcrumbs->add('Files', ['action' => 'index']);
$this->Breadcrumbs->add('List', ['action' => 'index']);

echo $this->element('table_filter', [
    'links' => [$this->Html->link('Add', ['action' => 'add'], ['class' => 'button add'])],
]);

$header = $this->Html->tableHeaders([
    '',
    $this->Paginator->sort('name'),
    $this->Paginator->sort('mime_type'),
    $this->Paginator->sort('size'),
    $this->Paginator->sort('width'),
    $this->Paginator->sort('height'),
    $this->Paginator->sort('date_created'),
    $this->Paginator->sort('Users.name', 'Uploaded By'),
    $this->Paginator->sort('date_accessed'),
]);

// priority 0 always shows
$priority = [
    0, // name
    1, // type
    4, // mime_type
    2, // size
    6, // width
    7, // height
    3, // date_created
    8, // uploaded by
    5, // date_accessed
];

$collection = [];
foreach ($files as $file) {

    $row = $this->Html->tableCells([
        $this->Html->image(['controller' => 'files', 'action' => 'resize', $file->id, 50, 50],
            ['class' => 'table-thumb']),
        $this->Html->link(__($file->name), ['action' => 'view', $file->id]),
        (empty($file->mime_type->name) ? "" : h($file->mime_type->name)),
        Number::toReadableSize($file->size),
        h($file->width),
        h($file->height),
        h($file->date_created->setTimezone($timezone)),
        (empty($file->user->display_name) ? "" : h($file->user->display_name)),
        h($file->date_accessed->setTimezone($timezone))
    ]);
    array_push($collection, $row);

}

echo $this->element('table', ['header' => $header, 'collection' => $collection, 'priority' => $priority]);
