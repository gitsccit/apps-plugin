<?php
/**
 * @var AppView $this
 * @var User $user
 * @var boolean $canEditRoles
 * @var boolean $canSynchronizeLDAP
 * @var boolean $canLoginAs
 */
$this->assign('title', $user->display_name);

$this->Breadcrumbs->add('Apps');
$this->Breadcrumbs->add('Users', ['action' => 'index']);
$this->Breadcrumbs->add('View');
$this->Breadcrumbs->add($user->display_name, ['action' => 'view', $user->id]);

echo "<div class=\"links-top-right\">";
echo $this->Html->link('Edit Time Zone', ['action' => 'edit', $user->id], ['class' => 'button']);
echo "</div>";

echo "<h1>User Profile #" . $user->id . "</h1>\n";

echo "<hr>\n";
echo $this->Html->link('Kill Session', ['controller' => 'Session', 'action' => 'kill', $user->id],
    ['class' => 'button']);

if ($canSynchronizeLDAP) {
    echo $this->Html->link('Refresh AD Data', ['action' => 'synchronizeLdap', $user->id], ['class' => 'button']);
}
if ($canLoginAs) {
    if ($this->request->getSession()->read('Auth.User.id') != $user->id) {
        echo $this->Html->link('Log In As User', ['controller' => 'Session', 'action' => 'loginAs', $user->id],
            ['class' => 'button']);
    }
}
if ($canEditRoles) {
    echo $this->Html->link('Edit Roles', ['action' => 'roles', $user->id], ['class' => 'button']);
}
// load direct, mobile, and ext fields from the user contacts
$direct = $mobile = $extension = "";
foreach ($user->user_contacts as $contact) {
    if ($contact->type == "Direct") {
        $direct = $contact->contact;
    }
    if ($contact->type == "Mobile") {
        $mobile = $contact->contact;
    }
    if ($contact->type == "Ext") {
        $extension = $contact->contact;
    }
}

$image = $this->Url->build(['action' => 'profileimage', $user->ldapid]);
$title = $user->display_name;
$subtitle = [$user->title, $user->department];
$data = [
    [
        ['Username', $user->username],
        ['Location', $user->location],
        ['Department', $user->department],
        ['Manager', (empty($user->manager->display_name) ? "" : $user->manager->display_name)],
        ['Active', $user->active],
    ],
    [
        ['Email', $user->email],
        ['Direct', $this->Phone->format($direct)],
        ['Extension', $extension],
        ['Mobile', $this->Phone->format($mobile)],
        ['Time Zone', (empty($user->time_zone->name) ? "" : $user->time_zone->name)],
    ],
];
foreach ($data as $key => $value) {
    foreach ($value as $k => $v) {
        $data[$key][$k][0] = "<label>" . $data[$key][$k][0] . ":</label>";
    }
}

echo $this->element('Apps.profile', ['image' => $image, 'title' => $title, 'subtitle' => $subtitle, 'data' => $data]);

// view block for contacts
$this->start('contacts');
$header = $this->Html->tableHeaders(['Type', 'Contact']);
$collection = [];
foreach ($user->user_contacts as $contact) {
    $c = $contact->contact;
    if (array_search($contact->type, ['Mobile', 'Direct']) !== false) {
        $c = $this->Phone->format($c);
    }
    $collection[] = $this->Html->tableCells([
        h($contact->type),
        h($c),
    ]);
}
echo $this->element('Apps.table-list', ['header' => $header, 'collection' => $collection]);
$this->end();

// view block for roles
$this->start('roles');
$header = $this->Html->tableHeaders(['Name']);
$collection = [];
foreach ($user->roles as $role) {
    $collection[] = $this->Html->tableCells([
        h($role->name),
    ]);
}
echo $this->element('Apps.table-list', ['header' => $header, 'collection' => $collection]);
$this->end();

$tabs = [
    'Contacts' => $this->fetch('contacts'),
    'Roles' => $this->fetch('roles'),
];
echo $this->element('Apps.tabs', ['tabs' => $tabs]);
