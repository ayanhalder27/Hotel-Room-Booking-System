<?php
// Start session only if it hasn't been started yet by the parent file
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="container-fluid">

    <div class="page-title">
        <h2>Receptionist Profile</h2>
    </div>

    <div class="table-section">
        <table class="table table-bordered">
            <tr>
                <th>Name</th>
                <td>
                    <?php echo isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name'], ENT_QUOTES, 'UTF-8') : 'N/A'; ?>
                </td>
            </tr>

            <tr>
                <th>Email</th>
                <td>
                    <?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email'], ENT_QUOTES, 'UTF-8') : 'N/A'; ?>
                </td>
            </tr>

            <tr>
                <th>Role</th>
                <td>
                    <?php echo isset($_SESSION['role']) ? htmlspecialchars($_SESSION['role'], ENT_QUOTES, 'UTF-8') : 'N/A'; ?>
                </td>
            </tr>
        </table>
    </div>

</div>