<!DOCTYPE html>
<html>
<head>
    <!-- Link to the profile page's CSS file -->
    <link rel="stylesheet" href="/assets/css/profile.css">
    <!-- Link to the profile page's JavaScript file -->
    <script src="/assets/js/profile.js"></script>
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
                    <li><a href="/edit-profile">Edit Profile [WIP]</a></li>
                    <li><a href="/change-password">Change Password [WIP]</a></li>
                    <li><a href="/privacy-settings">Privacy Settings [WIP]</a></li>
                    <li><a href="/api/logout">Logout</a></li>
                    <li><a href="/api/delete-profile" class="danger-link">Delete Profile</a></li>
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
            <!-- Section displaying profile information -->
            <section class="profile-information">
                <h2>Profile Information</h2>
                <!-- Display the user's email if available, otherwise 'N/A' -->
                <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email'] ?? 'N/A'); ?></p>
            </section>
            <!-- Section for quick links -->
            <section class="profile-actions">
                <h2>Quick Links</h2>
                <!-- Each link is a quick action for the user -->
                <a href="/order-history" class="action-link">Order History [WIP]</a>
                <a href="/my-products" class="action-link">My Products [WIP]</a>
            </section>
        </main>
    </div>
</body>
</html>