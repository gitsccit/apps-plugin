<?php

namespace Apps\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;

/**
 * Files Controller
 *
 * @property \Apps\Model\Table\FilesTable $Files
 *
 * @method \Apps\Model\Entity\File[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FilesController extends AppController
{

    // TODO is is an ugly solution; we should find the key for "image/png" in the database
    private $imagepng = 13;

    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(["open", "download", "resize", "css"]);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['MimeType', 'Users'],
            'order' => ['Files.date_created' => 'DESC'],
        ];
        $files = $this->paginate($this->Files);

        $this->set(compact('files'));
    }

    // browse available files through a lightbox
    public function browse()
    {
        $this->viewBuilder()->setLayout('ajax');

        $this->paginate = [
            'contain' => ['MimeType', 'Users'],
            'order' => ['Files.date_created' => 'DESC'],
            'limit' => 5
        ];
        $files = $this->paginate($this->Files);
        $this->set(compact('files'));
    }

    /**
     * View method
     *
     * @param string|null $id File id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $file = $this->Files->get($id, [
            'contain' => ['Users', 'MimeType', 'MimeTypes', 'AppLinks']
        ]);

        $this->set('file', $file);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $file = $this->Files->newEntity();
        if ($this->request->is('post')) {
            $file = $this->Files->patchEntity($file, $this->request->getData());
            if ($this->Files->save($file)) {
                $this->Flash->success(__('The file has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The file could not be saved. Please, try again.'));
        }
        $users = $this->Files->Users->find('list', ['limit' => 200]);
        $this->set(compact('file', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id File id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*
    public function edit($id = null)
    {
        $file = $this->Files->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $file = $this->Files->patchEntity($file, $this->request->getData());
            if ($this->Files->save($file)) {
                $this->Flash->success(__('The file has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The file could not be saved. Please, try again.'));
        }
        $users = $this->Files->Users->find('list', ['limit' => 200]);
        $this->set(compact('file', 'users'));
    }
    */

    /**
     * Delete method
     *
     * @param string|null $id File id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $file = $this->Files->get($id);

        // TODO ideally we should verify that the file is not in use anywhere

        if ($this->MSGraph->deleteFile($file->path)) {
            if ($this->Files->delete($file)) {
                $this->Flash->success(__('The file has been deleted.'));
            } else {
                $this->Flash->error(__('The file could not be deleted. Please, try again.'));
            }
        } else {
            $this->Flash->error(__('The file could not be deleted from OneDrive. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function open($id = null)
    {
        return $this->fetch($id, false);
    }

    private function fetch($id = null, $download = true, $width = false, $height = false)
    {
        $response = $this->response;
        $files = TableRegistry::getTableLocator()->get('Apps.Files');
        $file = $files->get($id, ['contain' => ['MimeType']]);

        // update the date_accessed
        $file->date_accessed = Time::now();
        $files->save($file);

        // set etag and lastmodified headers
        $response = $response->withCache('-1 minute', '+5 days');
        $response = $response->withEtag($file->generateHash());
        $response = $response->withModified($file->date_created);
        if ($response->checkNotModified($this->request)) {
            return $response;
        }

        // if we have a width & height (resize) and this is not an image; load the default file type icon (if exists)
        // this functions as a thumbnailer
        if ($file->mime_type->image == "no" && ($width || $height)) {

            if ($file->mime_type->file_id) {
                $thumbnail = $file->mime_type->file_id;
            } else {
                $this->ConfigureFromDatabase->loadVars('files.thumbnail');
                $thumbnail = Configure::readOrFail('files.thumbnail.default');
            }

            // swap the file pointer to the thumbnail
            if (!empty($thumbnail)) {
                $file = $files->get($thumbnail, ['contain' => ['MimeType']]);
            }

        }

        // fetch the file content
        $drivecomponent = false;
        if ($file->src == "onedrive") {
            $drivecomponent = $this->MSGraph;
        }
        $content = $file->content($drivecomponent, $width, $height);

        // respond with the file
        $response = $response->withStringBody($content);
        $response = $response->withType($file->mime_type->name);
        if ($download) {
            $response = $response->withDownload($file->name);
        }

        return $response;
    }

    public function download($id = null)
    {
        return $this->fetch($id, true);
    }

    public function resize($id = null, $width = null, $height = null)
    {
        // verify that the width and height are valid options
        $sizes = $this->ConfigureFromDatabase->loadVar('files.resize');
        $sizes = explode(",", $sizes);
        foreach ($sizes as $k => $v) {
            if ($width && $width <= $v) {
                $width = (int)$v;
                break;
            }
        }
        foreach ($sizes as $k => $v) {
            if ($height && $height <= $v) {
                $height = (int)$v;
                break;
            }
        }

        // load the default file icon if the ID is empty
        if (empty($id)) {
            $id = $this->ConfigureFromDatabase->loadVar('files.thumbnail.default');
        }

        return $this->fetch($id, false, $width, $height);
    }

    public function css(...$sheets)
    {
        $response = $this->response;
        $content = [];
        $size = 0;
        $modified = [];

        // load css custom properties
        if ($this->ConfigureFromDatabase) {
            $modified[] = $this->ConfigureFromDatabase->getCssLastModified();
        }

        // qualify each filename
        $files = [];
        foreach ($sheets as $sheet) {
            if (strtolower(substr($sheet, -4)) != ".css") {
                $sheet .= ".css";
            }
            $sheet = "css/" . $sheet;
            if (file_exists($sheet) && is_readable($sheet)) {
                $files[] = $sheet;
            }
        }

        // load last modified time and size from each file
        foreach ($files as $file) {
            $modified[] = (int)filemtime($file);
            $size += filesize($file);
        }

        rsort($modified); // largest modified at the start

        // browser caching; set etag and lastmodified headers
        if (sizeof($modified)) {
            $response = $response->withCache('-1 minute', '+5 days');
            $response = $response->withEtag(md5($size . implode($sheets)));
            $response = $response->withModified($modified[0]);
            if ($response->checkNotModified($this->request)) {
                return $response;
            }
        }

        // load css custom properties
        if ($this->ConfigureFromDatabase) {
            $content[] = $this->ConfigureFromDatabase->getCss();
        }

        // load css files
        foreach ($files as $file) {
            $content[] = file_get_contents($file);
        }

        $response = $response->withStringBody(implode("\n", $content));
        $response = $response->withType("css");

        return $response;
    }

    function upload()
    {
        $filename = rawurldecode($this->request->getHeaderLine('X-File-Name'));
        $content = file_get_contents("php://input");

        if (empty($filename)) {
            die("File name was missing.");
            // throw new ForbiddenException("File name was missing.");
        }
        if (empty($content)) {
            die("File content was blank.");
            // throw new ForbiddenException("File content was blank.");
        }

        // remove the upload mime type and size wrapping from the content body
        $header = "";
        $mime = false;
        $pos = strpos($content, "\r\n\r\n");
        if ($pos) {
            $header = substr($content, 0, $pos + 4);
            $content = substr($content, strlen($header));

            $first = strpos($header, "\r\n");
            if ($first) {
                $firstline = substr($header, 0, $first);
                $lastline = strrpos($content, "\r\n" . $firstline);
                if ($lastline) {
                    $content = substr($content, 0, $lastline);
                }
            }

            // use the header Content-Type
            $headers = explode("\r\n", $header);
            foreach ($headers as $line) {
                if (strtolower(substr($line, 0, 14)) == "content-type: ") {
                    $uploadmime = strtolower(substr($line, 14));
                    $pos = strpos($uploadmime, ";");
                    if ($pos) {
                        $uploadmime = substr($uploadmime, 0, $pos);
                    }
                }
            }
        }

        // read the mime type and remove the temp file
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_buffer($finfo, $content);

        // manually deal with some text/plain mime types
        if ($mime == "text/plain") {
            switch ($uploadmime) {
                case "text/csv":
                    $mime = "text/csv";
                    break;
                case "application/vnd.ms-excel":
                    $mime = "text/csv";
                    break;
            }
        }

        $this->MimeTypes = TableRegistry::getTableLocator()->get('Apps.MimeTypes');
        $mime_type = $this->MimeTypes->find('all', ['conditions' => ['MimeTypes.name LIKE' => $mime]])->first();
        if (!$mime_type) {
            die("File type " . $mime . " is not whitelisted for upload.");
            // throw new ForbiddenException("File type ".$mime." is not whitelisted for upload.");
        }

        // save the file!
        $file = $this->Files->newEntity();
        $file->mime_type_id = $mime_type->id;
        $file->name = $filename;
        $file->size = strlen($content);
        $file->user_id = $this->Auth->User('id');

        // special file handlers; the mime type might require a related function
        if (!empty($mime_type->handler) && method_exists($this, $mime_type->handler)) {
            $handler = $mime_type->handler;
            $this->{$handler}($content, $file); // does not work with call_user_func as we want pass-by-reference
        }

        // have we previously uploaded this file? if so return the ID
        $conditions = [
            'Files.name LIKE' => $file->name,
            'Files.mime_type_id LIKE' => $file->mime_type_id,
            'Files.size =' => $file->size,
            'Files.width IS' => $file->width,
            'Files.height IS' => $file->height,
        ];
        $files = $this->Files->find('all', ['conditions' => $conditions])->first();

        // if we have a result this file was previously uploaded; just return the ID of the matching record
        if (!empty($files->id)) {
            echo $files->id;
            exit; // this is a successful result
        }

        // set and save the file to onedrive
        $file->src = "onedrive";
        $folder = date('Y/m');
        $pos = strrpos($file->name, ".");
        if ($pos) {
            $folder .= "/" . strtolower(substr($file->name, $pos + 1));
        }
        $file->path = $this->MSGraph->addFile($folder, $file->name, $content);

        if ($this->Files->save($file)) {
            echo $file->id;
            exit; // this is a successful result
        }

        die("Failed to save file");
    }

    public function trackHistory()
    {
        $action = $this->request->getParam('action');
        if (array_search($action, ['index', 'view', 'add', 'edit']) !== false) {
            return true;
        }

        return false;
    }

    /**
     * Compliance requirement; strip any metadata from images
     * also use this opportunity to convert to png and set width and height
     */
    private function imagepng(&$content, &$file)
    {
        if (($source_image = imagecreatefromstring($content)) === false) {
            die("Unable to load as an image");
            // throw new ForbiddenException("Unable to load as an image");
        }

        $file->width = imagesx($source_image);
        $file->height = imagesy($source_image);

        // create new image
        $new_image = imagecreatetruecolor($file->width, $file->height);
        imagealphablending($new_image, false);
        imagesavealpha($new_image, true);

        $white_transparent = imagecolorallocatealpha($new_image, 255, 255, 255, 127);
        imagefill($new_image, 0, 0, $white_transparent);
        imagecopyresampled($new_image, $source_image, 0, 0, 0, 0, $file->width, $file->height, $file->width,
            $file->height);

        ob_start();
        imagepng($new_image, null, 9);
        $content = ob_get_clean();
        imagedestroy($source_image);
        imagedestroy($new_image);

        // update the mime type to png and the filename to end in .png
        $file->mime_type_id = $this->imagepng;
        $pos = strrpos($file->name, ".");
        if ($pos !== false) {
            $file->name = substr($file->name, 0, $pos) . ".png";
        }
    }

    /**
     * Compliance requirement; inspect PDF files for javascript. Strip any javascript from the content.
     */
    private function pdfscript(&$content, &$file)
    {
        // strips the contents of any pdf obj of type /JavaScript or /JS
        while ($this->stringRemoveBetween($content, "/JavaScript", "<<", ">>")) {
            ;
        }
        while ($this->stringRemoveBetween($content, "/JS", "<<", ">>")) {
            ;
        }
    }

    private function stringRemoveBetween(&$content, $find, $left, $right)
    {
        $pos = stripos($content, $find);
        if ($pos === false) {
            return false;
        }

        $posLeft = strrpos(substr($content, 0, $pos), $left);
        if ($posLeft === false) {
            return false;
        }

        $posRight = strpos($content, $right, $pos);
        if ($posRight === false) {
            return false;
        }

        $content = substr($content, 0, $posLeft + strlen($left)) . substr($content, $posRight);
    }
}
