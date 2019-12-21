<?php
/**
 * @var \Apps\View\AppView $this
 * @var \Apps\Model\Entity\File $file
 */
$timezone = $this->request->getSession()->read('Auth.User.time_zone.name');

echo "<div class=\"links-top-right\">";
echo $this->Form->postLink(
    __('Delete'),
    ['action' => 'delete', $file->id],
    ['class' => 'button black', 'confirm' => __('Are you sure you want to delete # {0}?', $file->id)]
);
echo "</div>";

echo "<h1>Uploaded File #" . $file->id . "</h1>\n";

$image = $this->Url->build(['action' => 'resize', $file->id, 500, 500]);
$title = $file->name;

$data = [
    [
        ['Mime Type', $file->mime_type->name],
        ['File Size', $this->Number->toReadableSize($file->size)],
        ['Width', $file->width],
        ['Height', $file->height],
    ],
    [
        [
            'Uploaded By',
            (empty($file->user->display_name) ? "" : $this->Html->link($file->user->display_name,
                ['controller' => 'users', 'action' => 'view', $file->user->id]))
        ],
        ['Uploaded At', $file->created_at->setTimezone($timezone)],
        ['Accessed At', $file->accessed_at->setTimezone($timezone)],
    ],
];
foreach ($data as $key => $value) {
    foreach ($value as $k => $v) {
        $data[$key][$k][0] = "<label>" . $data[$key][$k][0] . ":</label>";
    }
}

echo $this->element('Apps.profile', ['image' => $image, 'title' => $title, 'data' => $data]);
