<?php
/**
 * web - db.php
 * Created by LKHO.
 * Date: 8/4/2015
 */
require_once 'config.php';

class db
{
    /**
     * @var mysqli
     */
    public static $mysqli;

    public static function init() {
        self::$mysqli = new mysqli(config::$db_host, config::$db_user, config::$db_pw, config::$db_schema);
    }

    public static function prepare($query) {
        return self::$mysqli->prepare(self::prefixTables($query));
    }

    public static function prefixTables($query) {
        return preg_replace('/(?<!\\.)\\[(.+?)\\]/', '`' . config::$db_prefix . '$1`', $query);
    }

    public static function query($query, $resultmode = MYSQLI_STORE_RESULT) {
        return self::$mysqli->query(self::prefixTables($query), $resultmode);
    }

    public static function escape($escapestr) {
        return self::$mysqli->real_escape_string($escapestr);
    }

    public static function commit() {
        return self::$mysqli->commit();
    }

    public static function rollback() {
        return self::$mysqli->rollback();
    }

    public static function autocommit($mode) {
        return self::$mysqli->autocommit($mode);
    }
}

db::init();