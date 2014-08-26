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
                <?php
                    require_once('./connection.php');
                    require_once('./oauth/twitteroauth.php');

                    try {
                        $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME, DB_USER, DB_PASSWORD);

                        $getTweets = $db->prepare("SELECT *, RAND() as rand FROM tweets ORDER BY rand LIMIT 1");
                        $getTweets->execute();

                        while ($row = $getTweets->fetch()) {
                            $tweet = $row['tweet'];
                        }

                        $size = count($tweet);

                        if ($size > 0) {
                            $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
                            $content = $connection->get('account/verify_credentials');

                            $connection->post('statuses/update', array('status' => $tweet));

                            echo '<p><strong>Your latest tweet:</strong> '. $tweet .'</p>'.PHP_EOL;
                        } else {
                            echo '<p><strong>Error</strong> - You have no tweets registered in the database or not filled data connection properly.</p>'.PHP_EOL;
                        }

                        $db = null;
                    } catch(PDOException $e) {
                        echo $e->getMessage();
                    }
                ?>
            </div>
        </div>

        <hr>

        <footer>
            <p>&copy; Pinceladas da Web 2014</p>
        </footer>
    </div>
</body>
</html>
