<?php
  require_once 'mysqlaccess.php';
?>
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <a class="navbar-brand" href="/">PoxBrain</a>
    <div id="accounts" class="" data-loggedin="<?php echo $auth->isLoggedIn() ? 1 : 0; ?>">
      <img src="/images/person_icon.png" alt="Handle your account">
      <div id="account-popup">
        <?php if($auth->isLoggedIn()) { ?>
          <div>
            <div class="top">
              <?php echo $auth->getUsername(); ?>
              <span><?php echo $auth->getEmail(); ?></span>
            </div>
            <hr>
              <ul>
                <a href="/account.php"><li>My Account</li></a>
                <a href="/account.php?collection"><li>Update Collection</li></a>
                <li onclick="performLogout()">Logout</li>
              </ul>
          </div>
        <?php } ?>
      </div>
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
<div id="dim" onclick="dismissPopups()"></div>
<!--<div id="collection-help" class="floating-popup">
  <h3>Track your collection on PoxNora in PoxBrain!</h3>
  <p>This will display how many copies of each rune you own and their levels on rune and search pages.</p>
  <p>Step 1: Make sure you're logged in on <a href="https://www.poxnora.com" target="_blank">poxnora.com</a></p>
  <p>Step 2: Visit <a href="https://www.poxnora.com/runes/load-forge.do?m=checklist" target="_blank">this page</a>. Select everything (Ctrl+A) and copy it (Ctrl+C) into the text box below:</p>
  <textarea id="collection-textarea"></textarea>
  <button id="collection-submit" type="button" class="btn btn-primary" onclick="processCollection()">Step 3: Click here!</button>
  <p id="collection-help-text"></p>
</div>-->
<div id="login-signup" class="floating-popup">
  <div class="tab-group">
    <div class="tab active" onclick="loginTab()">
      Login
    </div>
    <div class="tab" onclick="registerTab()">
      Signup
    </div>
  </div>
  <form id="login" method="post" action="login.php" onsubmit="return performLogin()">
    <div class="form-group">
      <input type="email" class="form-control" id="login-email" name="email" required="required" placeholder="Email">
    </div>
    <div class="form-group">
      <input type="password" class="form-control" id="login-password" name="password" required="required" placeholder="Password">
      <a href="/forgetpassword.php"><label id="password-reset">Forgotten your password?</label></a>
    </div>
    <div class="checkbox">
      <label for="login-remember">
        <input type="checkbox" name="remember" id="login-remember"> Remember Me
      </label>
    </div>
    <button type="submit" class="btn btn-success">Login</button>
  </form>
  <form id="signup" class="hide" method="post" action="signup.php" onsubmit="return performRegister()">
    <div class="form-group">
      <input type="email" class="form-control" id="register-email" name="email" required="required" placeholder="Email">
    </div>
    <div class="form-group">
      <input type="password" class="password-control form-control" id="register-password" name="password" required="required" placeholder="Password">
    </div>
    <div class="form-group">
      <input type="password" class="password-control form-control" id="register-password-confirm" name="password-confirm" required="required" placeholder="Password (again)">
    </div>
    <p id="password-match"></p>
    <div class="form-group">
      <input type="username" class="form-control" id="register-username" name="username" required="required" placeholder="Username">
    </div>
    <button type="submit" class="btn btn-success">Register</button>
  </form>
  <p id="account-result"></p>
</div>
<script type="text/javascript">
    if(/MSIE \d|Trident.*rv:/.test(navigator.userAgent))
        document.write('<script src="https://cdnjs.cloudflare.com/ajax/libs/bluebird/3.3.5/bluebird.min.js"><\/script>');
</script>