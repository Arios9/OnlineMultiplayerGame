<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="/connect4/">Home</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a >Home</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span>&nbsp<span id="username"><?php echo $_SESSION['username'];?></span></a>
        <ul class="dropdown-menu">
          <li><a href="settings.php"><span class="glyphicon glyphicon-cog"></span>&nbsp Settings</a></li>
          <li><a href="logout.php"><span class="glyphicon glyphicon-off"></span>&nbsp Logout</a></li>
        </ul>
      </li>
    </ul>
  </div>
</nav>
  