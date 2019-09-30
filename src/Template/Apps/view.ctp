<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Apps\Model\Entity\App $app
 */
$timezone = $this->request->getSession()->read('Auth.User.time_zone.name');

$this->Breadcrumbs->add('Admin');
$this->Breadcrumbs->add('Apps',['action' => 'index']);
$this->Breadcrumbs->add($app->name);

echo "<div class=\"links-top-right\">";
echo $this->Html->link('Edit',['action' => 'edit',$app->id],['class' => 'button']);
echo $this->Form->postLink(
    __('Delete'),
    ['action' => 'delete', $app->id],
    ['class' => 'button black','confirm' => __('Are you sure you want to delete # {0}?', $app->id)]
);
echo "</div>";

echo "<h1>App #".$app->id."</h1>\n";

$title = $app->name;

$data = [
    [
        ['Name', $app->name],
        ['Cake Plugin', $app->cake_plugin],
        ['Route', $app->route],
    ],
];
foreach($data as $key => $value)
    foreach($value as $k => $v)
        $data[$key][$k][0] = "<label>".$data[$key][$k][0].":</label>";

echo $this->element('Apps.profile',['title' => $title,'data' => $data]);
?>

<hr>

<h4>Nav Menu</h4>
<?php
$header = $this->Html->tableHeaders(['Title','Destination','HtmlID','Permission','Thumbnail','Added','Modified']);
$collection = [];
foreach($app->app_links as $applink) {
    $url = $applink->destination;
    if(substr($applink->destination,0,1) == "{") {
        $temp = json_decode($applink->destination,true);
        $url = $this->Url->build($temp);
    }
    $collection[] = $this->Html->tableCells([
        '<span style="margin-left:'.($applink->indent * 40).'px">'.$applink->title.'</span>',
        $url,
        $applink->htmlid,
        (empty($applink->permission->name) ? "" : $applink->permission->name),
        (empty($applink->file->name) ? "" : $applink->filename),
        (empty($applink->created_at) ? '' : $applink->created_at->timezone($timezone)),
        (empty($applink->modified_at) ? '' : $applink->modified_at->timezone($timezone)),
    ]);
}
?>
<?= $this->element('Apps.table-list',['header' => $header,'collection' => $collection]) ?>
