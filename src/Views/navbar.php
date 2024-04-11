<?php session_start(); ?>
<nav class="header">
    <div class="container">
        <a href="/" class="logo-container">
          <img src="assets/images/logo.png" alt="Webshop Logo" class="header-logo">
        </a>
        <div class="search-container">
            <input type="text" placeholder="Search products..." class="search-input">
            <button type="submit" class="search-button">Search</button>
        </div>
        <div class="header-right">
            <?php if(isset($_SESSION['userid'])): ?>
                <a href="/profile.php" class="profile-link"><img src="assets/images/profile.png" alt="Profile Icon" class="profile-icon"></a>
            <?php else: ?>
                <button onclick="showLoginModal()" class="btn btn-secondary">Login</button>
                <button onclick="showRegisterModal()" class="btn btn-primary">Register</button>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- Login Modal -->
<div id="loginModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <?php include __DIR__ . '/login.php'; ?>
  </div>
</div>

<!-- Register Modal -->
<div id="registerModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <?php include __DIR__ . '/register.php'; ?>
  </div>
</div>