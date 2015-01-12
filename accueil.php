<?php 

require_once('connexion.php'); 
include('./maclasse.php');
include('./MySQLExeption.php');

session_start(); 

if (isset($_POST['login']) && isset($_POST['pass'])){ 
	$login = addslashes($_POST['login']);

	$pass = addslashes(md5($_POST['pass'])); 

$verif_query=sprintf("SELECT * FROM users WHERE Login='$login' AND Password='$pass'");
echo $verif_query;
$verif = mysqli_query($db,$verif_query) or die(mysql_error());
$row_verif = mysqli_fetch_assoc($verif);
$utilisateur = mysqli_num_rows($verif);

	
	if ($utilisateur) {	
	
	    $_SESSION['authentification']; 
		
		// déclaration des variables de session
		$_SESSION['privilege'] = $row_verif['privilege']; 
		$_SESSION['nom'] = $row_verif['nom']; // Son nom
		$_SESSION['prenom'] = $row_verif['prenom']; // Son Prénom
		$_SESSION['login'] = $row_verif['login']; // Son Login
		$_SESSION['pass'] = $row_verif['pass']; // Son mot de passe 
		
		header("Location:accueil.php"); // redirection si OK
	}
	else {
	

		header("Location:index.php?erreur=login"); // redirection si utilisateur non reconnu
		
	}
}

 
 ?>

<html class="no-js"> 
    <head>
        <meta charset="utf-8">
   
        <title>FCT Partners</title>
        <meta name="description" content="">
        <meta name="" content="width=device-width">
        
       
        <link href='http://fonts.googleapis.com/css?family=Raleway:400,600,500,300,700' rel='stylesheet' type='text/css'>
        
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/templatemo_main.css">
    </head>
    <body>

        <div id="main-wrapper">
            <!--[if lt IE 7]>
                <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
            <![endif]-->

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center templatemo-logo margin-top-20">
                <h1 class="templatemo-site-title">
                    <a href="#">Think Parc software</a>
                </h1>
				
                <h3 class="templatemo-site-title">
                	by <a href="#"><span class="blue">FCT</span><span class="green"> Partners</span></a>
                </h3>
            </div>

            <div class="image-section">
                <div class="image-container">
					
                    <img src="images/logo.jpg" id="menu-img" class="main-img inactive" alt="FCT Partners">
                    <img src="images/zoom-bg-2.jpg" id="products-img" class="inactive" alt="Product stocks">
                    <img src="images/zoom-bg-3.jpg" id="services-img"  class="inactive" alt="Services">
                    <img src="images/zoom-bg-4.jpg" id="about-img" class="inactive" alt="Véhicules">
                    <img src="images/zoom-bg-5.jpg" id="contact-img" class="inactive" alt="Contact">
                    <img src="images/zoom-bg-6.jpg" id="company-intro-img" class="main-img inactive" alt="Company Intro">
                    <img src="images/zoom-bg-7.jpg" id="testimonials-img" class="main-img inactive" alt="Testimonials">
                </div>
            </div>

            <div class="container">
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-md-offset-2 col-lg-offset-2 templatemo-content-wrapper">
                    <div class="templatemo-content">
                        
                        <section id="menu-section" class="active">
                            <div class="row">
                                <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 margin-bottom-20">
                                    <a href="#products" class="change-section">
                                        <div class="black-bg btn-menu">
                                            <i class="fa fa-cubes"></i>
                                            <h2>stocks</h2>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 margin-bottom-20">
                                    <a href="#services" class="change-section">
                                        <div class="black-bg btn-menu">
                                            <i class="fa fa-car"></i>
                                            <h2>Véhicules</h2>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 margin-bottom-20">
                                    <a href="#about" class="change-section">
                                        <div class="black-bg btn-menu">
                                            <i class="fa fa-book"></i>
                                            <h2>Reporting</h2>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 margin-bottom-20">
                                    <a href="#contact" class="change-section">
                                        <div class="black-bg btn-menu">
                                            <i class="fa fa-legal"></i>
                                            <h2>Reparation</h2>
                                        </div>
                                    </a>
                                </div>
                            
                                <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 margin-bottom-20 pull-right">
                                    <a href="#company-intro" class="change-section">
                                        <div class="black-bg btn-menu">
                                            <h2>A propos de nous</h2>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 margin-bottom-20 text-center">
                                    <a href="#testimonials" class="change-section">
                                        <div class="black-bg btn-menu">
                                            <h2>Documents techniques</h2>
                                        </div>
                                    </a>
                                </div>
								</div>
								  <div class="text-center">
                                    <a href="deconnexion.php" class="change-section">
                                        <div class="black-bg btn-menu">
                                           <a href="index.php?erreur=logout" class="logout"> <h3>Deconnexion</h3></a>
                                        </div>
                                    </a>
                                
                              
                            </div>
                        </section><!-- /.menu-section -->    
                        <section id="products-section" class="inactive" >
                            
                            <div class="row">
                                <div class="black-bg col-sm-12 col-md-12 col-lg-12">
                                    <h2 class="text-center">Gestions des stocks</h2>
                                    
                                    <div class="col-sm-12 col-md-12">
                                        <p>Cette espace vous permet de gérer les <a href="Reparation.html">stocks</a> de produits. Il vous permet aussi les consulter</p>
                                    </div>
                                    
                                 	<div class="col-xs-7 col-sm-4 col-md-4 col-lg-4 ">
                                    <a href="Reparation.html" class="change-section">
                                        <div class="black-bg btn-menu">
                                            <i class="fa fa-cubes"></i>
                                            <h2>Stock</h2>
                                        </div>
                                    </a>
                                </div>
							
									<div class="col-xs-7 col-sm-4 col-md-4 col-lg-4 ">
                                    <a href="Garages.html" class="change-section">
                                        <div class="black-bg btn-menu">
                                            <i class="fa fa-cubes"></i>
                                            <h2>Consultation</h2>
                                        </div>
                                    </a>
                                </div>
						

                              
                                    
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="row margin-top-20">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6  pull-right">
                                    <a href="#menu" class="change-section">
                                        <div class="black-bg btn-menu">
                                            <h2>Back to menu</h2>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </section><!-- /.contact-section -->    
                        <section id="services-section" class="inactive">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-sm-12 col-md-12 col-lg-12 black-bg">
                                        <h2><span class="green"><a href="">Parc Automobile</a></span></h2>
                                        <p>Utiliser ce module pour gérer les véhicules de votre parc automobile.</p>
                
                                    </div>
                                </div>
                            </div>
                            <div class="row margin-top-20">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6  pull-right">
                                    <a href="#menu" class="change-section">
                                        <div class="black-bg btn-menu">
                                            <h2>Retour to menu</h2>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </section><!-- /.services-section -->    
                        <section id="about-section" class="inactive">
                            <div class="row">
                                <div class="black-bg col-sm-12 col-md-12 col-lg-12">
                                    <h2 class="text-center"><span class="green"><a href="">Reporting</a></span></h2>
                                    <div class="col-sm-6 col-md-6">
                                        <p>Présentation des rapports et bilans analytiques sur les activités et résultats.</p>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="row margin-top-20">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6  pull-right">
                                    <a href="#menu" class="change-section">
                                        <div class="black-bg btn-menu">
                                            <h2>Retour to menu</h2>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </section><!-- /.about-section -->    
                        <section id="contact-section" class="inactive">
                            <div class="row">
                                <div class="black-bg col-sm-12 col-md-12 col-lg-12">
                                    <h2 class="text-center">Reparations</h2>
                                    
                                    <div class="col-sm-12 col-md-12">
                                        <p>Cette espace vous permet de gérer les <a href="Reparation.html">réparations</a> des véhicules. Il vous permet aussi de consulter les informations des différents <a href="Garages.html">garages</a>, ainsi que les <a href="PieceRechange.html">pièces de rechanges</a> disponibles. Enfin, vous pouvez accéder aux <a href="Entretiens.html">carnet d'entretiens</a> de ceux-ci</p>
                                    </div>
                                    
                                 	<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 ">
                                    <a href="Reparation.html" class="change-section">
                                        <div class="black-bg btn-menu">
                                            <i class="fa fa-cubes"></i>
                                            <h2>Reparations</h2>
                                        </div>
                                    </a>
                                </div>
									<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 ">
                                    <a href="Garages.html" class="change-section">
                                        <div class="black-bg btn-menu">
                                            <i class="fa fa-cubes"></i>
                                            <h2>Garages</h2>
                                        </div>
                                    </a>
                                </div>
								<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 ">
                                    <a href="PieceRechange.html" class="change-section">
                                        <div class="black-bg btn-menu">
                                            <i class="fa fa-cubes"></i>
                                            <h2>Pièces de rechanges</h2>
                                        </div>
                                    </a>
                                </div>
								<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 ">
                                    <a href="Entretiens.html" class="change-section">
                                        <div class="black-bg btn-menu">
                                            <i class="fa fa-cubes"></i>
                                            <h2>Entretiens</h2>
                                        </div>
                                    </a>
                                </div>

                              
                                    
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="row margin-top-20">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6  pull-right">
                                    <a href="#menu" class="change-section">
                                        <div class="black-bg btn-menu">
                                            <h2>Back to menu</h2>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </section><!-- /.contact-section -->    
                        <section id="company-intro-section" class="inactive">
                            <div class="row">
                                <div class="black-bg col-sm-12 col-md-12 col-lg-12">
                                    <h2 class="text-center">Company Intro</h2>
                                    <div class="col-sm-12 col-md-12">
								<p>Bienvenue sur Think Parc, logiciel de gestion de stock et de parc automobile</p>  </div>
                                </div>
                            </div>
                            <div class="row margin-top-20">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6  pull-right">
                                    <a href="#menu" class="change-section">
                                        <div class="black-bg btn-menu">
                                            <h2>Retour au menu</h2>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </section><!-- /.company-intor-section -->    
                        <section id="testimonials-section" class="inactive">
                            <div class="row">
                                <div class="black-bg col-sm-12 col-md-12 col-lg-12">
                                    
                                    <h2 class="text-center">Documents techniques</h2>
                                    <div class="col-sm-12 col-md-12">
										<p> Vous trouverez dans cette rubrique, tous les documents techniques nécessaire à la prise en main du logiciel</p>
										</div>

                                </div>
                            </div>
                            <div class="row margin-top-20">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6  pull-right">
                                    <a href="#menu" class="change-section">
                                        <div class="black-bg btn-menu">
                                            <h2>Retour au menu</h2>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </section><!-- /.company-intor-section -->    

                        
                    </div><!-- /.templatemo-content -->  
                </div><!-- /.templatemo-content-wrapper --> 
            </div><!-- /.row --> 

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 footer">
                    <p class="footer-text">Copyright &copy; 2015 FCT Partners</p>
                </div><!-- /.footer --> 
            </div>

		</div><!-- /#main-wrapper -->
        
        <div id="preloader">
            <div id="status">&nbsp;</div>
        </div><!-- /#preloader -->
        
        <script src="js/jquery.min.js"></script>
        <script src="js/jquery-ui.min.js"></script>
        <script src="js/jquery.backstretch.min.js"></script>
        <script src="js/templatemo_script.js"></script>

    </body> 
</html>