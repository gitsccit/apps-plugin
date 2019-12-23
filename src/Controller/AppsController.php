<?php
declare(strict_types=1);

namespace Apps\Controller;

use Cake\ORM\TableRegistry;

/**
 * Apps Controller
 *
 * @property \Apps\Model\Table\AppsTable $Apps
 *
 * @method \Apps\Model\Entity\App[]
 */
class AppsController extends AppController
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
            'order' => ['Apps.name' => 'ASC'],
        ];
        $apps = $this->paginate($this->Apps);

        $this->set(compact('apps'));
    }

    /**
     * View method
     *
     * @param string|null $id App id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $app = $this->Apps->get($id, ['contain' => ['AppLinks' => ['ChildLinks', 'Permissions', 'Files']]]);

        $app->app_links = $this->Apps->flatNavLinks($app->app_links);

        $this->set('app', $app);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $app = $this->Apps->newEmptyEntity();
        if ($this->getRequest()->is('post')) {
            $app = $this->Apps->patchEntity($app, $this->getRequest()->getData());
            if ($this->Apps->save($app)) {
                $this->Flash->success(__('The app has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The app could not be saved. Please, try again.'));
        }
        $this->set(compact('app'));
    }

    /**
     * Edit method
     *
     * @param string|null $id App id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $app = $this->Apps->get($id, ['contain' => ['AppLinks' => ['ChildLinks']]]);

        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            $data = $this->getRequest()->getData();
            $app = $this->Apps->patchEntity($app, $data);

            $this->AppLinks = TableRegistry::getTableLocator()->get('Apps.AppLinks');

            if ($this->Apps->save($app)) {
                $this->Flash->success(__('The app has been saved.'));

                // update app_links
                $indents = [0 => [null, 0]];

                foreach ($data as $key => $value) {
                    // deletions
                    if ($key == "applinkdelete" && is_array($value) && sizeof($value)) {
                        foreach ($value as $deleteId) {
                            $applink = $this->AppLinks->get($deleteId);
                            $this->AppLinks->delete($applink);
                        }
                        continue;
                    }

                    // insert or update existing
                    if (substr($key, 0, 7) == "applink") {
                        if (!is_array($value)) {
                            $value = [$value];
                        }

                        foreach ($value as $v) {
                            $val = json_decode($v, true);
                            $val['app_id'] = $app['id'];

                            $temp = (int)substr($key, 7);
                            if ($temp) {
                                $applink = $this->AppLinks->get($temp);
                            } else {
                                $applink = $this->AppLinks->newEmptyEntity();
                                unset($val['id']);
                            }

                            if (!isset($indents[$val['indent']])) {
                                $indents[$val['indent']] = [null, 0];
                            }
                            $indents[$val['indent']][0] = $applink->id;

                            $i = $val['indent'] + 1;
                            while (isset($indents[$i][1])) {
                                $indents[$i++][1] = 0;
                            }

                            $parentPos = (int)$val['indent'] - 1;
                            if ($parentPos >= 0 && isset($indents[$parentPos])) {
                                $val['app_link_id'] = $indents[$parentPos][0];
                                $val['sort'] = $indents[(int)$val['indent']][1]++;
                            } else {
                                $val['app_link_id'] = null;
                                $val['sort'] = $indents[0][1]++;
                            }

                            $this->AppLinks->patchEntity($applink, $val);
                            $this->AppLinks->save($applink);
                        }
                    }
                }

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The app could not be saved. Please, try again.'));
        }
        $this->set(compact('app'));
    }

    /**
     * Delete method
     *
     * @param string|null $id App id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*  public function delete($id = null)
      {
          $this->getRequest()->allowMethod(['post', 'delete']);
          $app = $this->Apps->get($id);
          if ($this->Apps->delete($app)) {
              $this->Flash->success(__('The app has been deleted.'));
          } else {
              $this->Flash->error(__('The app could not be deleted. Please, try again.'));
          }

          return $this->redirect(['action' => 'index']);
      }*/
}
