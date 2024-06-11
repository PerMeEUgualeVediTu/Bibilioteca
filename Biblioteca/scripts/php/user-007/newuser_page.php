<?php
$USERFILE_P1 = <<<'PIPPOBAUDOEROENAZIONALE'
<?php
include $_SERVER['DOCUMENT_ROOT'] . "/scripts/php/head.php";
$USER = "
PIPPOBAUDOEROENAZIONALE;

$USERFILE_P2 = <<<'PIPPOBAUDOEROENAZIONALE'
";

try {
    include $_SERVER['DOCUMENT_ROOT'] . "/scripts/php/config.php";
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT User_name, User_icon, Description, Register_date, Access_level FROM Users WHERE User_name='" . $USER . "'";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
} catch(PDOException $error) 
{ echo "error page not existing<br>"; }

if ( ! ( $result && $statement->rowCount() > 0 ) ) {
	echo "error occured empty query<br>";
}
?>

<head>
    <link rel="stylesheet" href="/stylesheets/person.css">
</head>

<body>
<section>
    <div class="info">
        <h1><?php echo "Welcome to the page of " . $USER; ?></h1>
        <img src="<?php echo hash("MD5",$USER . "profile image"); ?>" alt="Profile Picture">
    </div>
    <div class="info">
        <div class="Description">
            <h2>Description</h2>
            <p><?php echo $result[0]['Description']; ?></p>
        </div>
        <div class="Register_date">
            <h2>This user is active since: </h2>
            <p><?php echo date("Y F d",$result[0]['Register_date']); ?></p>
        </div>
        <div class="Access_level">
            <h2>This user as acces level: </h2>
            <p><?php echo $result[0]['Access_level']; ?></p>
        </div>
    </div>
</section>
</body>

<?php
    $PFOLDER = $_SERVER['DOCUMENT_ROOT'] . "/people";
    $files = scandir($PFOLDER);
    $PEOPLES = [];

    $i = 0;
    foreach ($files as $file) {
        if(is_dir($file) and $file != "." && $file != "..") {
            $PEOPLES += [ $i => $file];
            $i ++;
        }
    }
        
    echo "<div class='users'>";
    foreach ($PEOPLES as $USR) {
        echo "<a href='/people/$USR' class='user'><div>";
        $ICON = hash("MD5",$USR . "profile image");
        echo "<img src='" . $USR . "/" . $ICON . "' alt='" . $USR . "'>";
        echo "<h2>$USR</h2>";
        echo "</div></a>";
    }
    echo "</div>";
?>
PIPPOBAUDOEROENAZIONALE;
?>