<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="message error alert" onclick="this.classList.add('hidden');"><span class="icon-attention-alt"></span> <?= $message ?></div>
