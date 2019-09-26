<?php
/**
 * @var applinks the array of app_links to be drawn
 */
foreach($applinks as $applink) {
    $m = $indent * $margin;
    echo '<div class="navmenu-item" data-indent="'.$indent.'" style="margin-left:'.$m.'px" onclick="navmenueditSelect(this)"><span>';
    echo $applink['title'];
    echo '</span><input type="hidden" name="applink'.$applink->id.'" value="'.h(json_encode([
            'id' => $applink['id'],
            'indent' => $indent,
            'title' => $applink['title'],
            'permission_id' => $applink['permission_id'],
            'htmlid' => $applink['htmlid'],
            'destination' => $applink['destination'],
            'file_id' => $applink['file_id']])).'">';
    echo '</div>';
    // increase indent and recursively call this element if there are children
    if(!empty($applink['child_links']) && sizeof($applink['child_links']))
        echo $this->element('navmenu-edit-items',['applinks' => $applink['child_links'],'indent' => $indent+1,'margin' => $margin]);
}
?>

