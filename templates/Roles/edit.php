<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Apps\Model\Entity\Role $role
 *  * @var \Apps\Model\Entity\PermissionGroup[]|\Cake\Collection\CollectionInterface $permissionGroups
 */

$this->assign('title', $role->name);
echo "<h1>Admin Role : " . $role->name . "</h1>";

?>
<p>As an administrator, you can add users directly or synchronize users from your on-premises Active Directory. Once
    added, users can enroll devices and access company resources. You can also give users additional permissions
    including global administrator and service administrator permissions.
</p>
<hr>
<?php
echo $this->Form->create($role);
echo '<div class="edit-name"><a href="#" onclick="enableFunction()" >Edit Name</a></div>';
echo $this->Form->control('name', ['class' => 'edit-name-input', 'label' => false, 'maxlength' => '30']);
echo '<div class="flex-column">';
echo '<p>Please assign the appropriate permission levels for the following role below.</p>';
$rolePermissions = array_map(function ($p) {
    return $p->name;
}, $role->permissions);
echo '<div class="flex-row form-tiles ">';
foreach ($permissionGroups as $pg) {
    echo '<div>';
    echo '<div>';
    echo '<div class="flex-column-group">';
    //TODO  h3 larger font than h1
    echo '<h5 class="align-center">' . $pg->name . '</h5>';
    foreach ($pg->permissions as $permission) {
        $checked = in_array($permission->name, $rolePermissions);
        echo '<span class="padding-5">' . $this->Form->checkbox('permission[]', [
                'value' => $permission->id,
                'hiddenField' => false,
                'checked' => $checked,
            ]) . '<strong>' . $permission->name . '</strong></span>';
    }
    echo '</div>';
    echo '</div>';
    echo '</div>';
}

echo '</div>';
echo '</div>';
echo '<div class="align-left form-basic">';
echo $this->Form->button(__('Update'), ['class' => 'button']);
//Todo this is refresh the page so as the user can see the current state of selected permissions before an update/modification was made to the data
echo $this->Html->link(__('Default'), ['action' => 'edit', $role->id], ['class' => 'button']);
echo $this->Form->end();
echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $role->id], ['confirm' => __('Are you sure you want to delete # {0}?', $role->id),'class' => 'button black post-link']);
echo '</div>';

?>
<!--TODO move this to the main script-->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("name").disabled = true;
    });
    function enableFunction() {
                document.getElementById("name").disabled = (!document.getElementById("name").disabled);
    }
</script>



