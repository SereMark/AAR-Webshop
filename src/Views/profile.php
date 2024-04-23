<!-- Include the editProfileModal and the changePasswordModal -->
<?php include __DIR__ . '/edit_profile.php'; ?>
<?php include __DIR__ . '/change_password.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <!-- Link to the profile page's CSS file -->
    <link rel="stylesheet" href="/assets/css/profile.css">
    <!-- Link to the profile page's JavaScript file -->
    <script src="/assets/js/profile.js"></script>
    <!-- Link to the Font Awesome CSS file for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <!-- Wrapper for the profile page -->
    <div class="profile-wrapper">
        <!-- Sidebar for profile actions -->
        <aside class="sidebar">
            <div class="sidebar-content">
                <h3>My Profile</h3>
                <!-- Navigation list for profile actions -->
                <ul class="sidebar-nav">
                    <!-- Each list item is a link to a profile action -->
                    <li><a href="#" onclick="showModal('editProfileModal'); return false;">Edit Profile</a></li>
                    <li><a href="#" onclick="showModal('changePasswordModal'); return false;">Change Password</a></li>
                    <li><a href="/logout">Logout</a></li>
                    <li><a href="/delete-profile" class="danger-link">Delete Profile</a></li>
                </ul>
            </div>
        </aside>
        <!-- Main content area for the profile page -->
        <main class="profile-main">
            <!-- Header section with profile picture and welcome message -->
            <section class="profile-header">
                <img src="/assets/images/profile.png" alt="User's Profile Picture" class="profile-picture">
                <!-- Welcome message, displaying the user's name if available, otherwise 'Guest' -->
                <h1>Welcome, <?php echo htmlspecialchars($_SESSION['name'] ?? 'Guest'); ?>!</h1>
            </section>
            <!-- Mini dashboard for quick stats -->
            <section class="profile-dashboard">
                <div class="dashboard-item">
                    <i class="fa fa-shopping-cart dashboard-icon"></i>
                    <span class="dashboard-value"><?php echo count($_SESSION['orders'] ?? []); ?></span>
                    <span class="dashboard-label">Orders</span>
                </div>
                <div class="dashboard-item">
                    <i class="fa fa-box dashboard-icon"></i>
                    <span class="dashboard-value"><?php echo count($_SESSION['products'] ?? []); ?></span>
                    <span class="dashboard-label">Products</span>
                </div>
                <div class="dashboard-item">
                    <i class="fa fa-star dashboard-icon"></i>
                    <span class="dashboard-value"><?php echo count($_SESSION['reviews'] ?? []); ?></span>
                    <span class="dashboard-label">Reviews</span>
                </div>
            </section>
            <section class="profile-information">
                <h2>Profile Information</h2>
                <!-- Display the user's email if available, otherwise 'N/A' -->
                <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email'] ?? 'N/A'); ?></p>
                <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($_SESSION['phonenumber'] ?? 'N/A'); ?></p>
            </section>
        </main>
    </div>
</body>
</html>