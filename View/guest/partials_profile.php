<section data-page-title="My Profile" data-page-script="profile.js">
  <div class="page-intro">
    <span class="eyebrow">Account</span>
    <h2>Manage profile</h2>
    <p>Update personal information and password.</p>
  </div>

  <div id="alertBox" class="alert" role="alert"></div>

  <div class="grid grid-2">
    <!-- Profile Information -->
    <div class="card">
      <h3>Profile Information</h3>
      <form id="profileForm" class="form-grid one">
        <div class="form-group">
          <label for="name">Name</label>
          <input class="input" id="name" name="name" required>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input class="input" id="email" name="email" type="email" required>
        </div>
        <div class="form-group">
          <label for="phone">Phone</label>
          <input class="input" id="phone" name="phone" required>
        </div>
        <div class="form-group">
          <label for="nationality">Nationality</label>
          <input class="input" id="nationality" name="nationality">
        </div>
        <div class="form-group">
          <label for="nationalId">ID Number</label>
          <input class="input" id="nationalId" name="national_id">
        </div>
        <button class="btn btn-gradient" type="submit">Update Profile</button>
      </form>
    </div>

    <!-- Change Password -->
    <div class="card">
      <h3>Change Password</h3>
      <form id="passwordForm" class="form-grid one">
        <div class="form-group">
          <label for="currentPassword">Current Password</label>
          <input class="input" id="currentPassword" type="password" name="current_password" required>
        </div>
        <div class="form-group">
          <label for="newPassword">New Password</label>
          <input class="input" id="newPassword" type="password" name="new_password" required>
        </div>
        <div class="form-group">
          <label for="confirmPassword">Confirm New Password</label>
          <input class="input" id="confirmPassword" type="password" name="confirm_password" required>
        </div>
        <button class="btn btn-primary" type="submit">Change Password</button>
      </form>
    </div>
  </div>
</section>
