<?php
namespace Main;

/**
 * Contains the routes to the controllers or wherever you point them to.
 */
class Routes {

    /**
     * @var array $List
     * Contains routes for the app.
     */
    private static array $List;

    public function __construct() {
        self::$List = [

            // URI => [Controller, function, HTTP request type],
            // GET requests can also be processed by adding a route.
            // e.g. 'home/index?*' => ['ViewController', 'home', '']
            // The last part may be ommited if there is no POST or GET request
            //    to be processed by the correspoding controller.

            'error/403'    => ['ViewsController', 'e403'],
            'error/404'    => ['ViewsController', 'e404'],
            'default'      => ['ViewsController', 'home'],
            'home/index'   => ['ViewsController', 'home'],
            'test/fetch'   => ['TestController',  'fetch'],

        ];
    }

    /**
     * @method public getRoute()
     * Returns corresponding route in $List.
     * @param string $URI
     */
    public static function getRoute($URI): array {
        $keys = array_keys(self::$List);
        foreach ($keys as $key) if (fnmatch($key, $URI)) return self::$List[$URI];
        return ['ViewsController', 'e404'];
    }

    /**
     * @method public setRoute()
     * Sets a route in $List.
     * @param string $URI
     * @param string $route
     */
    public static function setRoute($URI, $route): void {
        self::$List[$URI] = $route;
    }

}