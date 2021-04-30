<?php


class DbUsers
{
    protected static $dbFilePath = ROOT . '/db/db_Users.xml';

    //возвращает объект класса simplexml с пользователями
    public static function getUsers()
    {
        $db = simplexml_load_file(self::$dbFilePath);
        return $db;
    }

    // записывает объект класса simplexml в файл базы данных
    public static function updateUsers($users)
    {
        return $users->asXML(self::$dbFilePath);
    }
}