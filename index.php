<?php
    include_once("functions.php");

    //afficher($_GET);
    $class = isset($_GET['split']) ? $_GET['split'] : "train";

    if(!in_array($class, array("train", "val", "test"))){
        die('Error!');
    }
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
    <link rel="stylesheet" <?php echo "href=\"".substr($cssf, strlen("C:\wamp64\www\DS3PHPYM22021simohamedhdafa-2\\"))."\""; ?> >
    <?php } ?>

    <?php foreach($js_list_paths as $jsf){ ?>
    <script type="text/javascript" <?php echo "src=\"".substr($jsf, strlen("C:\wamp64\www\DS3PHPYM22021simohamedhdafa-2\\"))."\""; ?>></script>
    <?php } ?>
</head>
<body>

    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="true" href="<?php echo $_SERVER['PHP_SELF'] . "?split=train" ?>">Training</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $_SERVER['PHP_SELF'] . "?split=val" ?>">Validation</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $_SERVER['PHP_SELF'] . "?split=test" ?>" tabindex="-1" aria-disabled="true">Testing</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
        <?php 
            
            for($i=0; $i<100; $i++){
                //afficher($content[$i]);
                $k = key($content[$i]);
                $v = $content[$i][$k];
        ?>

        <div class="card mb-3" style="max-width: 840px;">
            <div class="row g-0">
                <div class="col-md-3">
                    <img src="<?php echo "\database\Images\\" . $k; ?>" class="img-thumbnail" alt="...">   
                </div>
                <div class="col-md-9">
                    <div class="card-body">
                        <p class="card-text"><?php echo $v[0]; ?></p>
                        <p class="card-text"><?php echo $v[1]; ?></p>
                        <p class="card-text"><?php echo $v[2]; ?></p>
                        <p class="card-text"><?php echo $v[3]; ?></p>
                        <p class="card-text"><?php echo $v[4]; ?></p>
                    </div>
                </div>
            </div>
        </div>    
            
        <?php } ?>
        </div>
    </div>
</body>
</html>