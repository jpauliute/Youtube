<?php

class S
{
    public static function fetchColumn($select, $from, $where, $array)
    {
        global $conn;
        $stmt = $conn->prepare("Select $select from $from WHERE $where");
        $stmt->execute($array);
        $stmt = $stmt->fetchColumn();
        return $stmt;
    }

    public static function fetch($select, $from, $where, $array)
    {
        global $conn;
        $stmt = $conn->prepare("Select $select from $from WHERE $where");
        $stmt->execute($array);
        $stmt = $stmt->fetch(PDO::FETCH_ASSOC);
        return $stmt;
    }

    public static function fetchAll($query, $array)
    {
        global $conn;
        $stmt = $conn->prepare($query);
        $stmt->execute($array);
        $stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $stmt;
    }

    public static function countObjects($from, $where, $array)
    {
        global $conn;
        $stmt = $conn->prepare("Select id from $from WHERE $where");
        $stmt->execute($array);
        $stmt = $stmt->rowCount();
        return $stmt;
    }

    public static function query($query, $array)
    {
        global $conn;
        $stmt = $conn->prepare($query);
        $stmt->execute($array);
    }

    public static function update($update, $where, $set, $array, $wh_array)
    {
        global $conn;
        $stmt = $conn->prepare("UPDATE $update SET $set $where");
        $stmt->execute(array_merge($array, $wh_array));
    }

    public static function insert($into, $ins, $values, $array)
    {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO $into ($ins) VALUES ($values)");
        $stmt->execute($array);
    }

    public static function delete($from, $where, $array)
    {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM $from WHERE $where");
        $stmt->execute($array);
    }
}

?>