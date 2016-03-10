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
        $tweetError = null;

        $tweet = $_POST['tweet'];
        $tweet = trim($tweet);
        $length = strlen(utf8_decode($tweet));

        $valid = true;
        if (empty($tweet)) {
            $tweetError = 'Please enter a tweet text.';
            $valid = false;
        } else if ($length > 140) {
            $tweetError = 'Your tweet exceeded limit of 140 caracthers.';
            $valid = false;
        }

        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $q = $pdo->prepare('UPDATE tweets set tweet = ? WHERE id = ?');
            $q->execute(array($tweet, $id));
            Database::disconnect();
            header('Location: index.php');
        }
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $q = $pdo->prepare('SELECT * FROM tweets where id = ?');
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $tweet = $data['tweet'];
        Database::disconnect();
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
                <form class="form-horizontal" action="update.php?id=<?php echo $id; ?>" method="post">
                    <div class="form-group <?php echo !empty($tweetError) ? 'has-error' : ''; ?>">
                        <label class="col-sm-1 control-label">Tweet</label>
                        <div class="controls col-sm-11">
                            <input class="form-control" name="tweet" type="text" maxlength="140" placeholder="Tweet text here" value="<?php echo !empty($tweet) ? $tweet : ''; ?>">
                            <?php if (!empty($tweetError)): ?>
                                <span class="help-block"><?php echo $tweetError;?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-1 col-sm-11">
                            <button type="submit" class="btn btn-success">Save</button>
                            <a class="btn btn-default" href="index.php">Back</a>
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
