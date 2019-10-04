<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Apps\Model\Entity\Permission $permission
 * @var \Apps\Model\Entity\PermissionGroup $permissionGroups
 */

echo "<h1>Admin Permissions </h1>";
?>
<p>
    The easiest way to give administrator privileges to another user is to assign pre-built administrator roles. Each
    role grants one or more privileges that together, allow performing a common business function. For example, one role
    allows managing user accounts, another role manages groups, another role manages calendars and resources, and so on.
    Assign multiple roles to grant all privileges in those roles.
</p>
<hr>
<h1><span class="icon-plus green"></span> Add New Permission</h1>
<p>Add a permission that can be assigned to a new or already existing role or group in the database.</p>
<div class="column">
<section class="form-basic">
    <?= $this->Form->create($permission) ?>
    <fieldset>
        <legend><?= __('Add Permission') ?></legend>
        <?php
        echo '<label><strong>Permission Group</strong></label>';
        echo $this->Form->control('permission_group_id',
            ['options' => $permissionGroups, 'empty' => true, 'label' => false]);
        echo '<label><strong>Permission Name</strong></label>';

        echo $this->Form->control('name', [
            'class' => 'small-input',
            'label' => false,
            'placeholder' => 'Enter Permission Name',
            'maxlength' => '30',
            'style' => 'width:300px'
        ]);

        echo '<label><strong>Permission Description </strong></label>';
        //TODO conflict with UX/UI and SA
        //TODO display maximum characters
        // echo $this->Form->control('description',['class' => 'input-textarea','label'=>false,'placeholder'=>'Enter a brief description','maxlength'=>'30']);
        echo $this->Form->textarea('description', [
            'class' => 'input-textarea',
            'label' => false,
            'placeholder' => 'Enter a brief description',
            'maxlength' => '100'
        ]);
        ?>
    </fieldset>
    <div class="margin-50 ">
        <?= $this->Form->button(__('Save'), ['class' => 'button']) ?>
        <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'button black']) ?>
        <?= $this->Form->end() ?>
    </div>
</section>
</div>
