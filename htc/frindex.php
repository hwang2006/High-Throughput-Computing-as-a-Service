<?php


  # -----------------------------------------------------------
  # For AMGCC13 (August 5. 2013.)
  #  redirect  requst  /index.php/AMGCC13  to the wiki page
  $ruri = $_SERVER['REQUEST_URI'];
  if ($ruri == '/index.php/AMGCC13') {
    header("Location: /wiki/index.php/AMGCC13");
    exit;
  }
  # -----------------------------------------------------------

  $wikiurl = "/wiki";

  print<<<EOS
  
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">

<meta name="google-translate-customization" content="91f4db61192164d1-e9dd12c7d070fe59-g44bc32ae9fe9dac2-13"></meta>   


<head>

	<title>HTC-as-a-Service, KISTI</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	

	<div id="google_translate_element"></div><script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.FloatPosition.TOP_RIGHT}, 'google_translate_element');
}
</script>
<!--<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script> -->
	
	<meta name="Description" content="" />
	<meta name="Keywords" content="" />
				
				<link rel="stylesheet" href="css/index.css" type="text/css" media="screen, projection" />
				<link rel="stylesheet" href="css/wide.css" type="text/css" media="screen" />
				
					
			
<!--				<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
				<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js?ver=3.3.1'></script>
				<script type='text/javascript' src='http://maps.google.com/maps/api/js?sensor=false&amp;ver=3'></script>
				<script src="js/jquery.cycle.all.js" type="text/javascript"></script>
				<script type="text/javascript" src="js/superfish.js?ver=3.3.1"></script> -->
			<!--<script type="text/javascript" src="js/smthemes.js?ver=645"></script> -->
			
			<!--[if lt IE 9]>
						<link rel="stylesheet" href="css/ie.css" type="text/css" media="screen and (min-width:1024px)" />
					<![endif]-->
				

				<link rel="stylesheet" href="style.css" type="text/css" media="screen, projection" />
				<link rel="stylesheet" href="css/wide.css" type="text/css" media="screen and (min-width:1024px)" />
				<link rel="stylesheet" href="css/index.css" type="text/css" media="screen and (min-width:1024px)" />
				
				<link rel="stylesheet" href="css/mobile.css" type="text/css" media="screen and (min-width:240px) and (max-width:639px)" />
				<link rel="stylesheet" href="css/tablet.css" type="text/css" media="screen and (min-width:640px) and (max-width:1023px)" />
				<link rel="stylesheet" href="css/shortcode.css?7791" type="text/css" media="screen, projection" />
				<meta name='robots' content='' />
				<link rel="alternate" type="application/atom+xml" title="HTC-as-a-Service, KISTI Atom feed" href="$wikiurl/index.php?title=Special:RecentChanges&amp;feed=atom" />
				<link rel="search" type="application/opensearchdescription+xml" href="/opensearch_desc.php" title="HTC-as-a-Service, KISTI (en)" />
				<link rel="EditURI" type="application/rsd+xml" href="$wikiurl/api.php?action=rsd" />
				<meta name="generator" content="WordPress 3.3.1" />
				<link rel="alternate" type="application/atom+xml" title="HTC-as-a-Service, KISTI Atom feed" href="/index.php?title=Special:RecentChanges&amp;feed=atom" />
				<meta name="ResourceLoaderDynamicStyles" content="" />
				<link rel="shortcut icon" href="images/icon2.ico" type="image/x-icon" />
				
				
				<script type="text/javascript">
				jQuery(document).ready(function() {

												jQuery(document).ready(function() {
					jQuery('.fp-slides').cycle({
						fx: 'fade',
						timeout: 3000,
						delay: 0,
						speed: 3000,
						next: '.fp-next',
						prev: '.fp-prev',
						pager: '.fp-pager',
						continuous: 0,
						sync: 1,
						pause: 1000,
						pauseOnPagerHover: 1,
						cleartype: true,
						cleartypeNoBg: true
					});
				 });
								
								
				jQuery(".menus .children").addClass('sub-menu');
					if ( jQuery(document).width() > 100 ) jQuery(function(){ 
						jQuery('ul.menus').superfish({ 
							animation: {width:'show'},					
							autoArrows:  true,
							dropShadows: false, 
							speed: 50,
							delay: 500                
							});
						});
								
						jQuery('textarea#comment').each(function(){
							jQuery(this).attr('name','78e6f');
						});
					
					
						jQuery('.feedback input').each(function(){
							jQuery(this).attr('name','78e6f['+jQuery(this).attr('name')+']');
						});
					
					
						jQuery('.feedback textarea').each(function(){
							jQuery(this).attr('name','78e6f['+jQuery(this).attr('name')+']');
						});
				});
			</script>
			
			

			
		
			

	
	<!-- ///////////////////EVENT CALENDAR/////////////////////////// -->


	<!-- Core CSS File. The CSS code needed to make eventCalendar works -->
	<link rel="stylesheet" href="event/css/eventCalendar.css">

	<!-- Theme CSS file: it makes eventCalendar nicer -->
	<link rel="stylesheet" href="event/css/eventCalendar_theme_responsive.css">


	
</head>



<body class="home blog  content-r" layout='2'>

	<div id="all">
		
		<div id='header-block'>
		
			
			
			<div id='mainmenu-container'>
				<div id="logo">
					<a href=''><img src='images/htcaas.png' class='logo' alt='HTCaaS' title="HTCaaS" /></a>						
				</div>
				<div id='mainmenu'>
					<div class="menu-primary-container">
						<ul class="menus menu-primary">
							<li class="current_page_item"><a href="">High-Throughput Computing as a Service</a></li>							
						</ul>
					</div>
					<div id="lang-cont">
						
						<a href="$wikiurl" class="lang"><img src="images/mediawiki.png" />Go to Wiki</a>
						
						<a href="frindex.php" class="lang"><img src="images/flags/fr.png" />Français</a>
						
						
						<a href="index.php" class="lang"><img src="images/flags/eng.png" />English</a>
						
					</div>
					
				</div>
						
			</div>
			
			
			<div div='floatdiv' class='slider-container' style="min-width: 1024px;">
				<div class='slider-bgr'>
				</div>
				<div class="slider">
					<div class="fp-slides">
						<div class="fp-slides-items fp-first">
							<div class="fp-thumbnail">
								<a href="" title=""><img src="images/slides/1.jpg" alt="Slide # 1" /></a>
							</div>
							<div class="fp-content-wrap">
								<div class="fp-content-fon">
								</div>
								<div class="fp-content">
									<h3 class="fp-title"><a href="" title="">Slide # 1</a></h3><br/>
									<p>HTCaaS, a system that can hide heterogeneity and complexity of leveraging different computing resources from users, and efficiently submit a large number of jobs at once. 
									</p>
								</div>
							</div>
						</div>
						<div class="fp-slides-items">
							<div class="fp-thumbnail">
								<a href="" title=""><img src="images/slides/2.jpg" alt="Slide # 2" /></a>
							</div>
							<div class="fp-content-wrap">
								<div class="fp-content-fon">
								</div>
								<div class="fp-content">
									<h3 class="fp-title"><a href="" title="">Slide # 2</a></h3><br/>
									<p>
									<a class="fp-more" href="">HTCaaS, a system that can hide heterogeneity and complexity of leveraging different computing resources from users, and efficiently submit a large number of jobs at once. 
									</a>
									</p>
								</div>
							</div>
						</div>
						<div class="fp-slides-items">
							<div class="fp-thumbnail">
								<a href="" title=""><img src="images/slides/3.jpg" alt="Slide # 3" /></a><br/>
							</div>
							<div class="fp-content-wrap">
								<div class="fp-content-fon">
								</div>
								<div class="fp-content">
									<h3 class="fp-title"><a href="" title="">Slide # 3</a></h3><br/>
									<p>
									<a class="fp-more" href="">HTCaaS, a system that can hide heterogeneity and complexity of leveraging different computing resources from users, and efficiently submit a large number of jobs at once. 
									</a>
									</p>
								</div>
							</div>
						</div>						
						
					</div>
					
					
					<div class="fp-prev-next-wrap">
						<div class="fp-prev-next">
							<a href="?preview=1&amp;template=onion&amp;stylesheet=onion#fp-next" class="fp-next"></a>
							<a href="?preview=1&amp;template=onion&amp;stylesheet=onion#fp-prev" class="fp-prev"></a>
						</div>
					</div>
					<div class="fp-nav">
						<span class="fp-pager">&nbsp;</span>
					</div>  
					<div class='bground'>
					</div>
				</div>
				
			</div>		
		</div>
		
		


<div id='content-top' class='container'>
</div>
<div id='cont'>


	<div class='container clearfix'>
	

			
		<div class='sidebar right clearfix'>
			<div id="search-0" class="widget widget_search"><div class="inner"> 
				<div class="searchform" title="">
					<form method=get action="http://www.google.com/custom" class="google_form">
					
						<input type='submit' value='' class='searchbtn' />
						<input type="text" class="google_box" value="Search" class='searchtxt' 
							name="q" id="s"  onblur="if (this.value == '')  {this.value = 'Search';}"  
							onfocus="if (this.value == 'Search') {this.value = '';}" 
						/>
						<input type=hidden name=domains value="htcaas.kisti.re.kr">
						<input type=hidden name=sitesearch value="htcaas.kisti.re.kr" checked >
						<input type=hidden name=meta value="lr=lang_en">
					<div style='clear:both'>
					</div>
					</form>
				</div><!-- #search --></div></div>	
				
				
				<div id="posts-0" class="widget widget_posts">
					<div class="inner">        
						<div class="caption">
						<h3>Contenu</h3>
						</div>            
						<!-- <ul>
        	                <li>
								<span class='date'><span class='day'>23</span><br />April</span>
						        <img width="56" height="56" src="" class="attachment-56x56 wp-post-image" alt="Paged Post" title="Paged Post" />                          <a href="http://smthemes.com/demowp/?p=95&amp;preview=1&amp;template=onion&amp;stylesheet=onion" rel="bookmark" title="Paged Post">Paged Post</a>						<p class="withdate"><p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts...</p></p>                    </li>
                            <li>
								<span class='date'><span class='day'>10</span><br />April</span>
						        <img width="56" height="56" src="" class="attachment-56x56 wp-post-image" alt="The Post with Featured Image" title="The Post with Featured Image" />                          <a href="http://smthemes.com/demowp/?p=76&amp;preview=1&amp;template=onion&amp;stylesheet=onion" rel="bookmark" title="The Post with Featured Image">The Post with Featured Image</a>						<p class="withdate"><p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts...</p></p>                    </li>
                            <li>
								<span class='date'><span class='day'>5</span><br />April</span>
						        <a href="" rel="bookmark" title="Formatting of Text Columns or Messages with Highlight">Formatting of Text Columns or Messages with Highlight</a>						<p class="withdate"><p>SMT post editor additional features can divide the text of your post into columns.  Use the   button on the post editi...</p></p>                    </li>
                            <li>
								<span class='date'><span class='day'>5</span><br />April</span>
						        <a href="" rel="bookmark" title="The Post with Buttons and Tool Tips">The Post with Buttons and Tool Tips</a>						<p class="withdate"><p>SMT Post editior allows you to design links in your posts in the form of buttons and tool tips for any elements of the p...</p></p>                    </li>
                            <li>
								<span class='date'><span class='day'>5</span><br />April</span>
						         <a href="" rel="bookmark" title="The Post with Video">The Post with Video</a>						<p class="withdate"><p>You can easily copy and paste videos from YouTube.com and Vimeo.com using the SMT post editor...</p></p>                    </li>
                        </ul> -->
						<div id="tabs-0" class="widget widget_tabs">
							<div class="inner">        			
								<div class='tabs_contents'>
									
										<div class="inner">
											<ul>
											<li class="cat-item cat-item-19"><a href="#HTCaaS" title="">A propos de l'HTCaaS</a></li>
											<li class="cat-item cat-item-10"><a href="#System" title="">Architecture et composants systeme</a></li>
											<li class="cat-item cat-item-18"><a href="#Publications" title="">Publications</a></li>
											<li class="cat-item cat-item-18"><a href="#Publications" title="">Presentations techniques</a></li>
											</ul>
									</div>
									
											
								</div>
				
								<div style='clear:both'>
								</div>
							</div>
						</div>               
					</div>
				</div>               
				
				<div id="comments-0" class="widget widget_comments">
					<div class="inner">        
						<div class="caption">
							<h3>Evénement en cours</h3>
						</div>            
						<ul>
						<li>
                                <div class='avatar' style='width:32px'><img alt='' src='images/content/mini_workshop.jpg' class='avatar avatar-32 photo' height='32' width='32' />
								</div> 
								<span class='comment'><strong>HTCaaS workshop</strong> <a target='_blank' rel='noopener noreferrer' href='$wikiurl/index.php/Mini_htcaas_workshop13'>Mini Workshop: developpement du HTCaaS pour PLSI</span></a></li>
                             
                            <li>
                                <div class='avatar' style='width:32px'><img alt='' src='images/content/currentevent-prev.jpg' class='avatar avatar-32 photo' height='32' width='32' />
								</div> 
								<span class='comment'><strong>AMGCC13</strong> <a target='_blank' rel='noopener noreferrer' href='$wikiurl/index.php/AMGCC13'>The 1st International Workshop on Autonomic Management of Grid and Cloud Computing</span></a></li>
                              </ul>
					</div>
				</div>    
				
				
				<div id="videofeed-0" class="widget widget_videofeed">
					<div class="inner">			
						<div class="caption">
							<h3>Telechargements & Demos</h3>
						</div>
						<div id="categories-2" class="tab_widget widget_categories">
						<div class="inner">
							<span class="scaption">HTCaaS CLI</span>		
							<ul>
							<li class="cat-item cat-item-19"><a href="$wikiurl/index.php/CLI-Tutorial" title="">Tutoriaux & Manuel</a>
							</li>
							<li class="cat-item cat-item-19"><a href="$wikiurl/index.php/CLI-Download" title="">Telechargements</a>
							</li>
							<li class="cat-item cat-item-19"><a href="$wikiurl/index.php/CLI-Demo" title="">Demo</a>
							</li>
							<li class="cat-item cat-item-19"><a href="$wikiurl/index.php/Images" title="">Images</a>
							</li>
							</ul>
						</div>
						</div>       
						<div id="categories-2" class="tab_widget widget_categories">
						<div class="inner">
							<span class="scaption">HTCaaS GUI</span>		
							<ul>
							<li class="cat-item cat-item-19"><a href="$wikiurl/index.php/GUI-Tutorial" title="">Tutoriaux & Manuel</a>
							</li>
							<li class="cat-item cat-item-19"><a href="$wikiurl/index.php/GUI-Download" title="">Telechargements</a>
							</li>
							<li class="cat-item cat-item-19"><a href="$wikiurl/index.php/GUI-Demo" title="">Demo</a>
							</li>
							<li class="cat-item cat-item-19"><a href="$wikiurl/index.php/GUI-Images" title="">Images</a>
							</li>
							</ul>
						</div>
						</div>     	
					</div>
				</div>
				
				
				<div id="videofeed-0" class="widget widget_videofeed">
					<div class="inner">			
						<div class="caption">
							<h3>En Details</h3>
						</div>
						<ul>
							<li>
						
					</div>
				</div>
				
				
				<div id="tag_cloud-0" class="widget widget_tag_cloud">
					<div class="inner">
					<div class="caption">
					<h3>Tags</h3>
					</div>
					<div class="tagcloud">
						<a href='' class='tag-link-6' title='1 post' style='font-size: 11pt;'>High-Throughput</a>
						<a href='' class='tag-link-13' title='1 post' style='font-size: 12pt;'>Middleware</a>
						<a href='' class='tag-link-16' title='1 post' style='font-size: 11pt;'>grids</a>
						<a href='' class='tag-link-8' title='1 post' style='font-size: 8pt;'>computing resources</a>
						
						<a href='' class='tag-link-3' title='8 posts' style='font-size: 20pt;'>HTCaaS</a>
						<a href='' class='tag-link-17' title='1 post' style='font-size: 8pt;'></a>
						<a href='' class='tag-link-9' title='2 posts' style='font-size: 11.876923076923pt;'>Supercomputing</a>
						<a href='' class='tag-link-12' title='2 posts' style='font-size: 11.876923076923pt;'>KISTI</a>
						<a href='' class='tag-link-7' title='1 post' style='font-size: 8pt;'>cloud</a>
						</div>
					</div>
				</div> 
				
				
		<script>
			jQuery(document).ready(function() {
				jQuery('.widget_tabs').each(function() {
					var tabs=jQuery(this);
					jQuery('.tab_widget', this).each(function() {
						tabs.find('.tabs_captions').append(jQuery(this).find('.scaption'));
					});
					tabs.find('.scaption').each(function() {
						jQuery(this).html(jQuery(this).text());
					});
					tabs.find('.tab_widget:first').addClass('active');
					tabs.find('.scaption:first').addClass('active');
				});
				
				jQuery('.widget_tabs .scaption').die();
				jQuery('.widget_tabs .scaption').live('click', function() {
					jQuery(this).addClass('active').siblings('.scaption').removeClass('active').parents('.widget_tabs').find('.tab_widget').hide().removeClass('active').eq(jQuery(this).index()).fadeIn('slow');				});
			});
		</script>
		
		
		
		
		
		

	</div><!-- ddd-->		 
	
	
	
	<div id="main_content">  
	
		<div class='articles'> 	
			<div class='one-post'>
				<div id="HTCaaS" class="post-95 post type-post status-publish format-standard hentry category-example-posts category-formatting-posts post-caption">
					<h2>HTCaaS</h2>
					<span class='post-date'>23 avril 2013</span>, Page d'accueil</span>
				</div>
				
				<div class='post-body'>
				<p>
				Le High-Throughput computing (HTC) consiste à exécuter des taches faiblement interdépendantes (qui ne nécessitent pas de communication entre elles), mais qui ont besoin d’une grande puissance de calcul sur une période relativement longue. Les systèmes Middleware tel que Condor ou BOINC sont parvenus à atteindre des puissances de calcul énormes en mobilisant un grand nombre de ressources informatiques. Cependant, le nombre de tâches et la complexité des applications scientifiques augmentent. C’est alors un défi pour l’actuel middleware utilisant habituellement un seul type de ressources (E.g. cluster de stations de travail et d’ordinateurs de bureau reliés par Internet), de résoudre un problème scientifique donné en un temps raisonnable.
En outre l’émergence récente des applications qui requièrent l’exécution de millions, voir milliards de tâches en un temps relativement limité, a conduit le calcul à haut débit traditionnel à devenir du Many-Tasks Computing (MTC).
</p>
				<p>
				Par conséquent, pour prendre en charge efficacement ces applications scientifiques complexes et exigeantes, il est impératif de tirer parti d’autant de ressources de calcul que possible, superordinateurs, grids et clouds. 
Néanmoins, c’est un challenge pour les chercheurs d’utiliser efficacement des ressources controlees par des fournisseurs indépendants, étant donné que le nombre de travaux (devant être soumis en même temps) augmente de façon spectaculaire (comme dans les balayages de paramètres, ou les calculs à N-Corps).
</p>
				<p>
				Nous avons conçu et implémenté le système HTCaaS (High-Throughput computing as à Service), qui est capable de masquer aux utilisateurs la complexité et l’hétérogénéité de l’exploitation de ressources de calcul variées, et d’envoyer de nombreuses commandes à la fois en gérant et en exploitant efficacement toutes les ressources disponibles.</p>
				<p><br/>
				Principes de conception:
				</p>
				<p>
				<ul>
					<li>facilité d’utilisation: les couts de traitement d’une grande quantité d’applications et de ressources informatiques sont minimisés.</li>
					<li>Sélection de ressources intelligentes: L’HTCaaS est capable de sélectionner automatiquement des ressources plus efficaces et plus réactives, et de s’adapter à la charge actuelle en ajustant dynamiquement les ressources acquises.</li>
					<li>Interface pluggable aux ressources: Nous utilisons le mécanisme du pluggin GANGA afin d’accéder aux ressources informatiques hétérogènes sans hardcoding.</li>
					<li>Support pour de nombreuses interfaces client: Un large eventail d’interfaces client sont supportées, y compris une interface native WS, Java API, et des outils client (CLI, GUI).</li>
					
				</div>
			</div>
			

		
					
			<div class='one-post'>
				<div id="System" class="post-95 post type-post status-publish format-standard hentry category-example-posts category-formatting-posts post-caption">
					<h2>Architecture et composants systeme</h2>
	
				</div>
				
				<div class='post-body'>
				<p>
				L’HTCaaS est constitué de 5 modules côté serveur (Gestionnaire de compte, Gestionnaire de données utilisateur, Gestionnaire de commandes informatiques, Gestionnaire d’agent, et Gestionnaire de surveillance) et de deux outils côté client (Interface ligne de commande et Interface utilisateur graphique).</p>
				<br/>
				<img src="images/content/HTCaaS_Architecture.png" width='600px'/>
				<br/>
				<p>
				Dans notre système, une commande informatique correspond aux données et au profil associé qui décrit le traitement à effectuer. Comme certains utilisateurs peuvent vouloir exécuter un grand nombre de commandes en utilisant les paramètres sweep ou des calculs à N corps, HTCaaS offre le concept de Meta-Job, qui spécifie la description d’une tache de plus haut niveau en se basant sur le standard OGF JSDL. Une fois qu’un Meta-Job est soumis, HTCaaS le divise automatiquement en sous-jobs et les insert dans la file de Jobs (implémentée en active MQ) gerée par le Job Manager. Toutes les données saisies ainsi que les résultats produis sont stockés dans le gestionnaire de données utilisateur. Une fois qu’un job est envoyé dans notre système, des agents (implémentés en Java) sont dispatchés par le gestionnaire d’agents et exécutent les jobs dans les superordinateurs, les grids et les clouds. HTCaaS utilise le multi-level scheduling & streamlined job dispatching basé sur les agents, de façon à ce que les requêtes de premier niveau faites a un ordonnanceur batch (E.g. …) reserve les ressources en soumettant des agents comme batch jobs, qui tirent chacun de facon proactive les jobs du gestionnaire de job qui met en oeuvre le mécanisme léger et rapide du dispatchement de jobs.</p>
				<p>
				Par conséquent, les utilisateurs du HTCaaS sont capables de soumettre et d’exécuter des centaines de milliers de jobs (qui peuvent être exprimés par un simple script JSDL) a l’intérieur d’un processus automatisé, de les surveiller efficacement et de traiter les résultats finaux. Pour ceux qui ne sont pas familiers avec le style de script XML, nous proposons également un outil GUI easy-to-use qui peut générer le script JSDL automatiquement en se basant sur les données saisies par l’utilisateur afin de l’envoyer au système. Le déroulement global d’un job et de son exécution dans un système HTCaaS est le suivant:</p>
				<br/>
				<img src="images/content/JobExecutionSteps.jpg" width='600px'/>
				<br/>
				<p>
				1. L’utilisateur identifie HTCaaS et envoie les données entrées via le gestionnaire de données utilisateur.<br/>
				2.	L’utilisateur soumet un Meta-Job (écrit en JSDL) pouvant être compose de taches multiples.<br/>
				3.	HTCaaS divise automatiquement le Meta-Job en taches multiples en suivant les spécifications et les inserts dans la file de jobs.<br/>
				4.	Le gestionnaire d’agents dispatche les agents selon les besoins des jobs et les ressources disponibles.<br/>
				</div>
			</div>
			
			<div class='one-post'>
				<div id="Publications" class="post-95 post type-post status-publish format-standard hentry category-example-posts category-formatting-posts post-caption">
					<h2>Publications et presentations techniques</h2>
	
				</div>
				<br/>
				<div class='post-body'>
				<h3>Publications</h3>
				<p>
				<ol list-style-type: " decimal type">
					<li>Jik-Soo Kim, Sangwan Kim, Seokkyoo Kim, Seoyoung Kim, Seungwoo Rho, Ok-Hwan Byeon, and Soonwook Hwang, <strong>Towards a Next Generation Distributed Middleware System for Many-Task Computing</strong>, To appear at <a rel='noopener noreferrer" target="_blank" class="external text" href="http://www.sersc.org/journals/IJSEIA/">International Journal of Software Engineering and Its Applications</a>, 2013.</li>
					<li>Jik-Soo Kim, Sangwan Kim, Seokkyoo Kim, Seoyoung Kim, Seungwoo Rho, Ok-Hwan Byeon, and Soonwook Hwang, <strong>From High-Throughput Computing to Many-Task Computing: Challenges, Systems and Applications</strong>, To appear at <a rel="noopener noreferrer" target="_blank" class="external text" href="http://sc12.supercomputing.org/">The 2nd International Conference on Software Technology (SoftTech 2013)</a>, April 2013.</li>
					<li>Sehoon Lee, Seokkyoo Kim, Seungwoo Rho and Soonwook Hwang, <strong>HTCaaS (HTC as a Service): A Large-scale HTC Problem Solving Environment Using Distributed and Heterogeneous Infrastructures</strong>, <a rel="noopener noreferrer" target="_blank" class="external text" href="http://event.twgrid.org/isgc2012/">2012 International Symposium on Grids and Clouds (ISGC)</a>, Feb 2012 (PDF)</li>
				</ol>
				</p>
				<br/>
				<h3>Presentations techniques</h3>
				<p>
				<ol list-style-type: " decimal type">
					<li>Sangwan Kim, Seoyoung Kim, Seungwoo Rho, Seokkyoo Kim, Jik-Soo Kim and Soonwook Hwang, <strong>HTCaaS, a Viable Choice for Efficient and Simplified Large-Scale Scientific Computing</strong>, Research Poster at YongPyong International Winter Conference on Particle Physics (YongPyong-2013), February 2013.</li>
					<li>Seungwoo Rho, Seoyoung Kim, Sangwan Kim, Seokkyoo Kim, Jik-Soo Kim and Soonwook Hwang, <strong>HTCaaS: A Large-Scale High-Throughput Computing by Leveraging Grids, Supercomputers and Cloud</strong>, Research Poster at <a rel="noopener noreferrer" target="_blank" class="external text" href="http://sc12.supercomputing.org/">IEEE/ACM International Conference for High Performance Computing, Networking, Storage and Analysis (SC12)</a>, November 2012 (PDF).</li>
					<li>Jik-Soo Kim, <strong>Efficient and Simplified Large-Scale High-Throughput Computing over Grids and Supercomputers</strong>, at <a rel="noopener noreferrer" target="_blank" class="external text" href="http://hpc.mju.ac.kr/SIG_HPC/2012_Fall_Workshop/index.html">The First KIISE-KOCSEA HPC SIG Joint Workshop on High Performance and Throughput Computing</a>, November 2012</li>
					<li>Seokkyoo Kim, <strong>HTCaaS on PLSI</strong>, Korea Supercomputing Conference (KSC) 2012, Oct 2012.</li>
					<li>Jik-Soo Kim, <strong>HTCaaS: A Large-Scale High-Throughput Computing by Leveraging Grids, Supercomputers and Cloud</strong>, at <a rel="noopener noreferrer" target="_blank" class="external text" href="http://dcslab.snu.ac.kr/sighpc/2012summer/program.html"> 2012 Korean Institute of Information Scientists and Engineers (KIISE) HPC Special Interest Group Workshop</a>, August 2012.</li>
				
				</ol>
				</p>
				<br/>
				</div>
			</div>
		
		
		
		</div>		
	
	

		
	</div><!-- #content -->  
	
	</div>
</div>



<div id='smthemes_share'>
	<ul class='inner'>
		<li><iframe src="//www.facebook.com/plugins/like.php?href=$wikiurl" scrolling="no" frameborder="0" style="border:none; overflow:hidden; padding: 0 0 0 5px; width:68px; height:30px;" allowTransparency="true"></iframe></li>
		<li><a href="#" onclick="return false;" class="twitter-share-button" data-count="vertical">Tweet</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></li><li><g:plusone size="tall"></g:plusone>
			<script type="text/javascript">
					  (function() {
						var po = document.createElement("script"); po.type = "text/javascript"; po.async = true;
						po.src = "https://apis.google.com/js/plusone.js";
						var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s);
					  })();
			</script>
		</li>			
	</ul>
</div>


<div id='content-bottom' class='container'>
</div>


<div id='footer'>
		<div class='container clearfix'>
			
						<div class='footer-widgets-container'><div class='footer-widgets'>
				<div class='widgetf'>
					<div id="calendar-0" class="widget widget_calendar">
					<div class="inner"><div class="caption">
					<h3>Calendrier</h3>
					</div>
					<div class="row" style="width:350px;">
						<div class="g4">
							<div id="eventCalendarDefault"></div>
								<script>
									$(document).ready(function() {
										$("#eventCalendarDefault").eventCalendar({
											eventsjson: 'event/json/events.json.php' // link to events json
										});
									});
								</script>
							</div>
					</div>
					<div id="calendar_wrap">
					<table id="wp-calendar">

					</table>
	
					</div>
					</div>
					</div>				
				</div>
	
				
				<div class='widgetf'>
					<div id="tag_cloud-0" class="widget widget_tag_cloud"><div class="inner"><div class="caption"><h3>Tags</h3></div><div class="tagcloud"><a href='http://smthemes.com/demowp/?tag=blockquote&amp;preview=1&amp;template=onion&amp;stylesheet=onion' class='tag-link-6' title='1 post' style='font-size: 8pt;'>blockquote</a>
						<a href='' class='tag-link-6' title='1 post' style='font-size: 11pt;'>High-Throughput</a>
						<a href='' class='tag-link-13' title='1 post' style='font-size: 12pt;'>Middleware</a>
						<a href='' class='tag-link-16' title='1 post' style='font-size: 11pt;'>grids</a>
						<a href='' class='tag-link-8' title='1 post' style='font-size: 8pt;'>computing resources</a>
						
						<a href='' class='tag-link-3' title='8 posts' style='font-size: 20pt;'>HTCaaS</a>
						<a href='' class='tag-link-17' title='1 post' style='font-size: 8pt;'></a>
						<a href='' class='tag-link-9' title='2 posts' style='font-size: 11.876923076923pt;'>Supercomputing</a>
						<a href='' class='tag-link-12' title='2 posts' style='font-size: 11.876923076923pt;'>KISTI</a>
						<a href='' class='tag-link-7' title='1 post' style='font-size: 8pt;'>cloud</a></div></div>		
					</div>
				</div>
				<div id="social_profiles-0" class="widget_social_profiles">
					<div class="inner">			
						<div class="caption">
							<h3>Reseaux sociaux</h3>
						</div>
						<div style="float:left;">
							<a href="http://twitter.com/" rel="noopener noreferrer" target="_blank"><img title="Twitter" alt="Twitter" src="images/social-profiles/twitter.png" height="32" width="32" /></a>
							<a href="http://facebook.com/" rel="noopener noreferrer" target="_blank"><img title="Facebook" alt="Facebook" src="images/social-profiles/facebook.png" height="32" width="32" /></a>
							<a href="https://plus.google.com/" rel="noopener noreferrer" target="_blank"><img title="Google Plus" alt="Google Plus" src="images/social-profiles/gplus.png" height="32" width="32" /></a>
							<a href="http://www.linkedin.com/" rel="noopener noreferrer" target="_blank"><img title="LinkedIn" alt="LinkedIn" src="images/social-profiles/linkedin.png" height="32" width="32" /></a>
							<a href="mailto:your@email.com" rel="noopener noreferrer" target="_blank"><img title="Email" alt="Email" src="images/social-profiles/email.png" height="32" width="32" /></a>    
						</div>
					</div>   
				</div>								
			</div>
						
		</div>
		

		
		<div class='footer_txt'>
			<div class='container'>
				<div class='top_text'>
				Copyright &copy; 2013 HTCaaS - Kisti</div>
			</div>
		</div>
		
	</div>


			
</div> 
</div> 

</body>

<!--script src="js/jquery.timeago.js" type="text/javascript"></script-->
<!--<script src="js/jquery.eventCalendar.min.js" type="text/javascript"></script>-->
<script src="event/js/jquery.eventCalendar.js" type="text/javascript"></script>




</html>

EOS;

?>
