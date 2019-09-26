<?php
/**
 * @var title
 * @var description
 * @var applinks the array of app_links to be drawn
 */
?>

<div class="float-right" style="margin-top:5px"><a href="javascript:void(0)" class="button" onclick="navmenueditAdd()"><span class="icon-plus"></span> Insert Menu Item</a></div>
<h4><?= h($title) ?></h4>
<p><?= h($description) ?></p>

<div class="navmenu-edit" data-margin="<?= $margin ?>">
    <div class="navmenu-items">
    <?= $this->element('navmenu-edit-items',['applinks' => $applinks,'indent' => 0,'margin' => $margin]) ?>
    </div>
    <div class="navmenu-fields">
        <div style="display:none">
            <div class="flex-row">
                <div>
                    <label>Sort:</label>
                    <a href="javascript:void(0)" onclick="navmenueditSort(-1)"><span class="icon-angle-circled-left rotate-90"></span></a>
                    <a href="javascript:void(0)" onclick="navmenueditSort(1)"><span class="icon-angle-circled-right rotate-90"></span></a>
                </div>
                <div>
                    <label>Parent/Child:</label>
                    <a href="javascript:void(0)" onclick="navmenueditIndent(-1)"><span class="icon-angle-circled-left"></span></a>
                    <a href="javascript:void(0)" onclick="navmenueditIndent(1)"><span class="icon-angle-circled-right"></span></a>
                </div>
            </div>
            <label for="navmenu-edit-title">Title:</label>
            <input id="navmenu-edit-title" type="text" onchange="navmenueditSaveJson()" onkeydown="navmenueditKeyDefer()">
            <label for="navmenu-edit-destination">Destination (string or json array):</label>
            <input id="navmenu-edit-destination" type="text" onchange="navmenueditSaveJson()" onkeydown="navmenueditKeyDefer()">
            <label for="navmenu-edit-htmlid">Html ID (id attribute for analytics; optional):</label>
            <input id="navmenu-edit-htmlid" type="text" onchange="navmenueditSaveJson()" onkeydown="navmenueditKeyDefer()">
            <label for="navmenu-edit-">Permission (enter the permission ID; optional):</label>
            <input id="navmenu-edit-permission" type="text" onchange="navmenueditSaveJson()" onkeydown="navmenueditKeyDefer()">
            <label for="navmenu-edit-file">File (Icon; enter the file ID; optional):</label>
            <input id="navmenu-edit-file" type="text" onchange="navmenueditSaveJson()" onkeydown="navmenueditKeyDefer()">
            <div><a href="javascript:void(0)" class="button" onclick="navmenueditRemove()"><span class="icon-trash-empty"></span> Remove Menu Item</a></div>
        </div>
    </div>
</div>