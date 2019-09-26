<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Apps\Model\Entity\Option $option
 */
$timezone = $this->request->getSession()->read('Auth.User.time_zone.name');

$this->Breadcrumbs->add('Admin');
$this->Breadcrumbs->add('Options',['action' => 'index']);
$this->Breadcrumbs->add($option->name);

echo "<div class=\"links-top-right\">";
echo $this->Html->link('Edit',['action' => 'edit',$option->id],['class' => 'button']);
echo $this->Form->postLink(
    __('Delete'),
    ['action' => 'delete', $option->id],
    ['class' => 'button black','confirm' => __('Are you sure you want to delete # {0}?', $option->id)]
);
echo "</div>";

echo "<h1>Option #".$option->id."</h1>\n";

$title = $option->name;

$data = [
    [
        ['Type', $option->type],
        ['Value', $this->element('option-value',['type' => $option->type,'value' => $option->value])],
        ['Timestamp', $option->timestamp->setTimezone($timezone)],
    ],
];
foreach($data as $key => $value)
    foreach($value as $k => $v)
        $data[$key][$k][0] = "<label>".$data[$key][$k][0].":</label>";

echo $this->element('profile',['title' => $title,'data' => $data]);
?>

<hr>

<h4>Store-specific values</h4>
<?php
if(empty($option->option_stores)) echo "<i>none</i>";
else {
    $header = $this->Html->tableHeaders(['Store','Environment','Value','Timestamp']);
    foreach($option->option_stores as $os) {

        $collection[] = $this->Html->tableCells([
            $os['store']->name,
            $os['environment']->name,
            $this->element('option-value',['type' => $option->type,'value' => $os->value]),
            $os->timestamp->setTimezone($timezone),
        ]);
    }

    echo $this->element('table-list',['header' => $header,'collection' => $collection]);
}

?>
