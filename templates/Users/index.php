<h1>Employee Directory</h1>
<hr>
<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Apps\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 * @var boolean $canSynchronizeLDAP
 */

$links = [];
if ($canSynchronizeLDAP) {
    $links[] = $this->Html->link('Synchronize Active Directory', ['action' => 'synchronizeLdap'],
        ['class' => 'button']);
}
echo $this->element('Apps.table_filter', ['links' => $links]);

$header = $this->Html->tableHeaders([
    $this->Paginator->sort('username', 'Alias'),
    $this->Paginator->sort('display_name', 'Name'),
    $this->Paginator->sort('email', 'Email'),
    $this->Paginator->sort('contact', 'Extension'),
    $this->Paginator->sort('contact', 'Mobile'),
    $this->Paginator->sort('title', 'Title'),
    $this->Paginator->sort('location', 'Location'),
    $this->Paginator->sort('department', 'Department'),
    $this->Paginator->sort('Manager.display_name', 'Manager'),
    $this->Paginator->sort('timezone.name', 'Timezone'),
    $this->Paginator->sort('active', 'Active')
]);

// priority 0 always shows
$priority = [
    0, // alias
    1, // name
    8, // email
    4, // extension
    9, // mobile
    7, // title
    5, // location
    6, // department
    10, // manager
    11, // timezone
    3, // active
];

$collection = [];
foreach ($users as $user) {

    $ext = $mobile = '';
    foreach ($user->user_contacts as $uc) {
        if ($uc->type == "Ext") {
            $ext = $uc->contact;
        } else {
            if ($uc->type == "Mobile") {
                $mobile = $uc->contact;
            }
        }
    }

    $row = $this->Html->tableCells([
        $this->Html->link(__($user->username), ['action' => 'view', $user->id]),
        h($user->display_name),
        h($user->email),
        h($ext),
        $this->Phone->format($mobile),
        h($user->title),
        h($user->location),
        h($user->department),
        (empty($user->manager->display_name) ? "" : h($user->manager->display_name)),
        (empty($user->time_zone->name) ? "" : h($user->time_zone->name)),
        h($user->active),
    ]);
    array_push($collection, $row);
}

echo $this->element('Skeleton.table', ['thead' => $header, 'tbody' => $collection, 'priority' => $priority]);
