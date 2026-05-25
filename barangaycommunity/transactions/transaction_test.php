<?php

include '../config/database.php';

mysqli_begin_transaction($conn);

try {

    /*
    |--------------------------------------------------------------------------
    | INSERT CLEARANCE
    |--------------------------------------------------------------------------
    */

    $clearance_query = "INSERT INTO clearances(

        resident_id,
        clearance_type,
        purpose,
        status

    )

    VALUES(

        2,
        'Barangay Clearance',
        'Employment',
        'Approved'

    )";

    mysqli_query($conn, $clearance_query);

    /*
    |--------------------------------------------------------------------------
    | INSERT AUDIT LOG
    |--------------------------------------------------------------------------
    */

    $audit_query = "INSERT INTO audit_logs(

        action_type,
        table_name,
        description

    )

    VALUES(

        'INSERT',
        'clearances',
        'New clearance issued'

    )";

    mysqli_query($conn, $audit_query);

    /*
    |--------------------------------------------------------------------------
    | COMMIT
    |--------------------------------------------------------------------------
    */

    mysqli_commit($conn);

    echo "Transaction Successful";

} catch (Exception $e) {

    /*
    |--------------------------------------------------------------------------
    | ROLLBACK
    |--------------------------------------------------------------------------
    */

    mysqli_rollback($conn);

    echo "Transaction Failed";

}

?>