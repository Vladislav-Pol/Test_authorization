<?php


class DbUsers
{
    protected static $dbFilePath = ROOT . '/db/db_Users.xml';

    public static function getUsers()
    {
        $db = simplexml_load_file(self::$dbFilePath);
        return $db;
    }

    public static function updateUsers($users)
    {
        return $users->asXML(self::$dbFilePath);
    }
}