<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Project name</a>
    </div>
    <div id="search-form" class="navbar-collapse collapse">
      <form class="navbar-form" action="/search.php" method="post" onsubmit="return performSearch()" >
        <div id="search-group">
          <input type="text" id="search" placeholder="Search..." autocomplete="off" class="form-control">
          <input type="text" id="hard-search" disabled="disabled" class="form-control">
          <div id="search-items">
          </div>
        </div>
        <button id="search-submit" type="submit" class="btn btn-success">Go</button>
      </form>
    </div><!--/.navbar-collapse -->
  </div>
</nav>