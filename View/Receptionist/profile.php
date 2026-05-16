<div class="container-fluid">

    <div class="page-title">
        <h2>Receptionist Profile</h2>
    </div>


    <div class="table-section">

        <table class="table table-bordered">

            <tr>
                <th>Name</th>

                <td>
                    <?php echo $_SESSION['name']; ?>
                </td>
            </tr>


            <tr>
                <th>Email</th>

                <td>
                    <?php echo $_SESSION['email']; ?>
                </td>
            </tr>


            <tr>
                <th>Role</th>

                <td>
                    <?php echo $_SESSION['role']; ?>
                </td>
            </tr>

        </table>

    </div>

</div>