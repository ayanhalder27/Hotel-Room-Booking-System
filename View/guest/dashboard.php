```php
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Guest Dashboard</title>

    <!-- Bootstrap -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />

    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="guest.css" />
  </head>
  <body>
    <div class="main-container">
      <!-- Sidebar -->
      <?php include("sidebar_guest.php"); ?>

      <!-- Main Content -->
      <div class="content-area">
        <!-- Header -->
        <?php include("header.php"); ?>

        <!-- Dynamic Content -->
        <div class="content-wrapper" id="guest-content">
          <?php include("dashboard_home.php"); ?>
        </div>
      </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="guest.js"></script>
  </body>
</html>
```
