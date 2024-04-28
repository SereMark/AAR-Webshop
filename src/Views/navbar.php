<!-- Include the login and register modals -->
<?php include __DIR__ . '/login.php'; ?>
<?php include __DIR__ . '/register.php'; ?>

<nav class="header">
    <div class="container">
        <!-- Logo container with a link to the homepage -->
        <a href="/" class="logo-container">
          <!-- Logo image -->
          <img src="/assets/images/logo.png" alt="Webshop Logo" class="header-logo">
        </a>
        <!-- Search container -->
        <div class="search-container">
        <form action="/search" method="get" id="searchForm">
          <input type="text" name="q" placeholder="Search products..." class="search-input" required>
          <button type="submit" class="search-button">Search</button>
      </form>
        </div>
        <!-- Right side of the header -->
        <div class="header-right">
            <!-- If the user is logged in, show a link to the profile page with a profile icon -->
            <?php if(isset($_SESSION['userid'])): ?>
              <!-- Link to the cart page with a cart icon -->
              <a href="/cart" class="cart-link">
                <img src="/assets/images/cart.png" alt="Cart Icon" class="navbar-icon">
              </a>
              <a href="/profile" class="profile-link">
                <img src="/assets/images/profile.png" alt="Profile Icon" class="navbar-icon">
              </a>
            <!-- If the user is not logged in, show Login and Register buttons -->
            <?php else: ?>
                <button onclick="showModal('loginModal')" class="btn btn-secondary">Login</button>
                <button onclick="showModal('registerModal')" class="btn btn-primary">Register</button>
            <?php endif; ?>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var searchForm = document.getElementById('searchForm');
    if (searchForm) {
        searchForm.addEventListener('submit', function(event) {
            event.preventDefault();
            var searchQuery = document.querySelector('.search-input').value;
            window.location.href = '/search?q=' + encodeURIComponent(searchQuery);
        });
    } else {
        console.log('Search form not found');
    }
});
</script>