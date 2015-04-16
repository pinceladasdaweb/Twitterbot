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
                <p><a href="create.php" class="btn btn-success">Create tweet</a></p>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Tweet</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        require "../inc/Database.php";

                        $pdo = Database::connect();

                        $getTweets = $pdo->prepare('SELECT * FROM tweets ORDER BY id DESC');
                        $getTweets->execute();

                        if($getTweets->rowCount() > 0) {
                            while ($row = $getTweets->fetch()) {
                                echo '<tr>';
                                echo '<td>'. $row['tweet'] . '</td>' . PHP_EOL;
                                echo '<td>' . PHP_EOL;
                                echo '<a class="btn btn-success" href="update.php?id='.$row['id'].'">Update</a>' . PHP_EOL;
                                echo '<a class="btn btn-danger" href="delete.php?id='.$row['id'].'">Delete</a>' . PHP_EOL;
                                echo '</td>' . PHP_EOL;
                                echo '</tr>' . PHP_EOL;
                            }
                        } else {
                            echo '<tr>';
                            echo '<td>Nothing here...</td>' . PHP_EOL;
                            echo '<td>Nothing here...</td>' . PHP_EOL;
                            echo '</tr>';
                        }

                        Database::disconnect();
                    ?>
                    </tbody>
                </table>
            </div>
        </div>

        <hr>

        <footer>
            <p>&copy; Pinceladas da Web <?php echo date('Y'); ?></p>
        </footer>
    </div>
</body>
</html>
