<?php
    include_once("functions.php");

    //afficher($_GET);
    $class = isset($_GET['split']) ? $_GET['split'] : "train";
    // Read JSON file
    $json = file_get_contents('database/dataset_flickr8k.json');

    //Decode JSON
    $json_data = json_decode($json,true);
    $json_data = current($json_data);
    //Print data

    //afficher($json_data[0]);

    $content = array();
    foreach($json_data as $annotation){
        assert(in_array($annotation['split'], array("train", "val", "test")));
        if($annotation['split'] == $class){
            $image = array();
            $image[$annotation['filename']] = array();

            // foreach $champ in $content :
            foreach($annotation['sentences'] as $sentence){
                array_push($image[$annotation['filename']], $sentence['raw']);
            }
            array_push($content, $image);
        }  
    }

    $css_list_paths = array();
    foreach (scandir(trim(__FILE__, "\index.php") . "\bootstrap-5.0.0-beta3-dist\css") as $filename) {
        $path = trim(__FILE__, "\index.php") . "\bootstrap-5.0.0-beta3-dist\css" . '\\' . $filename;
        if (is_file($path)) {
            //echo "<br />" . $path;
            array_push($css_list_paths, $path);
        }
    }

    $js_list_paths = array();
    foreach (scandir(trim(__FILE__, "\index.php") . "\bootstrap-5.0.0-beta3-dist\js") as $filename) {
        $path = trim(__FILE__, "\index.php") . "\bootstrap-5.0.0-beta3-dist\js" . '\\' . $filename;
        if (is_file($path)) {
            array_push($js_list_paths, $path);
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>image captioning</title>
    
    <?php foreach($css_list_paths as $cssf){ ?>
    <link rel="stylesheet" <?php echo "href=\"".substr($cssf, strlen("C:\wamp64\www\DS3PHPYM22021simohamedhdafa\\"))."\""; ?> >
    <?php } ?>

    <?php foreach($js_list_paths as $jsf){ ?>
    <script type="text/javascript" <?php echo "src=\"".substr($jsf, strlen("C:\wamp64\www\DS3PHPYM22021simohamedhdafa\\"))."\""; ?>></script>
    <?php } ?>
</head>
<body>
    <div class="container-md">
        <h1>Hellow yncrea!</h1>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="<?php echo $_SERVER['PHP_SELF'] . "?split=train" ?>">Training</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $_SERVER['PHP_SELF'] . "?split=val" ?>">Validation</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $_SERVER['PHP_SELF'] . "?split=test" ?>">Testing</a>
            </li>
        </ul>

        <?php afficher($content); ?>

    </div>
</body>
</html>