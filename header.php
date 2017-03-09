<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <a class="navbar-brand" href="/">PoxBrain</a>
    <div id="accounts">
      <img src="/images/person_icon.png" alt="Handle your account">
    </div>
    <div id="search-form" class="">
      <form class="navbar-form" action="/search.php" method="get" onsubmit="return performSearch()" >
        <div id="search-group">
          <input type="text" name="search" id="search" placeholder="Search..." autocomplete="off" class="form-control">
          <input type="text" id="hard-search" disabled="disabled" class="form-control">
          <div id="search-items">
          </div>
        </div>
        <button id="search-submit" type="submit" class="btn btn-success">Go</button>
      </form>
    </div><!--/.navbar-collapse -->
  </div>
</nav>
<div id="ability-popup">
  
</div>
<div id="loading">
	<div id="loading-circles">
		<div class="loading-circle"></div>
		<div class="loading-circle2"></div>
	</div>
	<div id="loading-message">
		<span>We're finishing up some things. Please try to keep this tab open and not navigate away until it finishes. Once this finishes, you'll get suggested
		  search results as you type and hovering over abilities will tell you what they do</span>
	</div>
</div>
<div id="dim"></div>
<div id="login-signup">
  <form id="login" method="post" action="login.php" onsubmit="return performLogin()">
    <div class="form-group">
      <label for="email">Email address</label>
      <input type="email" class="form-control" id="login-email" name="email" required="required" placeholder="Email">
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" class="form-control" id="login-password" name="password" required="required" placeholder="Password">
    </div>
    <div class="checkbox">
      <label>
        <input type="checkbox" name="remember" id="login-remember"> Remember Me
      </label>
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
  </form>
  <form id="signup" method="post" action="signup.php" onsubmit="return performRegister()">
    <div class="form-group">
      <label for="email">Email address</label>
      <input type="email" class="form-control" id="register-email" name="email" required="required" placeholder="Email">
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" class="form-control" id="register-password" name="password" required="required" placeholder="Password">
    </div>
    <div class="form-group">
      <label for="username">Username</label>
      <input type="username" class="form-control" id="register-username" name="username" required="required" placeholder="Username">
    </div>
    <button type="submit" class="btn btn-info">Register</button>
  </form>
  <span>- OR -</span>
  <div id="exit-icon">X</div>
</div>