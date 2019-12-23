<?php
declare(strict_types=1);

namespace Apps\Controller;

/**
 * Apis Controller
 *
 * @property \Apps\Model\Table\ApisTable $Apis
 *
 * @method \Apps\Model\Entity\Api[]
 */
class ApisController extends AppController
{
    public $crud = [
        'fallbackTemplatePath' => 'Admin',
    ];

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'order' => ['Apis.name' => 'ASC'],
        ];
        $apis = $this->paginate($this->Apis);

        $this->set(compact('apis'));
    }

    /**
     * View method
     *
     * @param string|null $id Api id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $query = $this->Apis->find('all', [
            'contain' => [],
            'conditions' => ['Apis.id' => $id],
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
        $api = $this->Apis->newEmptyEntity();
        if ($this->getRequest()->is('post')) {
            $api = $this->Apis->patchEntity($api, $this->getRequest()->getData());
            if ($this->Apis->save($api)) {
                $this->Flash->success(__('The api has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The api could not be saved. Please, try again.'));
        }
        $token = generate_token();
        $this->set(compact('token'));
        $this->set(compact('api'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Api id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $api = $this->Apis->get($id, [
            'contain' => [],
        ]);
        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            $api = $this->Apis->patchEntity($api, $this->getRequest()->getData());
            if ($this->Apis->save($api)) {
                $this->Flash->success(__('The api has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The api could not be saved. Please, try again.'));
        }
        $this->set(compact('api'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Api id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->getRequest()->allowMethod(['post', 'delete']);
        $api = $this->Apis->get($id);
        if ($this->Apis->delete($api)) {
            $this->Flash->success(__('The api has been deleted.'));
        } else {
            $this->Flash->error(__('The api could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
