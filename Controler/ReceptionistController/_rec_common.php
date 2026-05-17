<?php
require_once(__DIR__ . "/../../Model/dbRec.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Ensure only receptionists can access.
 */
function requireReceptionist() {
    if (
        !isset($_SESSION['user_id']) ||
        ($_SESSION['role'] ?? '') !== 'receptionist'
    ) {
        db::JsonResponse(false, 'Unauthorized receptionist access.');
    }
}

/**
 * Get POST value safely.
 */
function post($key, $default = '') {
    return trim($_POST[$key] ?? $default);
}

/**
 * Validate required fields.
 */
function requiredFields(array $fields) {
    foreach ($fields as $field) {
        if (post($field) === '') {
            $label = ucfirst(str_replace('_', ' ', $field));
            db::JsonResponse(false, "$label is required.");
        }
    }
}

/**
 * Validate date range.
 */
function validDateRange($checkin, $checkout) {
    if (
        !$checkin ||
        !$checkout ||
        strtotime($checkout) <= strtotime($checkin)
    ) {
        db::JsonResponse(false, 'Checkout date must be after check-in date.');
    }
}

/**
 * Helper for LIKE queries.
 */
function likeQ($q) {
    return '%' . $q . '%';
}

// Enforce receptionist access
requireReceptionist();
