<?php
declare(strict_types=1);

namespace Apps\Controller;

/**
 * TimeZones Controller
 *
 * @property \Apps\Model\Table\TimeZonesTable $TimeZones
 *
 * @method \Apps\Model\Entity\TimeZone[]
 */
class TimeZonesController extends AppController
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
        $timeZones = $this->paginate($this->TimeZones);

        $this->set(compact('timeZones'));
    }

    /**
     * View method
     *
     * @param string|null $id Time Zone id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $query = $this->TimeZones->find('all', [
            'contain' => ['LocationTimeZones', 'Users'],
            'conditions' => ['TimeZones.id' => $id]
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
        $timeZone = $this->TimeZones->newEntity();
        if ($this->getRequest()->is('post')) {
            $timeZone = $this->TimeZones->patchEntity($timeZone, $this->getRequest()->getData());
            if ($this->TimeZones->save($timeZone)) {
                $this->Flash->success(__('The time zone has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The time zone could not be saved. Please, try again.'));
        }
        $this->set(compact('timeZone'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Time Zone id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $timeZone = $this->TimeZones->get($id, [
            'contain' => []
        ]);
        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            $timeZone = $this->TimeZones->patchEntity($timeZone, $this->getRequest()->getData());
            if ($this->TimeZones->save($timeZone)) {
                $this->Flash->success(__('The time zone has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The time zone could not be saved. Please, try again.'));
        }
        $this->set(compact('timeZone'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Time Zone id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->getRequest()->allowMethod(['post', 'delete']);
        $timeZone = $this->TimeZones->get($id);
        if ($this->TimeZones->delete($timeZone)) {
            $this->Flash->success(__('The time zone has been deleted.'));
        } else {
            $this->Flash->error(__('The time zone could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
