<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo translate("tr_70c884ebf8bb09be0910e4fb00a30b52"); ?></title>

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
    <img src="<?php echo $app->storage->path("images")->name("image-500.webp")->get(); ?>">
    <h2><?php echo translate("tr_70c884ebf8bb09be0910e4fb00a30b52"); ?></h2>
    <p><?php echo translate("tr_b473491325db1f3e942ba665b8988471"); ?></p>
    <div class="mt15" ><a class="btn-custom button-color-scheme2" href="<?php echo getHost(true); ?>"><?php echo translate("tr_5f8256eec9d799783ade21b422b9ded7"); ?></a></div>
</div>

</body>
</html>