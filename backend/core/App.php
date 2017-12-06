<?php

namespace Core;

defined('CORE_PATH') or define('CORE_PATH', __DIR__);

class App
{
    protected $config = [];

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function run()
    {
        spl_autoload_register([$this, 'loadClass']);
        $this->allowedCors();
        $this->setReporting();
        $this->setDbConfig();
//        $this->filterRequest();
        $this->route();
    }

    public function setReporting()
    {
        if (APP_DEBUG === true) {
            error_reporting(E_ALL);
            ini_set('display_errors', 'On');
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors', 'Off');
            ini_set('log_errors', 'On');
        }
    }

    public function setDbConfig()
    {
        if ($this->config['db']) {
            define('DB_HOST', $this->config['db']['host']);
            define('DB_NAME', $this->config['db']['dbname']);
            define('DB_USER', $this->config['db']['username']);
            define('DB_PASS', $this->config['db']['password']);
        }
    }

    public function route()
    {
        $controllerName = $this->config['defaultController'];
        $actionName = $this->config['defaultAction'];
        $param = [];

        $url = $this->getCleanUrl();

        if ($url) {
            $urlArray = explode('/', $url);
            $urlArray = array_filter($urlArray);

            $controllerName = ucfirst($urlArray[0]);
            array_shift($urlArray);

            $actionName = $urlArray ? $urlArray[0] : $actionName;
            array_shift($urlArray);

            $param = $urlArray ? $urlArray : [];
        }

        $controller = 'App\\Controllers\\' . $controllerName . 'Controller';
        if (!class_exists($controller)) {
            exit($controller . ' Controller does not exist');
        }
        if (!method_exists($controller, $actionName)) {
            exit($actionName . ' Method does not exist');
        }

        $dispatch = new $controller($controllerName, $actionName);

        call_user_func_array([$dispatch, $actionName], $param);
    }

    private function getCleanUrl()
    {
        $url = $_SERVER['REQUEST_URI'];
        $position = strpos($url, '?');
        $url = $position === false ? $url : substr($url, 0, $position);
        return trim($url, '/');
    }

    public function allowedCors()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET');
        header("Access-Control-Allow-Headers: X-Requested-With");
    }

    public function loadClass($className)
    {
        $classMap = $this->classMap();

        if (isset($classMap[$className])) {
            $file = $classMap[$className];
        } elseif (strpos($className, '\\') !== false) {
            // Include application file
            $file = APP_PATH . str_replace('\\', '/', $className) . '.php';
            if (!is_file($file)) {
                return;
            }
        } else {
            return;
        }

        include $file;
    }

    protected function classMap()
    {
        return [
            'core\base\Controller' => CORE_PATH . '/base/Controller.php',
            'core\base\Model' => CORE_PATH . '/base/Model.php',
            'core\base\View' => CORE_PATH . '/base/View.php',
            'core\db\Db' => CORE_PATH . '/db/Db.php',
            'core\db\Sql' => CORE_PATH . '/db/Sql.php',
        ];
    }
}