<?php
namespace Main;

use Main\Config;
use Main\Routes;
use Main\Resource;
use Main\Controllers\Controller;

require_once realpath('vendor/autoload.php');

/**
 * Main class containing the system.
 */
class Main {

    /**
     * @var Resource $Resource
     * Currently active resource.
     */
    private static Resource $Resource;

    function __construct() {
        $Config = new Config();
        $Routes = new Routes();
        $Controller = new Controller();
        $Resource = new Resource();

        $URI_OFFSET = $Config->getURIOffset();
        $URI = $_SERVER['REQUEST_URI'];
        $URI_array = explode('/', $URI);
        $route = null;

        for ($i = 0; $i < ['OFFSET-2' => 2, 'OFFSET-1' => 1][strtoupper($URI_OFFSET)]; $i++) array_shift($URI_array);

        $URI = implode("/", $URI_array);
        $route = $Routes->getRoute($URI);

        if (empty($URI_array[0])) $route = $Routes->getRoute('default');
        if (count($URI_array) < 2) header("Location:".$route[1]."/index");

        // This line is used to get POST contents sent from JS HTTP requests.
        !empty($_POST) ?: $_POST = file_get_contents('php://input');

        $resource_holder = $Controller->getResource($route, $_GET, $_POST);
        $resource_holder == null ?
            $Resource = null :
            $Resource->set([
                'type' => $resource_holder['type'],
                'name' => $resource_holder['name'],
                'data' => $resource_holder['data'],
            ]);
        self::$Resource = $Resource;
    }

    /**
     * Fetches resource from cache.
     * @param Resource $Resource
     * 
     * =+= This function may be included in a future update including a template engine. =+=
     */
    // private function fetchFromCache($Resource) : Resource {
    //     // Try to refrain using include_once as much as possible on dynamic or mutable resources.
    //     return include_once("views/cache/".$Resource->getName().".php");
    // }

}

$Main = new Main();