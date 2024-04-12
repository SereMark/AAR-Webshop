<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/assets/css/profile.css">
    <script src="/assets/js/profile.js"></script>
</head>
<body>
    <div class="profile-wrapper">
        <aside class="sidebar">
            <div class="sidebar-content">
                <h3>My Profile</h3>
                <ul class="sidebar-nav">
                    <li><a href="/edit-profile">Edit Profile [WIP]</a></li>
                    <li><a href="/change-password">Change Password [WIP]</a></li>
                    <li><a href="/privacy-settings">Privacy Settings [WIP]</a></li>
                    <li><a href="/api/logout">Logout</a></li>
                    <li><a href="/api/delete-profile" class="danger-link">Delete Profile</a></li>
                </ul>
            </div>
        </aside>
        <main class="profile-main">
            <section class="profile-header">
                <img src="/assets/images/profile.png" alt="User's Profile Picture" class="profile-picture">
                <h1>Welcome, <?php echo htmlspecialchars($_SESSION['name'] ?? 'Guest'); ?>!</h1>
            </section>
            <section class="profile-information">
                <h2>Profile Information</h2>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email'] ?? 'N/A'); ?></p>
            </section>
            <section class="profile-actions">
                <h2>Quick Links</h2>
                <a href="/order-history" class="action-link">Order History [WIP]</a>
                <a href="/my-products" class="action-link">My Products [WIP]</a>
                <a href="/favorites" class="action-link">Favorites [WIP]</a>
            </section>
        </main>
    </div>
</body>
</html>