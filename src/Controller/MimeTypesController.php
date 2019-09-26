<?php

namespace Apps\Controller;

/**
 * MimeTypes Controller
 *
 * @property \Apps\Model\Table\MimeTypesTable $MimeTypes
 *
 * @method \Apps\Model\Entity\MimeType[]
 */
class MimeTypesController extends AppController
{
    public $crud = [
        'fallbackTemplatePath' => 'Admin'
    ];

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Thumbnail'],
            'order' => ['MimeTypes.name' => 'ASC']
        ];
        $mimeTypes = $this->paginate($this->MimeTypes);

        $this->set(compact('mimeTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Mime Type id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $query = $this->MimeTypes->find('all', [
            'contain' => ['Thumbnail', 'Files'],
            'conditions' => ['MimeTypes.id' => $id]
        ]);

        $results = $this->Crud->paginateAssociations($query);
        $this->set($results);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $mimeType = $this->MimeTypes->newEntity();
        if ($this->request->is('post')) {
            $mimeType = $this->MimeTypes->patchEntity($mimeType, $this->request->getData());
            if ($this->MimeTypes->save($mimeType)) {
                $this->Flash->success(__('The mime type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The mime type could not be saved. Please, try again.'));
        }
        $thumbnail = $this->MimeTypes->Thumbnail->find('list', ['limit' => 200]);
        $imageOptions = $this->MimeTypes->getEnumOptions('image');
        $resizeOptions = $this->MimeTypes->getEnumOptions('resize');
        $handlerOptions = $this->MimeTypes->getEnumOptions('handler');
        $this->set(compact('mimeType', 'thumbnail', 'imageOptions', 'resizeOptions', 'handlerOptions'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Mime Type id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $mimeType = $this->MimeTypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $mimeType = $this->MimeTypes->patchEntity($mimeType, $this->request->getData());
            if ($this->MimeTypes->save($mimeType)) {
                $this->Flash->success(__('The mime type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The mime type could not be saved. Please, try again.'));
        }
        $thumbnail = $this->MimeTypes->Thumbnail->find('list', ['limit' => 200]);
        $imageOptions = $this->MimeTypes->getEnumOptions('image');
        $resizeOptions = $this->MimeTypes->getEnumOptions('resize');
        $handlerOptions = $this->MimeTypes->getEnumOptions('handler');
        $this->set(compact('mimeType', 'thumbnail', 'imageOptions', 'resizeOptions', 'handlerOptions'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Mime Type id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $mimeType = $this->MimeTypes->get($id);
        if ($this->MimeTypes->delete($mimeType)) {
            $this->Flash->success(__('The mime type has been deleted.'));
        } else {
            $this->Flash->error(__('The mime type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
