<?php
require_once 'db_connection.php';

function accept_shipment($shipment_id, $transporter_id) {
    global $conn;
    
    $shipment_id = mysqli_real_escape_string($conn, $shipment_id);
    $transporter_id = mysqli_real_escape_string($conn, $transporter_id);
    
    // Start transaction
    mysqli_begin_transaction($conn);
    
    try {
        // Update shipment status
        $update_query = "UPDATE shipments SET status = 'accepted', transporter_id = '$transporter_id' WHERE shipment_id = '$shipment_id' AND status = 'pending'";
        $update_result = mysqli_query($conn, $update_query);
        
        if (!$update_result || mysqli_affected_rows($conn) == 0) {
            throw new Exception("Failed to update shipment status or shipment already accepted.");
        }
        
        // Log the acceptance
        $log_query = "INSERT INTO shipment_logs (shipment_id, transporter_id, action, timestamp) VALUES ('$shipment_id', '$transporter_id', 'accepted', NOW())";
        $log_result = mysqli_query($conn, $log_query);
        
        if (!$log_result) {
            throw new Exception("Failed to log shipment acceptance.");
        }
        
        // Commit transaction
        mysqli_commit($conn);
        return true;
    } catch (Exception $e) {
        // Rollback transaction on error
        mysqli_rollback($conn);
        return false;
    }
}

// Usage example:
// $shipment_id = '456';
// $transporter_id = '123';
// $success = accept_shipment($shipment_id, $transporter_id);
// if ($success) {
//     echo "Shipment accepted successfully.";
// } else {
//     echo "Failed to accept shipment.";
// }
