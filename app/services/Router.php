<?php


class Router
{
    private static $list = [];

    /**
     * Добавляет страницу в $list (массив страниц сайта)
     * @param $uri
     * @param $page_name
     * @param string $title
     * @param null $class
     * @param null $method
     * @param array $post
     */
    public static function page($uri, $page_name, $title = 'My site', $class = null, $method = null, $post = [])
    {
        self::$list[] = [
            'uri' => $uri,
            'page' => $page_name,
            'title' => $title,
            'class' => $class,
            'method' => $method,
            'post' => $post,
        ];
    }

    /**
     * Подключает запрашиваемую страницу
     */
    public static function enable()
    {
        $query = $_GET['q'];

        foreach (self::$list as $route) {
            if ($route['uri'] === '/' . $query) {
                $title = $route['title'];

                if (session_status() !== 'PHP_SESSION_ACTIVE') {
                    session_start();
                }

                if ($route['class'] && $route['method']) {
                    $action = new $route['class'];
                    $method = $route['method'];
                    $action->$method($route['post']);
                }

                User::checkAuth();
                require_once 'views/pages/' . $route['page'] . '.php';
                die();
            }
        }
        self::notFoundPage();
    }

    /**
     * Подключает страницу 404
     */
    private static function notFoundPage()
    {
        require_once 'views/pages/404.php';

    }
}