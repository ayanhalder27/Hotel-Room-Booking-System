<?php

require_once 'db.php';

class User extends db{


    // ==========================================
    // CREATE WALK-IN GUEST
    // ==========================================

    public static function createGuest(
        $name,
        $email,
        $phone
    ){

        // GENERATE USERNAME
        $username =
            strtolower(
                str_replace(' ', '', $name)
            )
            . rand(100,999);



        // DEFAULT PASSWORD
        $password =
            password_hash(
                '123456',
                PASSWORD_DEFAULT
            );



        // DEFAULT VALUES
        $nationality = 'Bangladeshi';

        $nationalId =
            'NID' . rand(100000,999999);



        // INSERT USER
        $query = "INSERT INTO users
        (
            name,
            email,
            username,
            password_hash,
            phone,
            nationality,
            national_id,
            role,
            is_active
        )

        VALUES
        (
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            'guest',
            1
        )";



        self::Execute(
            $query,
            $name,
            $email,
            $username,
            $password,
            $phone,
            $nationality,
            $nationalId
        );



        // GET USER ID
        $query2 = "SELECT id
                   FROM users
                   WHERE email=?";



        $user = self::Fetch(
            $query2,
            $email
        );



        return $user['id'];

    }

}

?>