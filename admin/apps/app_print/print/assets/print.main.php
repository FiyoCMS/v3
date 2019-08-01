<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');


?>
<html>
    <head>
        <title>
            Fiyo Report
        </title>

        <link rel="stylesheet" href="<?php echo  "apps/app_print/print/" .basename(__dir__); ?>/print.template.css">
        <style>

        </style>
        
        <script src="<?php echo AdminPath; ?>/js/jquery.min.js"></script>        
        <script src="<?php echo AdminPath; ?>/js/jquery-print.js"></script>
        <script>
        
            $(function() {
                $(".print-now").click(function () {
                    $("#print-it").print(/*options*/);
                });
                $(".zoom-1").click(function () {
                    $(".wrapper").animate({ 'zoom': 1.2 }, 200);
                });
                $(".zoom-2").click(function () {
                    
                    $(".wrapper").animate({ 'zoom': 1.5 }, 200);
                });
                $(".zoom-0").click(function () {
                    $(".wrapper").animate({ 'zoom': 1 }, 200);
                });

            });

        </script>
    </head>
    <body>
        <div id="controller">
            <span class="zoomer"><a class="zoom-0">Normal</a>
            <a class="zoom-1">Zoom (x1)</a>
            <a class="zoom-2">Zoom (x2)</a>
        </span>
            <a class="print-now right"><img height="12" src="data:image/svg+xml;base64,
PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHg9IjBweCIgeT0iMHB4IiB2aWV3Qm94PSIwIDAgNDgyLjUgNDgyLjUiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDQ4Mi41IDQ4Mi41OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjUxMiIgaGVpZ2h0PSI1MTIiIGNsYXNzPSIiPjxnPjxnPgoJPGc+CgkJPHBhdGggZD0iTTM5OS4yNSw5OC45aC0xMi40VjcxLjNjMC0zOS4zLTMyLTcxLjMtNzEuMy03MS4zaC0xNDkuN2MtMzkuMywwLTcxLjMsMzItNzEuMyw3MS4zdjI3LjZoLTExLjMgICAgYy0zOS4zLDAtNzEuMywzMi03MS4zLDcxLjN2MTE1YzAsMzkuMywzMiw3MS4zLDcxLjMsNzEuM2gxMS4ydjkwLjRjMCwxOS42LDE2LDM1LjYsMzUuNiwzNS42aDIyMS4xYzE5LjYsMCwzNS42LTE2LDM1LjYtMzUuNiAgICB2LTkwLjRoMTIuNWMzOS4zLDAsNzEuMy0zMiw3MS4zLTcxLjN2LTExNUM0NzAuNTUsMTMwLjksNDM4LjU1LDk4LjksMzk5LjI1LDk4Ljl6IE0xMjEuNDUsNzEuM2MwLTI0LjQsMTkuOS00NC4zLDQ0LjMtNDQuM2gxNDkuNiAgICBjMjQuNCwwLDQ0LjMsMTkuOSw0NC4zLDQ0LjN2MjcuNmgtMjM4LjJWNzEuM3ogTTM1OS43NSw0NDcuMWMwLDQuNy0zLjksOC42LTguNiw4LjZoLTIyMS4xYy00LjcsMC04LjYtMy45LTguNi04LjZWMjk4aDIzOC4zICAgIFY0NDcuMXogTTQ0My41NSwyODUuM2MwLDI0LjQtMTkuOSw0NC4zLTQ0LjMsNDQuM2gtMTIuNFYyOThoMTcuOGM3LjUsMCwxMy41LTYsMTMuNS0xMy41cy02LTEzLjUtMTMuNS0xMy41aC0zMzAgICAgYy03LjUsMC0xMy41LDYtMTMuNSwxMy41czYsMTMuNSwxMy41LDEzLjVoMTkuOXYzMS42aC0xMS4zYy0yNC40LDAtNDQuMy0xOS45LTQ0LjMtNDQuM3YtMTE1YzAtMjQuNCwxOS45LTQ0LjMsNDQuMy00NC4zaDMxNiAgICBjMjQuNCwwLDQ0LjMsMTkuOSw0NC4zLDQ0LjNWMjg1LjN6IiBkYXRhLW9yaWdpbmFsPSIjMDAwMDAwIiBjbGFzcz0iYWN0aXZlLXBhdGgiIHN0eWxlPSJmaWxsOiNGQkY5RjkiIGRhdGEtb2xkX2NvbG9yPSIjRThEQ0RDIj48L3BhdGg+CgkJPHBhdGggZD0iTTE1NC4xNSwzNjQuNGgxNzEuOWM3LjUsMCwxMy41LTYsMTMuNS0xMy41cy02LTEzLjUtMTMuNS0xMy41aC0xNzEuOWMtNy41LDAtMTMuNSw2LTEzLjUsMTMuNVMxNDYuNzUsMzY0LjQsMTU0LjE1LDM2NC40ICAgIHoiIGRhdGEtb3JpZ2luYWw9IiMwMDAwMDAiIGNsYXNzPSJhY3RpdmUtcGF0aCIgc3R5bGU9ImZpbGw6I0ZCRjlGOSIgZGF0YS1vbGRfY29sb3I9IiNFOERDREMiPjwvcGF0aD4KCQk8cGF0aCBkPSJNMzI3LjE1LDM5Mi42aC0xNzJjLTcuNSwwLTEzLjUsNi0xMy41LDEzLjVzNiwxMy41LDEzLjUsMTMuNWgxNzEuOWM3LjUsMCwxMy41LTYsMTMuNS0xMy41UzMzNC41NSwzOTIuNiwzMjcuMTUsMzkyLjZ6IiBkYXRhLW9yaWdpbmFsPSIjMDAwMDAwIiBjbGFzcz0iYWN0aXZlLXBhdGgiIHN0eWxlPSJmaWxsOiNGQkY5RjkiIGRhdGEtb2xkX2NvbG9yPSIjRThEQ0RDIj48L3BhdGg+CgkJPHBhdGggZD0iTTM5OC45NSwxNTEuOWgtMjcuNGMtNy41LDAtMTMuNSw2LTEzLjUsMTMuNXM2LDEzLjUsMTMuNSwxMy41aDI3LjRjNy41LDAsMTMuNS02LDEzLjUtMTMuNVM0MDYuNDUsMTUxLjksMzk4Ljk1LDE1MS45eiIgZGF0YS1vcmlnaW5hbD0iIzAwMDAwMCIgY2xhc3M9ImFjdGl2ZS1wYXRoIiBzdHlsZT0iZmlsbDojRkJGOUY5IiBkYXRhLW9sZF9jb2xvcj0iI0U4RENEQyI+PC9wYXRoPgoJPC9nPgo8L2c+PC9nPiA8L3N2Zz4=" /> 
Print</a>

        </div>
        <div class="wrapper">
            <div id="print-it" contenteditable="true">           
                <?php foreach( $pages as $data) include("print.page.php"); ?>
            </div>
        </div>
    </body>
</html>