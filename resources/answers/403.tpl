<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>

    <link href="https://fonts.googleapis.com/css?family=PT+Sans+Narrow" rel="stylesheet" type="text/css"/>
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400italic,400,700&subset=latin,cyrillic" rel="stylesheet" type="text/css">

    <?php echo $app->asset->getCss('web'); ?>

    <style type="text/css">
        .container{
            text-align: center;
            margin-top: 150px;
        }
        img{
            height: 256px; margin-bottom: 45px;
        }
        h2{
            font-weight: bold;
        }
    </style>

</head>
<body>

<div class="container" >
    <img src="<?php echo $app->storage->path("images")->name("access-job-site-png.png")->get(); ?>">
    <h2><?php echo $title; ?></h2>
    <p><?php echo $text; ?></p>
</div>

</body>
</html>