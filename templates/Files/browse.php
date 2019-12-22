<?php

use Cake\I18n\Number;

$timezone = $this->request->getSession()->read('Auth.User.time_zone.name');

echo $this->element('Apps.table_filter');

$collection = [];
foreach ($files as $file) {
    $specs = "<ul>";
    $specs .= "<li class=\"overflow-anywhere\"><label>Mime Type:</label>" . (empty($file->mime_type->name) ? "" : h($file->mime_type->name)) . "</li>";
    if (!empty($file->width)) {
        $specs .= "<li><label>Dimensions:</label>" . h($file->width . " x " . $file->height) . "</li>";
    }
    $specs .= "<li><label>Size:</label>" . Number::toReadableSize($file->size) . "</li>";
    $specs .= "<li><label>User:</label>" . h($file->user->display_name) . "</li>";
    $specs .= "<li><label>Added:</label>" . h($file->created_at->setTimezone($timezone)) . "</li>";
    $specs .= "</ul>";
    $collection[] = $this->element('Apps.tile', [
        'link' => "javascript:fileAttachFileId(" . $file->id . ",'" . $file->name . "',false);lightbox(false)",
        'name' => $file->name,
        'image' => $this->Url->build(['controller' => 'files', 'action' => 'resize', $file->id, 400, 400]),
        'specs' => $specs,
    ]);
}

echo $this->element('Apps.tiles', ['collection' => $collection]);
