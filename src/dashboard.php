<?php
require_once("./library/sessionHelper.php");
checkSession();

function getBaseUrl()
{
  $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === 0 ? 'https://' : 'http://';
  return $protocol . $_SERVER['HTTP_HOST'];
}

$baseUrl = getBaseUrl();
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.83.1">

  <!-- JQuery -->
  <script src="../node_modules\jquery\dist\jquery.min.js"></script>

  <!-- JSGrid -->
  <link type="text/css" rel="stylesheet" href="../node_modules\jsgrid\dist\jsgrid.min.css" />
  <link type="text/css" rel="stylesheet" href="../node_modules\jsgrid\dist/jsgrid-theme.min.css" />
  <script type="text/javascript" src="../node_modules\jsgrid\dist\jsgrid.min.js"></script>

  <title>PHP SESSIONS - Login example</title>

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>


  <!-- Custom styles for this template -->
  <link href="../assets/css/main.css" rel="stylesheet">
</head>

<body>

  <?= file_get_contents($baseUrl . '/php-employee-management-v1/assets/html/header.html'); ?>

  <div class="container-fluid">
    <div class="row">

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Welcome <span class="text-primary"><?= strstr($_SESSION["email"], '@', true) ?></span>, this is our Dashboard</h1>
          <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
              <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
              <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
              <span data-feather="calendar"></span>
              This week
            </button>
          </div>
        </div>

        <div id="jsGrid"></div>

        <script>
          var clients = (function() {
            var json = null;
            $.ajax({
              'async': false,
              'global': false,
              'url': "../resources/employees.json",
              'dataType': "json",
              'success': function(data) {
                json = data;
              }
            });
            return json;
          })();

          $("#jsGrid").jsGrid({
            width: "100%",
            height: "600px",

            inserting: true,
            editing: true,
            sorting: true,
            paging: true,
            autoload: true,
            deleteConfirm: "Do you really want to delete data?",


            controller: {
              loadData: function(filter) {
                return $.ajax({
                  type: "GET",
                  url: "fetch_data.php",
                  data: filter
                });
              },
              insertItem: function(item) {
                return $.ajax({
                  type: "POST",
                  url: "fetch_data.php",
                  data: item
                });
              },
              updateItem: function(item) {
                return $.ajax({
                  type: "PUT",
                  url: "fetch_data.php",
                  data: item
                });
              },
              deleteItem: function(item) {
                return $.ajax({
                  type: "DELETE",
                  url: "fetch_data.php",
                  data: item
                });
              },
            },


            data: clients,

            fields: [{
                name: "name",
                type: "text",
                width: 50,
                validate: "required"
              },
              {
                name: "lastName",
                type: "text",
                width: 60,
                validate: "required"
              },
              {
                name: "email",
                type: "text",
                width: 70,
                validate: "required"
              },
              {
                name: "age",
                type: "number",
                width: 25
              },
              {
                name: "postalCode",
                type: "number",
                width: 30
              },
              {
                name: "phoneNumber",
                type: "number",
                width: 40
              },
              {
                name: "state",
                type: "text",
                width: 50
              },
              {
                name: "gender",
                type: "text",
                width: 20
              },
              {
                name: "city",
                type: "text",
                width: 60
              },
              {
                name: "streetAddress",
                type: "text",
                width: 50
              },
              {
                type: "control"
              }
            ]
          });
        </script>
      </main>
    </div>
  </div>

  <?= file_get_contents($baseUrl . '/php-employee-management-v1/assets/html/footer.html'); ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
  <script src="../assets/js/index.js"></script>
</body>

</html>