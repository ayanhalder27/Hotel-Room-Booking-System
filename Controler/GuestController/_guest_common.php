<?php
require_once __DIR__ . '/../../Model/dbRec.php';
if (session_status() === PHP_SESSION_NONE) session_start();
function jsonResponse($success, $message, $data = []) { db::JsonResponse($success, $message, $data); }
function post($key, $default = '') { return isset($_POST[$key]) ? trim((string)$_POST[$key]) : $default; }
function reqv($key, $default = '') { return isset($_POST[$key]) ? trim((string)$_POST[$key]) : (isset($_GET[$key]) ? trim((string)$_GET[$key]) : $default); }
function likeQ($value) { return '%' . $value . '%'; }
function requireGuest() { if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'guest') jsonResponse(false, 'Unauthorized. Login as guest first.'); return (int)$_SESSION['user_id']; }
function requiredFields($fields) { foreach ($fields as $f) if (post($f) === '') throw new Exception(ucwords(str_replace('_',' ',$f)) . ' is required.'); }
function validDateRange($ci,$co) { if ($ci==='' || $co==='') throw new Exception('Check-in and checkout dates are required.'); if (strtotime($co) <= strtotime($ci)) throw new Exception('Checkout date must be after check-in date.'); }
function nightsBetween($ci,$co) { validDateRange($ci,$co); return (int)((strtotime($co)-strtotime($ci))/86400); }
function columnExists($table,$col) { $dbn=db::FetchValue('SELECT DATABASE()'); return (int)db::FetchValue('SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA=? AND TABLE_NAME=? AND COLUMN_NAME=?',$dbn,$table,$col)>0; }
function userIdColumn() { return columnExists('users','national_id') ? 'national_id' : 'id_number'; }
function roomCapacityColumn() { return columnExists('room_types','max_capacity') ? 'max_capacity' : (columnExists('room_types','capacity') ? 'capacity' : 'max_capacity'); }
function billingGuestColumnExists() { return columnExists('billing','guest_id'); }
function bookingSourceColumnExists() { return columnExists('bookings','source'); }
function bookingSpecialRequestColumnExists() { return columnExists('bookings','special_requests'); }
function currentGuestId() { return requireGuest(); }
function guestOwnsBooking($bid,$gid) { return (int)db::FetchValue('SELECT COUNT(*) FROM bookings WHERE id=? AND guest_id=?',(int)$bid,(int)$gid)>0; }
function seasonalPrice($rtid,$ci,$co) { $base=(float)db::FetchValue('SELECT price_per_night FROM room_types WHERE id=?',(int)$rtid); $s=db::Fetch('SELECT label,price_per_night FROM seasonal_pricing WHERE room_type_id=? AND start_date<=? AND end_date>=? ORDER BY price_per_night DESC LIMIT 1',(int)$rtid,$co,$ci); return ['price'=>$s?(float)$s['price_per_night']:$base,'seasonal'=>$s]; }
function availableRoomCount($rtid,$ci,$co) { return (int)db::FetchValue("SELECT COUNT(*) FROM rooms r WHERE r.room_type_id=? AND r.status='available' AND r.id NOT IN (SELECT COALESCE(room_id,0) FROM bookings WHERE room_id IS NOT NULL AND status IN ('pending','confirmed','checked_in') AND ? < checkout_date AND ? > checkin_date)",(int)$rtid,$ci,$co); }
function wrapController($fn) { try { $fn(); jsonResponse(false,'Invalid action.'); } catch(Exception $e) { try{db::Rollback();}catch(Exception $x){} jsonResponse(false,$e->getMessage()); } }
?>
