<?php
require_once __DIR__ . 'dbRec.php';

class User extends db {

    public static function createGuest($name, $email, $phone) {
        // Validation Guard: Determine if matching unique identities exist inside the schema boundaries
        $checkQuery = "SELECT id FROM users WHERE email = ? OR phone = ? LIMIT 1";
        $existingProfile = self::Fetch($checkQuery, $email, $phone);
        
        if ($existingProfile) {
            // Reassign to current operation transaction to prevent duplicate record key violations
            return $existingProfile['id'];
        }

        // Structural Parameter Formatting Layout Definition Matching SQL Assertions
        $username = strtolower(str_replace(' ', '', $name)) . rand(100, 999);
        $password = password_hash('123456', PASSWORD_DEFAULT);
        $nationality = 'Bangladeshi';
        $nationalId = 'NID' . rand(100000, 999999);

        $query = "INSERT INTO users 
                  (name, email, username, password_hash, phone, nationality, national_id, role, is_active) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, 'guest', 1)";

        self::Execute($query, $name, $email, $username, $password, $phone, $nationality, $nationalId);

        // Fetch back identity mapping pointer sequence
        $validationQuery = "SELECT id FROM users WHERE email = ? ORDER BY id DESC LIMIT 1";
        $userProfile = self::Fetch($validationQuery, $email);

        return $userProfile ? $userProfile['id'] : null;
    }
}
?>