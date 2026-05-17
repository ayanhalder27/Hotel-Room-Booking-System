<section data-page-title="Room Details" data-page-script="room_details.js">
  <div id="alertBox" class="alert" role="alert"></div>

  <!-- Hidden room type ID for JS -->
  <input type="hidden" id="roomTypeId" 
         value="<?= htmlspecialchars($_GET['room_type_id'] ?? '') ?>">

  <div id="roomDetailsBox">
    <div class="card loading">
      <div class="spinner"></div>
      <p>Loading room details...</p>
    </div>
  </div>
</section>
