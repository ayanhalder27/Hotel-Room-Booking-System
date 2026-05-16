<?php

abstract class db{

    private static $con = null;



    // DATABASE CONNECTION
    private static function connect(){

        if(self::$con != null){
            return self::$con;
        }

        $env = parse_ini_file(__DIR__ . "/../.env");

        self::$con = mysqli_connect(
            $env["DB_HOST"],
            $env["DB_USERNAME"],
            $env["DB_PASSWORD"],
            $env["DB_NAME"],
            $env["DB_PORT"]
        );

        if(!self::$con){
            die("Database Connection Failed : " . mysqli_connect_error());
        }

        return self::$con;
    }



    // PREPARE & BIND
    private static function prepareAndBind($query, $values = []){

        $connection = self::connect();

        $statement = mysqli_prepare($connection, $query);

        if(!$statement){
            die("Query Preparation Failed : " . mysqli_error($connection));
        }



        // BIND PARAMETERS
        if(!empty($values)){

            $types = "";

            foreach($values as $value){

                if(is_int($value)){
                    $types .= "i";
                }
                elseif(is_double($value)){
                    $types .= "d";
                }
                else{
                    $types .= "s";
                }

            }

            mysqli_stmt_bind_param($statement, $types, ...$values);

        }

        return $statement;
    }



    // EXECUTE INSERT UPDATE DELETE
    public static function Execute($query, ...$values){

        $statement = self::prepareAndBind($query, $values);

        $success = mysqli_stmt_execute($statement);

        if(!$success){
            die("Execution Failed : " . mysqli_stmt_error($statement));
        }

        return true;
    }



    // FETCH SINGLE ROW
    public static function Fetch($query, ...$values){

        $statement = self::prepareAndBind($query, $values);

        $success = mysqli_stmt_execute($statement);

        if(!$success){
            die("Fetch Failed : " . mysqli_stmt_error($statement));
        }

        $result = mysqli_stmt_get_result($statement);

        if($result){
            return mysqli_fetch_assoc($result);
        }

        return false;
    }



    // FETCH MULTIPLE ROWS
    public static function FetchAll($query, ...$values){

        $statement = self::prepareAndBind($query, $values);

        $success = mysqli_stmt_execute($statement);

        if(!$success){
            die("FetchAll Failed : " . mysqli_stmt_error($statement));
        }

        $result = mysqli_stmt_get_result($statement);

        if($result){
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        return [];
    }



    // FETCH SINGLE VALUE
    public static function FetchValue($query, ...$values){

        $statement = self::prepareAndBind($query, $values);

        $success = mysqli_stmt_execute($statement);

        if(!$success){
            die("FetchValue Failed : " . mysqli_stmt_error($statement));
        }

        $result = mysqli_stmt_get_result($statement);

        if($result){

            $row = mysqli_fetch_row($result);

            return $row[0];

        }

        return false;
    }

}

?>