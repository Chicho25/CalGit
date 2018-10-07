<?php
  ob_start();
  session_start();
  $hideLeft = true;
  include("include/config.php");
  include("include/defs.php");
  $loggdUType = current_user_type();

  include("header.php");

  if(!isset($_SESSION['USER_ID']))
     {
          header("Location: index.php");
          exit;
     }

 ?>

 <section id="content">
         <section class="vbox">
           <section class="scrollable padder">
             <section class="panel panel-default">
               <header class="panel-heading">
                  <span class="h4">Principal</span>
               </header>
               <div class="panel-body">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="panel b-a">
                      <div class="row m-n">
                      </div>
                    </div> 
                  </div>
                </div>
               </div>
             </section>
           </section>
       </section>
   </section>
<?php  include("footer.php"); ?>
