<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script> 
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script> 
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<!--<script language="javascript" src="../js/jquery-ui-1.8.16.custom.min.js"></script>
<script language="javascript" src="../js/jquery-ui-1.8.5.custom.min.js"></script>
--><script language="javascript" src="../js/jquery.ui.datepicker-es.js"></script>
<script language="javascript" src="../js/jquery.ui.datepicker.js"></script>
<script language="javascript" src="../SpryAssets/SpryMenuBar.js"></script>


<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../css/estilos.css" rel="stylesheet" type="text/css" />
<link href="../js/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<link href="../css/encabezados.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />

<!--	<link rel="stylesheet" href="http://jqueryui.com/themes/base/jquery.ui.all.css">
--><!--	<script src="http://jqueryui.com/jquery-1.6.2.js"></script>
-->	<script src="http://jqueryui.com/ui/jquery.ui.core.js"></script>
	<script src="http://jqueryui.com/ui/jquery.ui.widget.js"></script>
	<script src="http://jqueryui.com/ui/jquery.ui.button.js"></script>
<!--	<link href="http://jqueryui.com/demos/demos.css" rel="stylesheet" type="text/css">
-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<!--<script src="../js/jquery-1.4.2.min.js"></script>-->
<script type="text/javascript" src="../js/jquery.validity.pack.js"> </script>
<script src="../js/jquery.table.addrow.js"></script>
<script src="../js/jquery-ui-1.8.5.custom.min.js" language="javascript"></script>
<script src="../js/jquery.ui.datepicker-es.js" language="javascript"></script>
<script src="../js/jquery.infieldlabel.min.js" language="javascript"></script>


<link href="../js/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<link href="../css/form.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../css/menu_style.css" type="text/css" media="all" />
<link rel="stylesheet" type="text/css" href="../js/jquery.autocomplete.css" /> 
<link type="text/css" rel="Stylesheet" href="../js/jquery.validity.css" />
<link href="../css/redmond/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />


<script >
$(function() {
        var xOffset = 10;
        var yOffset = 20;

        $("input").focus(function(e) {
            this.t = this.title;
            this.title = "";
            $("#texto").append("<span id='tooltip'>" + this.t + "</span>");
            $("#tooltip").css("top", (e.pageY - xOffset) + "px").css("left", (e.pageX + yOffset) + "px").fadeIn("fast");
        });

        $("input").blur(function(e) {
            this.title = this.t;
            $("#tooltip").remove();

           // $("#tooltip").css("top", (e.pageY - xOffset) + "px").css("left", (e.pageX + yOffset) + "px");   
        });   
    });
	</script>