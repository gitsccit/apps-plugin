<?php
/**
 * Provides a universal file upload or selection interface
 * @var target is the name of the form input element that should receive the ID of any file(s) uploaded with this tool
 * @var multi is a boolean; setting true enables multi-file upload support. note that the target input element MUST be an array type for this to work (input name ending in [])
 * @var clear is a boolean; setting true lets the user blank the related target
 */

$this->Html->script('fileupload', ['block' => true, 'once' => true]);
?>
<div class="file-upload"
     data-readonly="<?= (!isset($readonly) || $readonly === true ? "true" : "false") ?>"
     data-target="<?= $target ?>"
     data-upload-url="<?= $this->Url->build(['controller' => 'files', 'action' => 'upload', 'plugin' => 'Apps']) ?>"
     data-csrf="<?= $this->request->getParam('_csrfToken') ?>"
     ondrop="fileUploadDragDrop(event,this)">
    <div ondragover="this.classList.add('active')" ondragexit="this.classList.remove('active')">
        <label>Drag &amp; drop to upload a file or:</label>
        <a class="button" onclick="this.nextSibling.click()"><span class="icon-upload"></span>Upload new file</a><input
            type="file" onchange="fileUploadBrowse(this)" style="display:none"<?= (empty($multi) ? "" : " multiple") ?>>
        <?php if (!isset($browse) || $browse !== false): ?>
            <a class="button" onclick="fileUploadLightbox(this,'<?= $this->Url->build([
                'controller' => 'files',
                'action' => 'browse',
                'plugin' => 'Apps'
            ]) ?>')"><span class="icon-cloud"></span>Browse uploaded files</a>
        <?php endif; ?>
        <?php if (!empty($clear)): ?>
            <a class="button black" onclick="fileUploadClear(this)"><span class="icon-cancel"></span>Clear</a>
        <?php endif; ?>
        <div class="file-progress"></div>
    </div>
</div>
