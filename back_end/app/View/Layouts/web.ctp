<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Car Book</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="<?php echo $this->webroot ?>webhtml/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo $this->webroot ?>webhtml/css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="<?php echo $this->webroot ?>webhtml/css/fullcalendar.css" />
        <link rel="stylesheet" href="<?php echo $this->webroot ?>webhtml/css/matrix-style.css" />
        <link rel="stylesheet" href="<?php echo $this->webroot ?>webhtml/css/matrix-media.css" />

        <link href="<?php echo $this->webroot ?>webhtml/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?php echo $this->webroot ?>webhtml/css/style_custom.css" />
    </head>

    <?php echo $this->Flash->render(); ?>
    <?php echo $this->fetch('content'); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
    <script src="<?php echo $this->webroot ?>webhtml/js/jquery.min.js"></script>
    <script src="<?php echo $this->webroot ?>webhtml/js/jquery.ui.custom.js"></script>
    <script src="<?php echo $this->webroot ?>webhtml/js/bootstrap.min.js"></script>
    <script src="<?php echo $this->webroot ?>webhtml/js/matrix.js"></script>
    <script src="<?php echo $this->webroot ?>webhtml/js/jquery.loader.js"></script>

    <?php echo $this->element('script') ?>
    <?php echo $this->element('angualr') ?>
