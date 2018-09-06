<?php
/**
 * template_head_end.php
 *
 * Author: pixelcave
 *
 * (continue) The first block of code used in every page of the template
 *
 * The reason we separated template_head_start.php and template_head_end.php
 * is for enabling us to include between them extra plugin CSS files needed only in
 * specific pages
 *
 */
?>

    <!-- Bootstrap and OneUI CSS framework -->
    <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/css/bootstrap.min.css">
    <link rel="stylesheet" id="css-main" href="<?php echo $one->assets_folder; ?>/css/oneui.css">

    <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
    <!-- <link rel="stylesheet" id="css-theme" href="assets/css/themes/flat.min.css"> -->
    <?php if ($one->theme) { ?>
    <link rel="stylesheet" id="css-theme" href="<?php echo $one->assets_folder; ?>/css/themes/<?php echo $one->theme; ?>.min.css">
    <?php } ?>
    <!-- END Stylesheets -->
    <link href="comprobar/css.css" media="screen" rel="stylesheet" type="text/css" />
    <script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#email').blur(function(){

                    $('#Info').html('<img src="comprobar/loader.gif" alt="" />').fadeOut(1000);

                    var email = $(this).val();
                    var dataString = 'email='+email;

                    $.ajax({
                        type: "POST",
                        url: "comprobar/check_username_availablity.php",
                        data: dataString,
                        success: function(data) {
                            $('#Info').fadeIn(1000).html(data);
                            //alert(data);
                        }
                    });
                });
            });
        </script>

        <style>
          .thumb {
            height: 300px;
            border: 1px solid #000;
            margin: 10px 5px 0 0;
          }
        </style>

</head>
<body<?php if ($one->body_bg) { echo ' class="bg-image" style="background-image: url(\'' . $one->body_bg . '\');"'; } ?>>
