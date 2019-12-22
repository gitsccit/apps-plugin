<?php
declare(strict_types=1);

namespace Apps\Controller;

use Cake\Http\Client;

/**
 * Search Controller
 */
class SearchController extends AppController
{
    /**
     * Query method
     */
    public function query()
    {
        // TODO dns needs to be added for dev-thinkapi
        // TODO move the URL (dev-thinkapi) to app.php configuration
        // TODO move the token to app.php configuration

        $q = $this->getRequest()->getQuery('q');

        $http = new Client();
        $response = $http->get('https://10.32.2.23/search.json', // dev-thinkapi.sccit.local
            ['q' => $q],
            [
                'headers' => [
                    'scctoken' => '3b98b101effbd2f844b28a5a401566f7933f638eea8f853eba7d595c54d77e061c6466e8bd68df2f50f2a2ac2d13304121896155755233b5b4eec9c712542046a8aa60e01aaea4251b00bfa599940d6d66ac4913d86c344860d978acdb2b08e784eb9fff4285f1f18c487ef3a55a47a39c6e71b264d510200999b9ab1313326a',
                    'CompanyCode' => 'SCC'
                ],
                'ssl_verify_peer' => false
            ]);

        // fake the json response
        $json = $response->getJson();

        // filter results down to the link data
        $results = [];
        if (isset($json['results']) && sizeof($json['results'])) {
            foreach ($json['results'] as $line) {
                $results[] = $line['Link'];
            }
        }

        $this->Crud->serialize(compact('results'));
    }
}
