<?php
require_once __DIR__ . '/../admin_auth.php';
include("../../Model/db.php");
header('Content-Type: application/json');

try {
    $today = date('Y-m-d');
    
    // 1. Rooms Stats
    $totalRoomsQuery = "SELECT COUNT(*) as cnt FROM rooms";
    $totalRoomsResult = db::FetchAll($totalRoomsQuery);
    $totalRooms = $totalRoomsResult[0]['cnt'] ?? 0;
    
    // Occupied rooms are those checked-in today, or where today is between check_in and check_out for confirmed/checked-in bookings
    // For simplicity, we'll count bookings with status 'checked-in' as occupied
    $occupiedQuery = "SELECT COUNT(DISTINCT room_id) as cnt FROM bookings WHERE status = 'checked_in'";
    $occupiedResult = db::FetchAll($occupiedQuery);
    $occupiedRooms = $occupiedResult[0]['cnt'] ?? 0;
    
    $availableRooms = max(0, $totalRooms - $occupiedRooms);
    $occupancyRate = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100) : 0;
    
    // 2. Today's Revenue (Bookings created today)
    $revenueQuery = "SELECT SUM(total_price) as total FROM bookings WHERE DATE(created_at) = ?";
    $revenueResult = db::FetchAll($revenueQuery, $today);
    $todayRevenue = $revenueResult[0]['total'] ?? 0;
    
    // 3. Active Maintenance
    // check if table exists
    $maintenanceCount = 0;
    try {
        $mQuery = "SELECT COUNT(*) as cnt FROM service_requests WHERE status = 'pending'";
        $mResult = db::FetchAll($mQuery);
        $maintenanceCount = $mResult[0]['cnt'] ?? 0;
    } catch (Exception $e) {}
    
    // 4. Pending Reviews
    $reviewsCount = 0;
    try {
        $rQuery = "SELECT COUNT(*) as cnt FROM reviews WHERE status = 'pending'";
        $rResult = db::FetchAll($rQuery);
        $reviewsCount = $rResult[0]['cnt'] ?? 0;
    } catch (Exception $e) {}
    
    // 5. Recent Bookings
    $bookingsQuery = "SELECT b.id, u.name as guest_name, rt.name as room_type, b.checkin_date as check_in_date, b.checkout_date as check_out_date, b.total_price, b.status 
                      FROM bookings b 
                      INNER JOIN users u ON b.guest_id = u.id
                      LEFT JOIN rooms r ON b.room_id = r.id
                      LEFT JOIN room_types rt ON rt.id = COALESCE(r.room_type_id, b.room_type_id)
                      ORDER BY b.created_at DESC LIMIT 5";
    $recentBookings = [];
    try {
        $recentBookings = db::FetchAll($bookingsQuery);
    } catch (Exception $e) {}

    echo json_encode([
        'success' => true,
        'data' => [
            'occupancy_rate' => $occupancyRate,
            'today_revenue' => $todayRevenue,
            'total_rooms' => $totalRooms,
            'occupied_rooms' => $occupiedRooms,
            'available_rooms' => $availableRooms,
            'active_maintenance' => $maintenanceCount,
            'pending_reviews' => $reviewsCount,
            'recent_bookings' => $recentBookings
        ]
    ]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
