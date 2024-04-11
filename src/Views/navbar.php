<?php include __DIR__ . '/login.php'; ?>
<?php include __DIR__ . '/register.php'; ?>

<nav class="header">
    <div class="container">
        <a href="/" class="logo-container">
          <!-- Logo -->
          <img src="/assets/images/logo.png" alt="Webshop Logo" class="header-logo">
        </a>
        <div class="search-container">
            <input type="text" placeholder="Search products..." class="search-input">
            <button type="submit" class="search-button">Search</button>
        </div>
        <div class="header-right">
            <!-- Cart Icon -->
            <a href="/api/cart" class="cart-link">
              <img src="/assets/images/cart.png" alt="Cart Icon" class="navbar-icon">
            </a>
            <?php if(isset($_SESSION['userid'])): ?>
              <!-- Profile Icon -->
              <a href="/api/profile" class="profile-link">
                <img src="/assets/images/profile.png" alt="Profile Icon" class="navbar-icon">
              </a>
            <?php else: ?>
                <!-- Login and Register Buttons -->
                <button onclick="showModal('loginModal')" class="btn btn-secondary">Login</button>
                <button onclick="showModal('registerModal')" class="btn btn-primary">Register</button>
            <?php endif; ?>
        </div>
    </div>
</nav>