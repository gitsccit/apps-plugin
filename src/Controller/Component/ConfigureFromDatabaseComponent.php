<?php
declare(strict_types=1);

/*
 * Authenticates a user using microsoft's graph API.
 * Uses the azure app "SCC Intranet Login"
 * https://portal.azure.com/#blade/Microsoft_AAD_RegisteredApps/ApplicationMenuBlade/Overview/appId/84509336-1dc6-4943-919c-4996efbcd1bf/objectId/5c8918ae-5003-4cae-b98d-defcddc70114/isMSAApp/
 *
 * function getMe() will grab the currently logged in user's active directory data. this wouldn't normally be needed as this data is duplicated in the users table and included in the session
 */

namespace Apps\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Http\Exception\ServiceUnavailableException;
use Cake\Routing\Router;

class ConfigureFromDatabaseComponent extends Component
{
    public $paginate = false;
    private $storeid = false;
    private $db = false;

    public function initialize(array $config): void
    {

        $controller = $this->_registry->getController();
        $ip = $controller->getRequest()->getEnv('SERVER_ADDR');
        $port = $controller->getRequest()->getEnv('SERVER_PORT');

        // if running from the command line set the app server's ip and port
        // bake won't work without this
        if (PHP_SAPI === 'cli' && empty($ip) && empty($port)) {
            $ip = "10.100.1.6";
            $port = "443";
        }

        $this->db = ConnectionManager::get('apps_replica');
        $result = $this->db->execute("SELECT s.id,s.name,s.active,i.environment_id,e.name AS environment,e.path
FROM store_ip_maps i
INNER JOIN stores s ON s.id = i.store_id
INNER JOIN environments e ON e.id = i.environment_id
WHERE i.ip_address = ? 
AND i.port = ?
AND s.active = 'yes'", [$ip, $port])->fetch('assoc');
        if (!empty($result['id'])) {
            $this->storeid = $result['id'];
            $this->environmentid = $result['environment_id'];
            $this->environment = $result['environment'];
            $this->path = $result['path'];
            Configure::write("store.name", $result['name']);
        } else {
            throw new ServiceUnavailableException("This store is not active." . (Configure::read('debug') ? " " . $ip . ":" . $port : ""));
        }

        Configure::write("store.id", $this->storeid);
        Configure::write("store.environment.id", $this->environmentidstoreid);
        Configure::write("store.environment.name", $this->environment);
        Configure::write("store.environment.path", $this->path);

        $this->loadVars("store");
        $this->setLayout();
    }

    public function loadVars($prefix = "")
    {

        if (empty($this->storeid) || empty($this->environmentid) || empty($this->db)) {
            return false;
        }

        $results = $this->db->execute(
            "SELECT o.name,o.type,IFNULL(os.value,o.value) AS value
FROM `options` o
LEFT JOIN `option_stores` os ON o.id = os.option_id AND os.store_id = ? AND os.environment_id = ?
WHERE o.name LIKE ?",
            [$this->storeid, $this->environmentid, $prefix . (empty($prefix) ? "" : ".") . "%"]
        )->fetchAll('assoc');
        foreach ($results as $result) {
            if ($result['type'] == "hexcolor" && substr($result['value'], 0, 1) !== "#") {
                $result['value'] = "#" . $result['value'];
            }
            Configure::write($result['name'], $result['value']);
        }
    }

    public function setLayout()
    {

        $layout = Configure::read("store.layout");
        $this->_registry->getController()->viewBuilder()->setLayout($layout);
        $this->loadVars($layout);
        $this->paginate = Configure::read($layout . ".paginate");

        return Configure::read($layout);
    }

    public function loadVar($name)
    {

        if (empty($this->storeid) || empty($this->environmentid) || empty($this->db)) {
            return false;
        }

        $result = $this->db->execute("SELECT o.name,o.type,IFNULL(os.value,o.value) AS value
FROM `options` o
LEFT JOIN `option_stores` os ON o.id = os.option_id AND os.store_id = ? AND os.environment_id = ?
WHERE o.name LIKE ?", [$this->storeid, $this->environmentid, $name])->fetch('assoc');
        if ($result) {
            if ($result['type'] == "hexcolor" && substr($result['value'], 0, 1) !== "#") {
                $result['value'] = "#" . $result['value'];
            }
            Configure::write($result['name'], $result['value']);

            return $result['value'];
        }

        return false;
    }

    public function testVar($name, $value)
    {

        $results = $this->db->execute("SELECT COUNT(*) 
FROM `options` o
LEFT JOIN `option_stores` os ON o.id = os.option_id AND os.store_id = ? AND os.environment_id = ?
WHERE o.name LIKE ?
AND IFNULL(os.value,o.value) LIKE ?", [$this->storeid, $this->environmentid, $name, $value])->fetchAll('assoc');

        return $results[0]['COUNT(*)'] > 0;
    }

    public function getCss()
    {

        $layout = Configure::read("store.layout");

        if (empty($layout)) {
            return false;
        }

        [, $layout] = pluginSplit($layout);

        $results = $this->db->execute("SELECT o.name,o.type,IFNULL(os.value,o.value) AS value
FROM options o 
LEFT JOIN option_stores os ON os.option_id = o.id AND os.store_id = ? AND os.environment_id = ?
WHERE o.name LIKE ?", [$this->storeid, $this->environmentid, "$layout.%"])->fetchAll('assoc');

        $length = strlen($layout) + 1;

        $content = [];
        foreach ($results as $line) {
            if (!empty($line['value'])) {
                if ($line['type'] == "file") {
                    $line['value'] = "background-image:url(" . Router::url([
                            'controller' => 'files',
                            'action' => 'open',
                            $line['value'],
                        ]) . ")";
                }
                $content[] = "--" . substr($line['name'], $length) . ": " . $line['value'] . ";";
            }
        }

        return ":root{\n" . implode("\n", $content) . "\n}";
    }

    public function getCssLastModified()
    {

        $layout = Configure::read("store.layout");
        if (empty($layout)) {
            return false;
        }

        $modified = false;

        $result = $this->db->execute(
            "SELECT MAX(timestamp) FROM options WHERE name LIKE ?",
            [$layout . "%"]
        )->fetch('num');
        if (!empty($result[0])) {
            $modified = $result[0];
        }

        $result = $this->db->execute("SELECT MAX(os.timestamp)
FROM options o 
INNER JOIN option_stores os ON os.option_id = o.id AND os.store_id = ? AND os.environment_id = ?
WHERE o.name LIKE ?", [$this->storeid, $this->environmentid, $layout . "%"])->fetch('num');
        if (!empty($result[0]) && $result[0] > $modified) {
            $modified = $result[0];
        }

        return $modified;
    }
}
