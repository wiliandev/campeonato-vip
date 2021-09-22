<?php include('include/header.php'); ?>

  <div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-4">Bem Vindo!</h1>
        <p class="lead text-primary ont-weight-bold"><?php echo $_SESSION['fullname']; ?></p>
        <hr class="my-4">
      <p>Sistema de login desenvolvido por Wilian G</p>
      <a class="btn btn-primary btn-lg" target="blank" href="#" role="button">Saber mais</a>
    </div>
  </div>

<?php include('include/footer.php'); ?>