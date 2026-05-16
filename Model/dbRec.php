<?php
abstract class db {
    private static $con = null;
    private static $lastError = null;

    private static function connect() {
        if (self::$con !== null) return self::$con;

        $envPath = __DIR__ . '/../.env';
        if (!file_exists($envPath)) self::handleError('ENV file not found: ' . $envPath);
        $env = parse_ini_file($envPath);

        self::$con = mysqli_connect(
            $env['DB_HOST'] ?? 'localhost',
            $env['DB_USERNAME'] ?? 'root',
            $env['DB_PASSWORD'] ?? '',
            $env['DB_NAME'] ?? '',
            isset($env['DB_PORT']) ? (int)$env['DB_PORT'] : 3306
        );

        if (!self::$con) self::handleError('Database connection failed: ' . mysqli_connect_error());
        mysqli_set_charset(self::$con, 'utf8mb4');
        return self::$con;
    }

    private static function handleError($message) {
        self::$lastError = $message;
        error_log($message);
        throw new Exception($message);
    }

    public static function LastError() { return self::$lastError; }

    private static function normalizeValues($values) {
        if (isset($values[0]) && is_array($values[0]) && count($values) === 1) return $values[0];
        return $values;
    }

    private static function prepareAndBind($query, $values = []) {
        $connection = self::connect();
        $values = self::normalizeValues($values);
        $statement = mysqli_prepare($connection, $query);
        if (!$statement) self::handleError('Query preparation failed: ' . mysqli_error($connection));

        if (!empty($values)) {
            $types = '';
            foreach ($values as $value) {
                if (is_int($value)) $types .= 'i';
                elseif (is_float($value) || is_double($value)) $types .= 'd';
                else $types .= 's';
            }
            if (!mysqli_stmt_bind_param($statement, $types, ...$values)) {
                self::handleError('Parameter binding failed: ' . mysqli_stmt_error($statement));
            }
        }
        return $statement;
    }

    public static function Execute($query, ...$values) {
        $statement = self::prepareAndBind($query, $values);
        if (!mysqli_stmt_execute($statement)) self::handleError('Execution failed: ' . mysqli_stmt_error($statement));
        return true;
    }

    public static function Fetch($query, ...$values) {
        $statement = self::prepareAndBind($query, $values);
        if (!mysqli_stmt_execute($statement)) self::handleError('Fetch failed: ' . mysqli_stmt_error($statement));
        $result = mysqli_stmt_get_result($statement);
        return $result ? mysqli_fetch_assoc($result) : null;
    }

    public static function FetchAll($query, ...$values) {
        $statement = self::prepareAndBind($query, $values);
        if (!mysqli_stmt_execute($statement)) self::handleError('FetchAll failed: ' . mysqli_stmt_error($statement));
        $result = mysqli_stmt_get_result($statement);
        return $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
    }

    public static function FetchValue($query, ...$values) {
        $statement = self::prepareAndBind($query, $values);
        if (!mysqli_stmt_execute($statement)) self::handleError('FetchValue failed: ' . mysqli_stmt_error($statement));
        $result = mysqli_stmt_get_result($statement);
        if (!$result) return null;
        $row = mysqli_fetch_row($result);
        return $row ? $row[0] : null;
    }

    public static function InsertId() { return mysqli_insert_id(self::connect()); }
    public static function AffectedRows() { return mysqli_affected_rows(self::connect()); }
    public static function BeginTransaction() { mysqli_begin_transaction(self::connect()); }
    public static function Commit() { mysqli_commit(self::connect()); }
    public static function Rollback() { mysqli_rollback(self::connect()); }
    public static function CountRows($query, ...$values) { return (int)self::FetchValue($query, ...$values); }
    public static function Exists($query, ...$values) { return self::FetchValue($query, ...$values) !== null; }

    public static function JsonResponse($success, $message, $data = []) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['success'=>(bool)$success, 'message'=>$message, 'data'=>$data]);
        exit();
    }

    public static function Close() {
        if (self::$con !== null) {
            mysqli_close(self::$con);
            self::$con = null;
        }
    }
}
?>
