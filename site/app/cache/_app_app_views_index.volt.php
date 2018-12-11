<!DOCTYPE html>
<html>
<head>
    <title>Vendinha</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons' rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    
    <style>
        [v-cloak] {
            display: none;
        }
    </style>
</head>
<body>


    
    <?= $this->getContent() ?>


<?php if (constant('APP_ENV') === 'prod') { ?>
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
<?php } else { ?>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<?php } ?>
<script src="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.js"></script>


    

    <?php if (isset($templateAfter)) { ?>
        <?php $this->partial(($templateAfter)); ?>
    <?php } ?>

    <?php $this->partial(('firebase')); ?>



</body>
</html>