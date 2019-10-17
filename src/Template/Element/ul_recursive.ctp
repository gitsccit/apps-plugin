<?php
// convert active links into a usable format
if(empty($handler)) $handler = "";
if($handler == "active") {
    $temps = $links;
    $links = [];
    foreach($temps as $temp) {

        $url = $temp->destination;
        if(substr($url,0,1) == "{") $url = json_decode($url,true);
        if(empty($url)) $url = "javascript:void(0)";

        $content = $temp->title;
        if($temp->file_id)
            $content = '<span class="file-icon" style="background-image:url('.$this->Url->build(['controller' => 'files','action' => 'resize',$temp->file_id,50]).')"></span>'.$content;

        $attr = ['escape' => false];
        if(!empty($temp->htmlid))
            $attr['id'] = $temp->htmlid;

        $links[] = [
            'content' => $this->Html->link($content,$url,$attr),
            'children' => (isset($temp->child_links) && sizeof($temp->child_links) ? $temp->child_links : false),
        ];
    }
}
?>

<ul<?php
if(!empty($id)) echo ' id="'.$id.'"';
if(isset($display) && $display === false) echo ' style="display:none"';
?>>
<?php
foreach($links as $link) {
    echo "<li>".$link['content'];
    if($link['children'])
        echo $this->element('Apps.ul_recursive',['links' => $link['children'],'display' => $display,'handler' => $handler]);
    echo "</li>\n";
}
?>
</ul>