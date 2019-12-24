<?php
/**
 * @var \Apps\View\AppView $this
 * @var \User $user
 * @var \Apps\Model\Entity\Role[]|\Cake\Collection\CollectionInterface $roles
 */

//$this->extend('/Admin/add');
//$this->start('formContent');
//echo '<div class="flex-column margin-5">';
//echo '<h4>Roles</h4>';
//foreach ($roles as $role) {
//
////TODO the  information layout is going to be broken
// echo $this->Form->control(__($role->name), ['type' => 'checkbox']);
//}
//echo '</div>';
//$this->end();

$this->assign('title', $user->display_name);

echo "<h1>Manage Roles for  " . $user->username . "</h1>\n";

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

$image = $this->Url->build(['action' => 'profileImage', $user->ldapid]);
$title = $user->display_name;
$subtitle = [$user->title, $user->department];
$data = [
    [
        ['Username', $user->username],
        ['Location', $user->location],
        ['Department', $user->department],
        ['Manager', (empty($user->manager->display_name) ? "" : $user->manager->display_name)],
    ],
    [
        ['Email', $user->email],
        ['Direct', $this->Phone->format($direct)],
        ['Extension', $extension],
        ['Mobile', $this->Phone->format($mobile)],
    ],
];
foreach ($data as $key => $value) {
    foreach ($value as $k => $v) {
        $data[$key][$k][0] = "<label>" . $data[$key][$k][0] . ":</label>";
    }
}

echo $this->element('Apps.profile', ['image' => $image, 'title' => $title, 'subtitle' => $subtitle, 'data' => $data]);

echo $this->Form->create($user);
echo '<div class="flex-column margin-5 ">';
echo '<h4>Roles</h4>';
//echo '<span class="padding-5">' . $this->Form->control('roles._ids', ['type' => 'select', 'multiple' => 'checkbox', 'option' => $roles]). '</span>';
$userRoles = array_map(function ($role) {
    return $role->name;
}, $user->roles);
echo '<div class="flex-column-group" shaded padding-5-10">';

/*
    $count = count($roles);
    $no_of_columns = $count/4;*/
foreach ($roles as $role) {
    /**TODO use modulus to display columns */
    $checked = in_array($role->name, $userRoles);
    echo '<span class="padding-5">' . $this->Form->checkbox('role[]', [
            'value' => $role->id,
            'hiddenField' => false,
            'checked' => $checked,
        ]) . $this->Form->label($role->name) . '</span>';
}
echo '</div>';
echo '</div>';
echo '<div class="form-basic">';
echo $this->Form->button(__('Save'), ['class' => 'button']);
echo $this->Html->link(__('Cancel'), ['action' => 'view', $user->id], ['class' => 'button black']);
echo $this->Form->end();
echo '</div>';
