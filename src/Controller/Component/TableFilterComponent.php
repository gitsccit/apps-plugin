<?php

namespace Apps\Controller\Component;

use Cake\Controller\Component;

/**
 * TableFilterComponent component
 */
class TableFilterComponent extends Component
{

    public function query(object $source, $config = false)
    {

        $controller = $this->_registry->getController();

        // build the ORM config using the cake controller $paginate, or passed $config array
        $paginate_config = [];
        if (property_exists($controller, 'paginate')) {
            $paginate_config = array_merge($paginate_config, $controller->paginate);
        }
        if (is_array($config) && sizeof($config)) {
            $paginate_config = array_merge($paginate_config, $config);
        }

        // look for a field & term to filter by
        $data = $controller->getRequest()->getData();
        $field = (empty($data['field']) ? false : $data['field']);
        $term = (empty($data['term']) ? false : $data['term']);

        // if found, fill the conditions
        if ($field && $term) {
            if (array_key_exists('conditions', $paginate_config) === false) {
                $paginate_config['conditions'] = [];
            }
            $paginate_config['conditions'][] = [$field . ' LIKE' => '%' . $term . '%'];
        }

        // remove the order config if the request includes sort
        $sort = $controller->getRequest()->getQuery('sort');
        if (!empty($sort)) {
            unset($paginate_config['order']);
        }

        // create and return the query
        $query = $source->find('all', $paginate_config);
        return $query;

    }

}
