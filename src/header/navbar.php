<?php if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1') {
   $path = '/projects/ThinkParc-WEB/';
   } else {
   $path = '/';
   }
   ?>
<div>
   <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
         <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">FCT</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <a href="<?php echo $path; ?>src/accueil.php" class="btn btn-sm"><button type="button" class="btn btn-default navbar-btn">Accueil</button></a>
         </div>
         <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
               <li class="hidden-xs"><img style="height:40px; width:auto;" src="<?php echo $path; ?>images/logoentreprise.jpg" class="btn btn-xs"></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
               <li class="hidden-xs"><img style="height:40px; width:auto;" src="<?php echo $path; ?>images/logofct.png" class="btn btn-sm"></li>
               <li><a href="<?php echo $path; ?>src/infos/myinformations.php" class="btn btn-sm btn-link"><span class="glyphicon glyphicon-list-alt"></span> Mes informations</a></li>
               <li><a href="<?php echo $path; ?>src/exit/exit.php" class="btn btn-sm btn-danger">Deconnexion <span class="glyphicon glyphicon-off"></span></a></li>
            </ul>
         </div>
      </div>
   </nav>
</div>