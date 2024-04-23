<!DOCTYPE html>
<html>
<head>
    <!-- Link to the form CSS file -->
    <link rel="stylesheet" href="/assets/css/form.css">
</head>
<body>
<!-- Product Add Modal -->
<div id="editProfileModal" class="modal" style="display:none;">
  <!-- Modal content container -->
  <div class="modal-content">
    <!-- Close button for the modal -->
    <span class="close">&times;</span>
    <div class="form">
    <form action="/edit-profile" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['NAME']); ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['EMAIL']); ?>" required>

        <label for="phoneNumber">Phone Number:</label>
        <input type="text" id="phoneNumber" name="phoneNumber" value="<?php echo htmlspecialchars($user['PHONENUMBER']); ?>">

        <button type="submit">Update Profile</button>
    </form>
    </div>
  </div>
</div>
</body>
</html>