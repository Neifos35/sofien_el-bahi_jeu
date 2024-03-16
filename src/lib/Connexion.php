<?php

class Connexion {
    public static function connect() {
        try {
            $db = new PDO("mysql:host=localhost;dbname=kasyno", "root", "");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e) {
            echo $e->getMessage(); // Printing error message instead of the exception object
            return null;
        }
    }
}


