<!DOCTYPE html>
<html lang="en">
<head>
    <title>Twitterbot</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
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
                <?php
                    require "inc/twitter_credentials.php";
                    require "inc/Database.php";
                    require "vendor/autoload.php";

                    use Abraham\TwitterOAuth\TwitterOAuth;

                    $pdo = Database::connect();

                    $getTweets = $pdo->prepare("SELECT *, RAND() as rand FROM tweets ORDER BY rand LIMIT 1");
                    $getTweets->execute();

                    if($getTweets->rowCount() > 0) {
                        while ($row = $getTweets->fetch()) {
                            $tweet = $row['tweet'];
                        }

                        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
                        $content = $connection->get('account/verify_credentials');

                        $connection->post('statuses/update', array('status' => $tweet));

                        if ($connection->getLastHttpCode() === 200) {
                            echo '<p><strong>Your latest tweet:</strong> '. $tweet .'</p>'.PHP_EOL;
                        } else {
                            echo '<p><strong>Error:</strong> A problem ocurred. You filled your Twitter credentials correctly? Or walk abusing the Twitter API?</p>'.PHP_EOL;
                        }
                    } else {
                        echo '<p><strong>Error:</strong> You have no tweets registered in the database or not filled data connection properly.</p>'.PHP_EOL;
                    }

                    Database::disconnect();
                ?>
            </div>
        </div>

        <hr>

        <footer>
            <p>&copy; Pinceladas da Web <?php echo date('Y'); ?></p>
        </footer>
    </div>
</body>
</html>
