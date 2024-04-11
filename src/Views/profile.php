<div class="profile-container">
    <h1>Profile Page</h1>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?>!</p>
    <ul>
        <li><a href="/order-history">Order History</a></li>
        <li><a href="/my-products">My Products</a></li>
        <li><a href="/favorites">Favorites</a></li>
        <li><a href="/edit-profile">Modify Profile</a></li>
        <li><a href="/logout">Logout</a></li>
        <li><a href="/delete-profile">Delete Profile</a></li>
    </ul>
</div>