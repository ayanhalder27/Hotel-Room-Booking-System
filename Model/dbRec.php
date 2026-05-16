<?php
abstract class db {
    private static $con = null;
    private static function connect() {
        if (self::$con !== null) return self::$con;
        $envPath = __DIR__ . '/../.env';
        if (!file_exists($envPath)) throw new Exception('ENV file not found: ' . $envPath);
        $env = parse_ini_file($envPath);
        self::$con = mysqli_connect($env['DB_HOST'] ?? 'localhost',$env['DB_USERNAME'] ?? 'root',$env['DB_PASSWORD'] ?? '',$env['DB_NAME'] ?? '',isset($env['DB_PORT'])?(int)$env['DB_PORT']:3306);
        if (!self::$con) throw new Exception('Database connection failed: ' . mysqli_connect_error());
        mysqli_set_charset(self::$con, 'utf8mb4');
        return self::$con;
    }
    private static function prepareAndBind($query, $values=[]) {
        if (isset($values[0]) && is_array($values[0]) && count($values)===1) $values=$values[0];
        $st = mysqli_prepare(self::connect(), $query);
        if (!$st) throw new Exception('Query preparation failed: ' . mysqli_error(self::connect()));
        if (!empty($values)) {
            $types=''; foreach($values as $v){ $types .= is_int($v)?'i':(is_float($v)||is_double($v)?'d':'s'); }
            if (!mysqli_stmt_bind_param($st,$types,...$values)) throw new Exception('Parameter binding failed: '.mysqli_stmt_error($st));
        }
        return $st;
    }
    public static function Execute($query,...$values){$st=self::prepareAndBind($query,$values); if(!mysqli_stmt_execute($st)) throw new Exception('Execution failed: '.mysqli_stmt_error($st)); return true;}
    public static function Fetch($query,...$values){$st=self::prepareAndBind($query,$values); if(!mysqli_stmt_execute($st)) throw new Exception('Fetch failed: '.mysqli_stmt_error($st)); $res=mysqli_stmt_get_result($st); return $res?mysqli_fetch_assoc($res):null;}
    public static function FetchAll($query,...$values){$st=self::prepareAndBind($query,$values); if(!mysqli_stmt_execute($st)) throw new Exception('FetchAll failed: '.mysqli_stmt_error($st)); $res=mysqli_stmt_get_result($st); return $res?mysqli_fetch_all($res,MYSQLI_ASSOC):[];}
    public static function FetchValue($query,...$values){$st=self::prepareAndBind($query,$values); if(!mysqli_stmt_execute($st)) throw new Exception('FetchValue failed: '.mysqli_stmt_error($st)); $res=mysqli_stmt_get_result($st); if(!$res)return null; $row=mysqli_fetch_row($res); return $row?$row[0]:null;}
    public static function InsertId(){return mysqli_insert_id(self::connect());}
    public static function AffectedRows(){return mysqli_affected_rows(self::connect());}
    public static function BeginTransaction(){mysqli_begin_transaction(self::connect());}
    public static function Commit(){mysqli_commit(self::connect());}
    public static function Rollback(){mysqli_rollback(self::connect());}
    public static function JsonResponse($success,$message,$data=[]){header('Content-Type: application/json'); echo json_encode(['success'=>$success,'message'=>$message,'data'=>$data]); exit;}
}
?>
