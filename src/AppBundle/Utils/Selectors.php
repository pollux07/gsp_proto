<?php
/**
 * Created by PhpStorm.
 * User: pollux
 * Date: 23/10/17
 * Time: 13:34
 */

namespace AppBundle\Utils;

/**
 * Class Selectors
 * Utilerías acceso a base de datos vía PDO
 * @package AppBundle\Util
 */
class Selectors {
    /**
     * Ejecuta una sentencia de SQL
     * @param $conn
     * @param $stm
     */
    public static function execute($conn, $stm) {
        $prepare = $conn->prepare($stm);
        $prepare->execute();
    }

    /**
     * Ejecuta la sentencia SQL por medio de un cursor forward-only y regresa el
     * cursor en forma de arreglo.
     * @param $cn
     * @param $stmt
     * @return array Cursor
     */
    public static function selectFromCursor($cn, $stmt)
    {
        $pstmt = $cn->prepare($stmt, array(\PDO::CURSOR_FWDONLY, \PDO::ATTR_CURSOR));
        $pstmt->execute();
        return $pstmt->fetchAll();
    }

    /**
     * Ejecuta la sentencia SQL por medio de un cursor forward-only y regresa el primer
     * elemento del primer renglón del arreglo.
     * @param $cn
     * @param $stmt
     * @return mixed
     */
    public static function selectSingleScalar($cn, $stmt)
    {
        $pstmt = $cn->prepare($stmt, array(\PDO::CURSOR_FWDONLY, \PDO::ATTR_CURSOR));
        $pstmt->execute();
        return $pstmt->fetchColumn();
    }

    /**
     * Ejecuta la sentencia SQL por medio de un cursor forward-only y regresa el primer
     * elemento del primer renglón del arreglo.
     * @param $cn
     * @param $stmt
     * @return mixed
     */
    public static function selectSingleScalarPrepared($cn, $stmt, array $parameters)
    {
        $pstmt = $cn->prepare($stmt);
        $keys = array_keys($parameters);
        foreach ($keys as $key) {
            $pstmt->bindParam(":" . $key, $parameters[$key]);
        }
        $pstmt->execute();
        return $pstmt->fetchColumn();
    }

    /**
     * Verifica que la consulta regrese por lo menos un renglón. Si no es así regresa false.
     * De lo contrario regresa true.
     * @param $cn
     * @param $stmt
     * @return bool
     */
    public static function exists($cn, $stmt)
    {
        $result = static::selectFromCursor($cn, $stmt);
        if (count($result) == 0) {
            return false;
        }
        return true;
    }

    /**
     * Regresa el primer renglón o nulo si no hay primer renglón. Si hay más de un renglón levanta
     * una excepción
     * @param $cn
     * @param $stmt
     * @return mixed|null
     * @throws \Exception
     */
    public static function selectSingleRecordOrNull($cn, $stmt)
    {
        $result = static::selectFromCursor($cn, $stmt);
        if (count($result) == 0) {
            return null;
        } elseif (count($result) > 1) {
            throw new \Exception("Multiple rows when one was expected");
        }
        return $result[0];
    }


    /**
     *
     * @param $cn
     * @param $stmt
     * @param array $parameters
     */
    public static function executePrepared($cn, $stmt, array $parameters)
    {
        $pstmt = $cn->prepare($stmt);
        $keys = array_keys($parameters);
        foreach($keys as $key) {
            $pstmt->bindParam(":".$key, $parameters[$key]);
        }
        $pstmt->execute();
    }

    public static function selectPrepare($cn, $stmt, array $parameters)
    {
        $pstmt = $cn->prepare($stmt);
        $keys = array_keys($parameters);
        foreach ($keys as $key) {
            $pstmt->bindParam(":" . $key, $parameters[$key]);
        }
        $pstmt->execute();

        return $pstmt->fetchAll();
    }



    public static function selectSingleRecordOrNullPrepared($cn, $stmt, array $parameters)
    {
        $pstmt = $cn->prepare($stmt);
        $keys = array_keys($parameters);
        foreach ($keys as $key) {
            $pstmt->bindParam(":" . $key, $parameters[$key]);
        }
        $pstmt->execute();
        $result = $pstmt->fetchAll();
        if (count($result) == 0) {
            return null;
        } elseif (count($result) > 1) {
            throw new \Exception("Multiple rows when one was expected");
        }
        return $result[0];
    }
}