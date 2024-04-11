<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/assets/css/profile.css">
</head>
<body>
    <div class="profile-wrapper">
        <aside class="sidebar">
            <div class="sidebar-content">
                <h3>My Profile</h3>
                <ul class="sidebar-nav">
                    <li><a href="/edit-profile">Edit Profile</a></li>
                    <li><a href="/change-password">Change Password</a></li>
                    <li><a href="/privacy-settings">Privacy Settings</a></li>
                    <li><a href="/logout">Logout</a></li>
                    <li><a href="/delete-profile" class="danger-link">Delete Profile</a></li>
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
                <p><strong>Email:</strong> user@example.com</p>
                <p><strong>Member Since:</strong> January 1, 2020</p>
                <p><strong>Last Login:</strong> April 10, 2024</p>
                <!-- Additional profile information here -->
            </section>
            <section class="profile-actions">
                <h2>Quick Links</h2>
                <a href="/order-history" class="action-link">Order History</a>
                <a href="/my-products" class="action-link">My Products</a>
                <a href="/favorites" class="action-link">Favorites</a>
                <!-- More links can be added here -->
            </section>
        </main>
    </div>
</body>
</html>