<?php
declare(strict_types=1);

namespace Apps\Controller;

/**
 * LocationTimeZones Controller
 *
 * @property \Apps\Model\Table\LocationTimeZonesTable $LocationTimeZones
 *
 * @method \Apps\Model\Entity\LocationTimeZone[]
 */
class LocationTimeZonesController extends AppController
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
            'contain' => ['TimeZones'],
        ];
        $locationTimeZones = $this->paginate($this->LocationTimeZones);

        $this->set(compact('locationTimeZones'));
    }

    /**
     * View method
     *
     * @param string|null $id Location Time Zone id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $query = $this->LocationTimeZones->find('all', [
            'contain' => ['TimeZones'],
            'conditions' => ['LocationTimeZones.id' => $id],
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
        $locationTimeZone = $this->LocationTimeZones->newEntity();
        if ($this->getRequest()->is('post')) {
            $locationTimeZone = $this->LocationTimeZones->patchEntity($locationTimeZone, $this->getRequest()->getData());
            if ($this->LocationTimeZones->save($locationTimeZone)) {
                $this->Flash->success(__('The location time zone has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location time zone could not be saved. Please, try again.'));
        }
        $timeZones = $this->LocationTimeZones->TimeZones->find('list', ['limit' => 200]);
        $this->set(compact('locationTimeZone', 'timeZones'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Location Time Zone id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $locationTimeZone = $this->LocationTimeZones->get($id, [
            'contain' => [],
        ]);
        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            $locationTimeZone = $this->LocationTimeZones->patchEntity($locationTimeZone, $this->getRequest()->getData());
            if ($this->LocationTimeZones->save($locationTimeZone)) {
                $this->Flash->success(__('The location time zone has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location time zone could not be saved. Please, try again.'));
        }
        $timeZones = $this->LocationTimeZones->TimeZones->find('list', ['limit' => 200]);
        $this->set(compact('locationTimeZone', 'timeZones'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Location Time Zone id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->getRequest()->allowMethod(['post', 'delete']);
        $locationTimeZone = $this->LocationTimeZones->get($id);
        if ($this->LocationTimeZones->delete($locationTimeZone)) {
            $this->Flash->success(__('The location time zone has been deleted.'));
        } else {
            $this->Flash->error(__('The location time zone could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
