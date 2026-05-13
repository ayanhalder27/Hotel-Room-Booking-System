<?php

    abstract class db{
        private static $con;

        private static function connect()
        {
            $evn =  parse_ini_file(__DIR__."/../.env");
            self::$con = mysqli_init();

            mysqli_ssl_set(self::$con, null, null, __DIR__."/ca.pem", null, null);
            mysqli_real_connect(self::$con, $evn["DB_HOST"], $evn["DB_USERNAME"], $evn["DB_PASSWORD"], $evn["DB_NAME"], $evn["DB_PORT"]);

            if(!self::$con){
                die("Connection Failed: " . mysqli_connect_error());
            }
        }


        public static function Execute($query, ...$values){
            self::connect();
            $statement = mysqli_prepare(self::$con, $query);
            if(!$statement){
                die("Error preparing query: " . mysqli_error(self::$con));
            }

            $success = mysqli_stmt_execute($statement, $values);

            if (!$success) {
                die("Error executing query: " . mysqli_stmt_error($statement));
            }

            return $success;

        }

        public static function Fetch($query , ...$values){
            self::connect();
            $statement = mysqli_prepare(self::$con, $query);
            if(!$statement){
                die("Error preparing query: " . mysqli_error(self::$con));
            }

            if(!mysqli_stmt_execute($statement, $values)){
                die("Error preparing query: ". mysqli_stmt_error($statement));
            }

            $result = mysqli_stmt_get_result($statement);
            
            if($result !== false){
                return mysqli_fetch_assoc($result);
            }

            return false;
        }

        public static function FetchAll($query , ...$values){
            self::connect();
            $statement = mysqli_prepare(self::$con, $query);
            if(!$statement){
                die("Error preparing query: " . mysqli_error(self::$con));
            }

            if(!mysqli_stmt_execute($statement, $values)){
                die("Error preparing query: ". mysqli_stmt_error($statement));
            }

            $result = mysqli_stmt_get_result($statement);

            if($result !== false){
                return mysqli_fetch_all($result, MYSQLI_ASSOC);
            }

            return false;
        }
    }


?>