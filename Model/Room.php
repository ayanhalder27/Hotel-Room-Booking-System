<?php

// CHANGE THIS:
// require_once 'dbRec.php';

// TO THIS:
require_once __DIR__ . '/dbRec.php';

class Room extends db {

    /**
     * Fetch all rooms with their details
     */
    public static function getAllRooms() {
        $query = "SELECT
                    rooms.id,
                    rooms.room_number,
                    room_types.name AS room_type,
                    rooms.floor,
                    rooms.status
                  FROM rooms
                  JOIN room_types ON rooms.room_type_id = room_types.id";
        return self::FetchAll($query);
    }

    /**
     * Fetch only active rooms whose status is 'available'
     */
    public static function getAvailableRooms() {
        $query = "SELECT 
                    rooms.id, 
                    rooms.room_number, 
                    room_types.name AS room_type
                  FROM rooms
                  JOIN room_types ON rooms.room_type_id = room_types.id
                  WHERE rooms.status = 'available'
                  ORDER BY rooms.room_number ASC";
        return self::FetchAll($query);
    }

    /**
     * Update room status by room number
     */
    public static function updateRoomStatus($roomNumber, $status) {
        $query = "UPDATE rooms SET status = ? WHERE room_number = ?";
        return self::Execute($query, $status, $roomNumber);
    }

    // =======================================================
    // METRIC COUNTERS USING ENUM SCHEMAS
    // =======================================================

    /**
     * Count rooms by specific status
     * Allowed statuses: 'available', 'occupied', 'dirty', 'maintenance'
     */
    public static function getCountByRoomStatus($status) {
        $query = "SELECT COUNT(*) FROM rooms WHERE status = ?";
        $count = self::FetchValue($query, $status);
        return $count !== false ? (int)$count : 0;
    }

    /**
     * Count bookings by specific status
     * Allowed statuses: 'pending', 'confirmed', 'checked_in', 'checked_out', 'cancelled'
     */
    public static function getCountByBookingStatus($status) {
        $query = "SELECT COUNT(*) FROM bookings WHERE status = ?";
        $count = self::FetchValue($query, $status);
        return $count !== false ? (int)$count : 0;
    }
}