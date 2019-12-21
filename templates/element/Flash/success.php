<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>

<div class="message success info" onclick="this.classList.add('hidden')"><span class="icon-attention-alt"></span><?= $message ?></div>
