<section data-page-title="Booking Details" data-page-script="booking_details.js">
  <div id="alertBox" class="alert" role="alert"></div>

  <!-- Hidden booking ID for JS -->
  <input type="hidden" id="bookingId" 
         value="<?= htmlspecialchars($_GET['booking_id'] ?? '') ?>">

  <div id="detailsBox">
    <div class="card loading">
      <div class="spinner"></div>
      <p>Loading booking details...</p>
    </div>
  </div>
</section>
