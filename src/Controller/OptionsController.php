<?php

namespace Apps\Controller;

use Apps\Controller\ClassRegistry;
use Cake\ORM\TableRegistry;

/**
 * Options Controller
 *
 * @property \Apps\Model\Table\OptionsTable $Options
 *
 * @method \Apps\Model\Entity\Option[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OptionsController extends AppController
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
            'order' => ['Options.name' => 'ASC']
        ];
        $options = $this->paginate($this->Options);

        $this->set(compact('options'));
    }

    /**
     * View method
     *
     * @param string|null $id Option id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $query = $this->Options->find('all', [
            'contain' => [
                'OptionStores' => [
                    'Stores',
                    'Environments',
                ]
            ],
            'conditions' => ['Options.id' => $id]
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
        $option = $this->Options->newEntity();
        if ($this->getRequest()->is('post')) {
            $data = $this->getRequest()->getData();
            if ($this->validate($data['type'], $data['value'])) {
                $option = $this->Options->patchEntity($option, $data);
                if ($this->Options->save($option)) {
                    $this->Flash->success(__('The option has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The option could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('option'));

        $typeOptions = $this->Options->getEnumOptions('type');
        $this->set(compact('typeOptions'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Option id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $option = $this->Options->get($id, [
            'contain' => [
                'OptionStores' => [
                    'Stores',
                    'Environments',
                ]
            ]
        ]);

        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            $valid = true;
            $this->OptionStores = TableRegistry::getTableLocator()->get('Apps.OptionStores');

            // validate primary data
            $data = $this->getRequest()->getData();
            if ($this->validate($data['type'], $data['value']) === false) {
                $valid = false;
            }

            // validate store-specific data
            foreach ($data as $key => $value) {
                if (substr($key, 0, 2) == "os" && !empty($value)) {
                    if ($this->validate($data['type'], $value) === false) {
                        $valid = false;
                    }
                }
            }

            if ($valid) {
                $option = $this->Options->patchEntity($option, $data);
                if ($this->Options->save($option)) {
                    $this->Flash->success(__('The option has been saved.'));

                    // update store_options
                    foreach ($data as $key => $value) {
                        if (substr($key, 0, 2) == "os") {

                            $optionstore_id = (int)substr($key, 2);
                            if ($optionstore_id == 0 && !empty($value)) { // insert a new store value

                                $key = explode("_", $key);
                                $store_id = (int)substr($key[1], 1);
                                $environment_id = (int)substr($key[2], 1);

                                $optionstore = $this->OptionStores->newEntity();
                                $optionstore->option_id = $id;
                                $optionstore->store_id = $store_id;
                                $optionstore->environment_id = $environment_id;
                                $optionstore->value = trim($value);

                                $this->OptionStores->save($optionstore);

                            } else {
                                if ($optionstore_id > 0) {
                                    $optionstore = $this->OptionStores->get($optionstore_id);
                                    if (empty($value)) { // remove a store value
                                        $this->OptionStores->delete($optionstore);
                                    } else { // patch a store value
                                        $optionstore->value = trim($value);
                                        $this->OptionStores->save($optionstore);
                                    }
                                }
                            }

                        }
                    }

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The option could not be saved. Please, try again.'));
            }
        }

        $stores = TableRegistry::getTableLocator()->get('Apps.Stores')->find('all')
            ->where(['Stores.active =' => 'yes'])->order(['Stores.name' => 'ASC'])->all();
        $environments = TableRegistry::getTableLocator()->get('Apps.Environments')
            ->find('all')->order(['Environments.id' => 'ASC'])->all();
        $typeOptions = $this->Options->getEnumOptions('type');
        $this->set(compact('stores', 'environments', 'option', 'typeOptions'));
    }

    /**
     * Validate method; confirms that type/value pair matches expected inputs
     *
     * @param string type
     * @param string value (pass by reference; may be updated)
     * @return true or false
     */
    private function validate($type, &$value)
    {
        switch ($type) {
            case "email":
                if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
                    $this->Flash->error(__('Value must be an email address.'));
                    return false;
                }
                break;
            case "hexcolor":
                $value = trim($value, "#");

                if (preg_match('/^[A-Fa-f0-6]{6}$/', $value) == false) {
                    $this->Flash->error(__('Value must be a 6 character color hex code.'));
                    return false;
                }
                $value = "#" . $value;
                break;
            case "phone":
                // strip non-numeric characters
                $value = preg_replace('/[\D]/', "", $value);

                // throw away leading 1 (US country code)
                if (substr($value, 0, 1) == "1") {
                    $value = substr($value, 1);
                }

                // must have at least 10 characters (xxx-xxx-xxxx)
                if (strlen($value) < 10) {
                    $this->Flash->error(__('Value must be a telephone number with area code.'));
                    return false;
                }
                break;
            case "file":
                if (!is_numeric($value)) {
                    $this->Flash->error(__('Value must be a file ID.'));
                    return false;
                }
                break;
            default:
                if (empty($value)) {
                    $this->Flash->error(__('Value may not be empty.'));
                    return false;
                }
                break;
        }

        return true;
    }

    /**
     * Delete method
     *
     * @param string|null $id Option id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->getRequest()->allowMethod(['post', 'delete']);

        $option = $this->Options->get($id);
        if ($this->Options->delete($option)) {
            $this->Flash->success(__('The option has been deleted.'));
        } else {
            $this->Flash->error(__('The option could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
