<?php

require_once 'db.php';

class User extends db{


    // CREATE WALK-IN GUEST
    public static function createGuest(
        $name,
        $email,
        $phone
    ){

        $password = password_hash('123456', PASSWORD_DEFAULT);

        $query = "INSERT INTO users
                    (
                        name,
                        email,
                        password_hash,
                        phone,
                        role,
                        is_active
                    )
                    VALUES
                    (
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
            $password,
            $phone
        );



        $query2 = "SELECT id
                   FROM users
                   WHERE email=?";

        $user = self::Fetch($query2, $email);

        return $user['id'];

    }

}

?>