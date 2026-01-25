<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>404 - <?php echo translate("tr_d8c4ec2305459f50cce4886c41a73a66"); ?></title>

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
    <img src="<?php echo $app->storage->path("images")->name("image-404.webp")->get(); ?>">
    <h2>404 - <?php echo translate("tr_d8c4ec2305459f50cce4886c41a73a66"); ?></h2>
    <div class="mt15" ><a class="btn-custom button-color-scheme2" href="<?php echo getHost(true); ?>"><?php echo translate("tr_5f8256eec9d799783ade21b422b9ded7"); ?></a></div>
</div>

</body>
</html>