<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | FISEI</title>
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="form.css" rel="stylesheet">
</head>
<body class="bg-body-tertiary">
<nav class="navbar navbar-expand-lg bg-white">
    <div class="container-fluid">
  <img src="../img/nav.png" alt="Logo" width="130" height="70" class="d-inline-block align-text-top">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="c_admins.php" >Crear Administradores</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="c_estudiantes.php">Crear Estudiantes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="c_docentes.php">Crear Docentes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="c_asignaturas.php" >Crear Asignaturas</a>
        </li>
        <li class="nav-item">
          <a type="submit" class=" btn btn-danger bg-red text-white" href="../php/csesion.php">Cerrar Sesión</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
  <div class="container shadow-lg rounded p-4 mt-3">
  <form>
  <div class="container">
  <div class=" bg-red text-white text-center rounded h1 ">Crear Administrador</div>
    <div class="row mt-3">
      <ul class="list-inline">
        <li class="list-inline-item h4">Número de Cedula</li>
        <li class="list-inline-item"><input type="text" class="form-control"></li>
      </ul>
    </div>
    <div class="row">
      <label for="Username" class="form-label h5 ">Nombres</label>
    </div>
    <div class="row mt-1">
      <div class="col">
        <input type="text" class="form-control" placeholder="Primer Nombre">  
      </div>
        <div class="col">
        <input type="text" class="form-control" placeholder="Segundo Nombre">  
      </div>
    </div>
    <div class="row mt-3">
      <label for="Username" class="form-label h5 ">Apellidos</label>
    </div>
    <div class="row mt-1">
      <div class="col">
        <input type="text" class="form-control" placeholder="Primer Apellido">
      </div>
      <div class="col">
      <input type="text" class="form-control" placeholder="Segundo Apellido">  
      </div>
    </div>
    <div class="row mt-3">
      <div class="col">
        <label for="exampleInputEmail1" class="form-label h5">Correo Institucional</label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="@uta.edu.ec">
      </div>
      <div class="col">
        <label for="exampleInputPassword1" class="form-label h5">Contraseña</label>
        <input type="password" class="form-control" id="exampleInputPassword1">
      </div>
    </div>
    <div class="row mt-2">
      <div class="col">
        <button type="submit" class="btn btn-primary">Crear</button>
      </div>
    </div>
  </div>
  </form>
  </div>
  <script src="../js/bootstrap.js"></script>   
</body>
</html>