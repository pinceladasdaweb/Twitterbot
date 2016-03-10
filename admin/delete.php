<?php
    require '../inc/Database.php';

    $id = null;
    if (!empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }

    if (null === $id) {
        header('Location: index.php');
    }

    if (!empty($_POST)) {
        $id = $_POST['id'];

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $q = $pdo->prepare('DELETE FROM tweets WHERE id = ?');
        $q->execute(array($id));
        Database::disconnect();
        header('Location: index.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Twitterbot</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div class="jumbotron">
        <div class="container">
            <h1>Twitterbot</h1>
            <p>A simple twitter bot script written in PHP.</p>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal" action="delete.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <p class="bg-danger alert">Are you sure to delete ?</p>
                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn btn-danger">Yes</button>
                            <a class="btn btn-default" href="index.php">No</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <hr>

        <footer>
            <p>&copy; Pinceladas da Web <?php echo date('Y'); ?></p>
        </footer>
    </div>
</body>
</html>
