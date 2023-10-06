<?php
##header("Access-Control-Allow-Origin: *");
#$headerCSP = "Content-Security-Policy:". 
#	     "default-src 'self' ;". // 기본은 자기 도메인만 허용 
#             "connect-src 'self' ;". // ajax url은 자기 도메인만 허용 
#             "script-src 'self'  ;". // 자기자신, 접근허용 도메인 설정 
#             "style-src 'self' 'unsafe-inline' 'unsafe-eval';"; 
#             "report-uri https://example.com/csp_report.php;". // 보안 정책 오류 레포트 URL 지정(meta 태그에선 사용불가) 
#header($headerCSP);


  # -----------------------------------------------------------
  # For AMGCC13 (August 5. 2013.)
  #  redirect  requst  /index.php/AMGCC13  to the wiki page
#  $ruri = $_SERVER['REQUEST_URI'];
#  if ($ruri == '/index.php/AMGCC13') {
#   header("Location: /htcwiki/index.php/AMGCC13");
#    exit;
#  }
  # -----------------------------------------------------------
  $wikiurl = "/htcwiki";

  print<<<EOS
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">

<head>
	<title>HTC-as-a-Service, KISTI</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
	
	<div id="google_translate_element"></div>

	<meta name="Description" content="" />
	<meta name="Keywords" content="" />
				
				<link rel="stylesheet" href="css/index.css" type="text/css" media="screen, projection" />
				<link rel="stylesheet" href="css/wide.css" type="text/css" media="screen" />
				
					
<!--				<script type='text/javascript' src='http://maps.google.com/maps/api/js?sensor=false&amp;ver=3'></script>
				<script src="js/jquery.cycle.all.js" type="text/javascript"></script>
				<script type="text/javascript" src="js/superfish.js?ver=3.3.1"></script>
			<!--<script type="text/javascript" src="js/smthemes.js?ver=645"></script> --> -->
			
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
				<link rel="alternate noopener noreferrer" type="application/atom+xml" title="HTC-as-a-Service, KISTI Atom feed" href="http://htcaas.kisti.re.kr/index.php?title=Special:RecentChanges&amp;feed=atom" />
				<link rel="search" type="application/opensearchdescription+xml" href="/opensearch_desc.php" title="HTC-as-a-Service, KISTI (en)" />
				<link rel="EditURI noopener noreferrer" type="application/rsd+xml" href="http://htcaas.kisti.re.kr/api.php?action=rsd" />
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
			
			

<!-- <script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/timeline.js"></script> -->

<script type="text/javascript">
	// make sure that you pass in the id of the DIV element
	// that contains the calendar HTML. In this case the id is “timeline”
	$(document).ready(function(){
	var timeline = new Timeline("timeline");
	});
</script>
			
		
<link href="css/timeline.css" rel="stylesheet" type="text/css" />

	



	
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
						
						<a href="$wikiurl" class="lang"><img src="images/mediawiki.png" alt="Go to Wiki" />Go to Wiki</a>
						
						<a href="frindex.php" class="lang"><img src="images/flags/fr.png" alt="France" />Français</a>
						
						
						<a href="index.php" class="lang"><img src="images/flags/eng.png" alt="English" />English</a>
						
					</div>
					
				</div>
						
			</div>
		
			
			<div div='floatdiv' class='slider-container'>
				<div class='slider-bgr'>
				</div>
				<div class="slider">
					<div class="fp-slides">
						<div class="fp-slides-items fp-first">
							<div class="fp-thumbnail">
								<a href="" title=""><img src="images/slides/1.jpg" alt="Slide # 1" /></a><br/>
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
								<a href="" title=""><img src="images/slides/2.jpg" alt="Slide # 2" /></a><br/>
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
				</div><!-- #search --></div></div>	
				
				<div id="posts-0" class="widget widget_posts">
					<div class="inner">        
						<div class="caption">
						<h3>Content</h3>
						</div>            
						<div id="tabs-0" class="widget widget_tabs">
							<div class="inner">        			
								<div class='tabs_contents'>
									<div>
										<div class="inner">
											<ul>
											<li class="cat-item cat-item-19"><a href="#HTCaaS" title="">About HTCaaS</a></li>
											<li class="cat-item cat-item-10"><a href="#System" title="">System Architecture & Components</a></li>
											<li class="cat-item cat-item-18"><a href="#Publications" title="">Publications</a></li>
											<li class="cat-item cat-item-18"><a href="#Publications" title="">Technical Presentations</a></li>
											<li class="cat-item cat-item-18"><a href="#Publications" title="">Patent Applications</a></li>
											<li class="cat-item cat-item-18"><a href="https://moaform.com/q/4Fd5DW" title="">User Evaluation</a></li>
											</ul>
									</div>
									</div>
											
								</div>
				
								<div style='clear:both'>
								</div>
							</div>
						</div>               
					</div>
				</div>               
				<!--
				<div id="comments-0" class="widget widget_comments">
					<div class="inner">        
						<div class="caption">
							<h3>Events</h3>
						</div>            
						
						<ul>
							<li>
                                <div class='avatar' style='width:32px'><img alt='' src='images/content/mini_workshop.jpg' class='avatar avatar-32 photo' height='32' width='32' />
								</div> 
								<span class='comment'><strong>HTCaaS workshop</strong> <a target='_blank' rel="noopener noreferrer" href='$wikiurl/index.php/Mini_htcaas_workshop13'>Mini Workshop on HTCaaS development for PLSI</span></a></li>
                             
                            <li>
                                <div class='avatar' style='width:32px'><img alt='' src='images/content/currentevent-prev.jpg' class='avatar avatar-32 photo' height='32' width='32' />
								</div> 
								<span class='comment'><strong>AMGCC13</strong> <a target='_blank' rel="noopener noreferrer" href='$wikiurl/index.php/AMGCC13'>The 1st International Workshop on Autonomic Management of Grid and Cloud Computing</span></a></li>
                              </ul>
					</div>
				</div>    
				-->
				
				<div id="videofeed-0" class="widget widget_videofeed">
					<div class="inner">			
						<div class="caption">
							<h3>Downloads & Demos</h3>
						</div>
						<div id="categories-2" class="tab_widget widget_categories">
						<div class="inner">
							<span class="scaption">HTCaaS CLI</span>		
							<ul>
							<li class="cat-item cat-item-19"><a href="$wikiurl/index.php/CLI-Tutorial" title="">Tutorial & Manual</a>
							</li>
							<li class="cat-item cat-item-19"><a href="$wikiurl/index.php/CLI-Download" title="">Download</a>
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
							<li class="cat-item cat-item-19"><a href="$wikiurl/index.php/GUI-Tutorial" title="">Tutorial & Manual</a>
							</li>
							<li class="cat-item cat-item-19"><a href="$wikiurl/index.php/GUI-Download" title="">Download</a>
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
							<h3>Gallery</h3>
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
					<span class='post-date'>Nov. 30, 2020</span>, Main Page</span>
				</div>
				
				<div class='post-body'>
				<p>
				High-Throughput Computing (HTC) consists of running many loosely-coupled tasks that are independent (there is no communication needed between them) but requires a large amount of computing power during relatively a long period of time. Middleware systems such as Condor or BOINC have successfully achieved a tremendous computing power by harnessing a large number of computing resources. However, as the number of jobs and the complexity of scientific applications increase, it becomes a challenge for the traditional middleware systems employing typically a single type of resources (e.g., clusters of workstations, desktop machines over Internet) to solve the given scientific problem within a reasonable amount of time. Also, recent emerging applications requiring millions or even billions of tasks to be processed with relatively short per task execution times have led the traditional HTC to expand into Many-Task Computing (MTC).
				</p>
				<p>
				Therefore, to effectively support complex and demanding scientific applications, it is inevitable to harness as many computing resources as possible including Supercomputers, Grids, and even Cloud. However, it is challenging for researchers to effectively utilize available resources that are under control by independent resource providers as the number of jobs (that should be submitted at once) increase dramatically (as in parameter sweeps or N-body calculations).
				</p>
				<p>
				We designed and implemented the HTCaaS (High-Throughput Computing as a Service) system that can hide heterogeneity and complexity of leveraging different computing resources from users, and efficiently submit a large number of jobs at once by effectively managing and exploiting of all available computing resources.
				</p>
				<p><br/>
				Our Design Philosophy is as followings:
				</p>
				<p>
				<ul>
					<li>Ease of Use: We minimize user overhead for handling a large amount of jobs & computing resources</li>
					<li>Intelligent Resource Selection: HTCaaS can automatically select more responsive and effective resources and adapt to the current load by dynamically adjusting acquired resources</li>
					<li>Pluggable Interface to Resources: We adopt GANGA's plugin mechanism for accessing heterogeneous computing resources without hardcoding</li>
					<li>Support for Many Client Interfaces: A wide range of client interfaces are supported including a native WS-interface, Java API, and Client tools (CLI, GUI)</li>
					
				</div>
			</div>
			

		
					
			<div class='one-post'>
				<div id="System" class="post-95 post type-post status-publish format-standard hentry category-example-posts category-formatting-posts post-caption">
					<h2>System Architecture & Components</h2>
	
				</div>
				
				<div class='post-body'>
				<p>
				HTCaaS system consists of five server-side modules (Account Manager, User Data Manager, Job Manager, Agent Manager, Monitoring Manager) and two client-side tools (Command-Line Interface and Graphic User Interface).
				</p>
				<br/>
				<img src="images/content/HTCaaS_Architecture.png" alt="HTCaaS Architecture" width='600px'/>
				<br/>
				<p>
				A job in our system is the data and associated profile that describes a computation to be performed. Since users may want to submit a large number of jobs by employing parameter sweeps or N-body calculations, HTCaaS introduces a concept of the Meta-Job which specifies a higher-level job description based on the OGF JSDL standard. Once a Meta-Job is submitted, HTCaaS automatically splits it into many jobs and inserts them into the Job Queue (implemented in ActiveMQ) managed by the Job Manager. All of required input data and produced results are stored at the User Data Manager. Once jobs are submitted into our system, agents (implemented in Java) are dispatched from Agent Manager and process jobs in Supercomputers, Grids, and Clouds. HTCaaS employs agent-based multi-level scheduling & streamlined job dispatching so that a first-level request to a batch scheduler (e.g., Load Leveler in PLSI Supercomputers, gLite for Grids, PBS for Amazon EC2) reserves resources by submitting agents as batch jobs and then each agent proactively pulls the tasks from the Job Manager which implements the lightweight and fast job dispatching mechanisms.
				</p>
				<p>
				Therefore, users of HTCaaS are able to submit and execute hundreds of thousands of jobs (which can be simply expressed by a single JSDL script) within an automated process, effectively monitor them and process the final results. For those who are not familiar with XML style of scripting, we also provide an easy-to-use GUI tool which can automatically generate JSDL script based on user?셲 input so that it can be submitted into our system. The overall steps of job submission and execution in HTCaaS system are as followings:
				</p>
				<br/>
				<img src="images/content/JobExecutionSteps.jpg" alt="JobExecution" width='600px'/>
				<br/>
				<p>
				1. User logins HTCaaS and uploads input data through User Data Manager.<br/>
				2. User submits a Meta-Job (written in JSDL) which can be composed of multiple tasks.<br/>
				3. HTCaaS automatically divides a Meta-Job into multiple tasks based on the specification and insert them into the Job Queue.<br/>
				4. Agent Manager dispatches agents based on job requirements and resource availability.<br/>
				</div>
			</div>
			
			<div class='one-post'>
				<div id="Publications" class="post-95 post type-post status-publish format-standard hentry category-example-posts category-formatting-posts post-caption">
					<h2>Publications</h2>
	
				</div>
				<br/>
				<div class='post-body'>
<h3><span id="Articles_in_Refereed_Journals" class="mw-headline">Articles in Refereed Journals</span></h3>
<ol>
<li>Cao Ngoc Nguyen, Jaehwan Lee, Soonwook Hwang, Jik-Soo Kim,&nbsp;<strong>On the role of message broker middleware for many-task computing on a big-data platform</strong>, Springer Cluster Computing: The Journal of Networks, Software Tools and Applications, Volume 22, Supplement 1, pp 2527&ndash;2540, January 2019.</li>
<li>Jik-Soo Kim, Bui The Quang, Seungwoo Rho, Seoyoung Kim, Sangwan Kim, Vincent Breton, Soonwook Hwang,&nbsp;<strong>Towards Effective Scheduling Policies for Many-Task Applications: Practice and Experience based on HTCaaS</strong>, Concurrency and Computation: Practice and Experience, Volume 29, Issue 21, November 2017.</li>
<li>Cao Ngoc Nguyen, Soonwook Hwang, Jik-Soo Kim,&nbsp;<strong>Making a Case for the On-demand Multiple Distributed Message Queue System in a Hadoop Cluster</strong>, Springer Cluster Computing: The Journal of Networks, Software Tools and Applications, Volume 20, Issue 3, September 2017.</li>
<li>Cao Nguyen, Jik-Soo Kim, Jaehwan Lee, Soonwook Hwang,&nbsp;<strong>A Case Study of leveraging High-Throughput Distributed Message Queue System for Many-Task Computing on Hadoop</strong>, 5th International Workshop on Autonomic Management of high performance Grid and Cloud Computing (AMGCC&rsquo;17), September 2017</li>
<li>Jik-Soo Kim, Cao Nguyen, Soonwook Hwang,&nbsp;<strong>MOHA: Many-Task Computing meets the Big Data Platform</strong>, IEEE 12th International Conference on eScience (eScience 2016), October 2016.</li>
<li>Cao Nguyen, Jik-Soo Kim, Soonwook Hwang,&nbsp;<strong>KOHA: Building a Kafka-based Distributed Queue System on the fly in a Hadoop cluster</strong>, 2016 IEEE International Conference on Cloud and Autonomic Computing (ICCAC) (from AMGCC&rsquo;16 Workshop), September 2016.</li>
<li>Md. Azam Hossain, Cao Ngoc Ngyuen, Jik-Soo KIm, Soonwook Hwang,&nbsp;<strong>Exploiting Resource Profiling mechanism for Large-scale Scientific Computing on Grid</strong>, J of Cluster Computing, 2016, Accepted for publication</li>
<li>Eunji Hwang, Seontae Kim, Jik-Soo Kim, Sooonwook Hwang, Yourng-ri Choi,&nbsp;<strong>On the Role of Application and Resource Characterizations in Heterogeneous Distributed Computing System</strong>, J. of Cluster Computing, 2016, Accepted for publication</li>
<li>Eunji Hwang, Suntae Kim, Tae-kyung Yoo, Jik-Soo Kim, Soonwook Hwang, and Young-ri Choi,&nbsp;<strong>Resource Allocation Policies for Loosely Coupled Applications in Heterogeneous Computing Systems</strong>, IEEE Transactions on Parallel and Distributed Systems, Vol. 27, No. 8, PP. 2349-2362, July 2015</li>
<li>Jieun Choi, Younsun Ahn, Seoyoung Kim, Yoonhee Kim and Jaeyoung Choi,&nbsp;<strong>VM auto-scaling methods for high throughput computing on hybrid infrastructure</strong>, Springer Cluster Computing, Volume 18, Issue 3, September 2015</li>
<li>Jik-Soo Kim, Beomseok Nam, and Alan Sussman,&nbsp;<strong>Scalable and effective peer-to-peer desktop grid system</strong>, Springer Cluster Computing, July 2014 (DOI10.1007/s10586-014-0390-z)</li>
<li>Jik-Soo Kim, Seok-Kyoo Kim, Sangwan Kim, Seungwoo Rho, Seoyoung Kim, and Soonwook Hwang,&nbsp;<strong>An Analysis of Multi-level Scheduling Mechanism for Large-scale Scientific Computing</strong>, Journal of KIISE: Computing Practices and Letters, Volume 20, Number 7, July 2014.</li>
<li>Seok-kyoo Kim, Jik-Soo Kim, Sangwan Kim, Seungwoo Rho, Seoyoung Kim, and Soonwook Hwang,&nbsp;<strong>HTCaaS(High Throughput Computing as a Service) in Supercomputing Environment</strong>, Journal of the Korea Contents Association, Volume 14, Number 5, May 2014</li>
<li>Seoyoung Kim, Jik-Soo Kim, Soonwook Hwang, and Yoonhee Kim,&nbsp;<strong>Towards effective science cloud provisioning for a large-scale high-throughput computing</strong>, Springer Cluster Computing, December 2014</li>
<li>Jik-Soo Kim, Seok-Kyoo Kim, Sangwan Kim, Seungwoo Rho, Seoyoung Kim, and Soonwook Hwang,&nbsp;<strong>High-Throughput Computing over Distributed Supercomputing Infrastructures: Technologies and Challenges</strong>, Journal of Next Generation Information Technology (JNIT), Volume 4, Number 8, October 2013.</li>
<li>Jik-Soo Kim, Sangwan Kim, Seokkyoo Kim, Seoyoung Kim, Seungwoo Rho, Ok-Hwan Byeon, and Soonwook Hwang,&nbsp;<strong>Towards a Next Generation Distributed Middleware System for Many-Task Computing</strong>, International Journal of Software Engineering and Its Applications, Volume 7, Number 4, pages 379-389, July 2013.</li>
<li>TTH Nguyen, HJ Ryu, SH Lee, S Hwang, V Breton, JH Rhee, D Kim,&nbsp;<strong>Virtual screening identification of novel severe acute respiratory syndrome 3C-like protease inhibitors and in vitro confirmation</strong>, Bioorganic &amp; medicinal chemistry letters 21 (10), 3088-3091, May 2011.</li>
<li>TTH Nguyen, HJ Ryu, SH Lee, S Hwang, J Cha, V Breton, D Kim,&nbsp;<strong>Discovery of novel inhibitors for human intestinal maltase: virtual screening in a WISDOM environment and in vitro evaluation</strong>,Biotechnology letters 33 (11), 2185, November 2011.</li>
</ol>
				<br/>
<h3><span id="Articles_in_Refereed_Conferences_and_Workshops" class="mw-headline">Articles in Refereed Conferences and Workshops</span></h3>
<ol>
<li>Cao Nguyen, Jik-Soo Kim, Jaehwan Lee, Soonwook Hwang,&nbsp;<strong>A Case Study of leveraging High-Throughput Distributed Message Queue System for Many-Task Computing on Hadoop</strong>, 5th International Workshop on Autonomic Management of high performance Grid and Cloud Computing (AMGCC&rsquo;17), September 2017</li>
<li>Jik-Soo Kim, Cao Nguyen, Soonwook Hwang,&nbsp;<strong>MOHA: Many-Task Computing meets the Big Data Platform</strong>, IEEE 12th International Conference on eScience (eScience 2016), October 2016.</li>
<li>Cao Nguyen, Jik-Soo Kim, Soonwook Hwang,&nbsp;<strong>KOHA: Building a Kafka-based Distributed Queue System on the fly in a Hadoop cluster</strong>, 2016 IEEE International Conference on Cloud and Autonomic Computing (ICCAC) (from AMGCC&rsquo;16 Workshop), September 2016.</li>
<li>Md Azam Hossain, Hieu Trogn Vu, Jik-soo Kim, and Soonwook Hwang,&nbsp;<strong>SCOUT: A Monitor &amp; Profiler of Grid Resources for Large-Scale Scientific Computing</strong>, 3rd International Workshop on Autonomic Management of Grid and Cloud Computing (AMGCC&rsquo;15) held with IEEE CAC 2015, September 2015.</li>
<li>Jieun Choi, Seoyoung Kim, Theodora Adufu, Soonwook Hwang and Yoonhee Kim,&nbsp;<strong>A Job Dispatch Optimization Method on Cluster and Cloud for Large-scale High-Throughput Computing Service</strong>,3rd International Workshop on Autonomic Management of Grid and Cloud Computing (AMGCC&rsquo;15) held with IEEE CAC 2015, September 2015.</li>
<li>Eunji Hwang, Seontae Kim, Tae-Kyung Yoo, Jik-Soo Kim, Soonwook Hwang and Young-Ri Choi,&nbsp;<strong>Performance Analysis of Loosely Coupled Applications in Heterogeneous Distributed Computing Systems</strong>,3rd International Workshop on Autonomic Management of Grid and Cloud Computing (AMGCC&rsquo;15) held with IEEE CAC 2015, September 2015.</li>
<li>Suntae Kim, Eunji Hwang, Tae-Kyung Yoo, Jik-Soo Kim, Soonwook Hwang and Young-Ri Choi,&nbsp;<strong>Platform and Co-runner Affinities for Many-Task Applications in Distributed Computing Platforms</strong>, 15th IEEE/ACM International Symposium on Cluster, Cloud and Grid Computing (CCGrid 2015), May, 2015</li>
<li>Bui The Quang, Jik-Soo Kim, Seungwoo Rho, Seoyoung Kim, Sangwan Kim, Soonwook Hwang, Emmanuel Medernach and Vincent Breton,&nbsp;<strong>A Comparative Analysis of Scheduling Mechanisms for Virtual Screening Workflow in a Shared Resource Environment</strong>, 2015 Workshop on Clusters, Clouds and Grids for Life Sciences (CCGrid-Life 2015) held with IEEE/ACM CCGrid 2015</li>
<li>Jik-Soo Kim, Seungwoo Rho, Minho Lee, Seoyoung Kim, Sangwan Kim, and Soonwook Hwang,&nbsp;<strong>Large-Scale Drug Repositioning Simulation based on HTCaaS</strong>, Korea Computer Congress 2014], June 2014 [<strong>Best Paper Award</strong>]</li>
<li>Sangwan Kim, Seungwoo Rho, Seoyoung Kim, Jik-Soo Kim, and Soonwook Hwang,&nbsp;<strong>An Implementation of HTCaaS User Web Portal: Easy Start of HTCaaS</strong>, A International Conference on Convergence Content (ICCC) 2014, June 2014.</li>
<li>Seungwoo Rho, Jik-Soo Kim, Sangwan Kim, Seoyoung Kim, and Soonwook Hwang,&nbsp;<strong>A Scalability Performance Study for General-Purpose Applications on HTCaaS&nbsp;:The Database Perspective</strong>, A International Conference on Convergence Content (ICCC) 2014, June 2014.</li>
<li>Jik-Soo Kim, Seungwoo Rho, Seoyoung Kim, Sangwan Kim, Seok-KyooKim, and SoonwookHwang,&nbsp;<strong>Large-Scale Scientific Simulations throughout HTCaaS: Technologies, Practice and Applications</strong>, International Symposium on Grids and Clouds 2014 (ISGC 2014), March 2014. (<a class="internal" title="HTCaaS-ISGC2014.pdf" href="http://htcaas.kisti.re.kr/$wikiurl/images/3/35/HTCaaS-ISGC2014.pdf">PDF</a>)</li>
<li>Jik-Soo Kim, Seungwoo Rho, Seoyoung Kim, Sangwan Kim, Seokkyoo Kim, and Soonwook Hwang,&nbsp;<strong>HTCaaS: Leveraging Distributed Supercomputing Infrastructures for Large-Scale Scientific Computing</strong>, ACM 6th Workshop on Many-Task Computing on Clouds, Grids, and Supercomputers (MTAGS'13) held with SC13, November 2013.</li>
<li>Soonwook Hwang, Seoyoung Kim, Jik-Soo Kim, Seungwoo Rho, Sangwan Kim, Seokkyoo Kim,&nbsp;<strong>HTCaaS: Efficient and Simplified Large-Scale Scientific Computing over Supercomputers, Grids and Cloud</strong>, Research Poster at ACM Cloud and Autonomic Computing Conference (CAC 2013), August 2013. (<a class="internal" title="Soonwook-AMGCC13.pdf" href="http://htcaas.kisti.re.kr/$wikiurl/images/5/57/Soonwook-AMGCC13.pdf">PDF</a>)</li>
<li>Seoyoung Kim, Jik-Soo Kim, Soonwook Hwang and Yoonhee Kim,&nbsp;<strong>An Allocation and Provisioning Model of Science Cloud for High Throughput Computing Applications</strong>, 1st International Workshop on Autonomic Management of Grid and Cloud Computing (AMGCC&rsquo;13) held with ACM CAC 2013, August 2013. (<a class="internal" title="Seoyoung-AMGCC13.pdf" href="http://htcaas.kisti.re.kr/$wikiurl/images/1/14/Seoyoung-AMGCC13.pdf">PDF</a>)</li>
<li>Jik-Soo Kim, Beomseok Nam and Alan Sussman,&nbsp;<strong>Autonomic Load Balancing Mechanisms in the P2P Desktop Grid</strong>, 1st International Workshop on Autonomic Management of Grid and Cloud Computing (AMGCC&rsquo;13) held with ACM CAC 2013, August 2013. (<a class="internal" title="Jik-Soo-AMGCC13.pdf" href="http://htcaas.kisti.re.kr/$wikiurl/images/1/12/Jik-Soo-AMGCC13.pdf">PDF</a>)</li>
<li>Jik-Soo Kim, Seokkyoo Kim , Sangwan Kim, Seungwoo Rho, Seoyoung Kim, and Soonwook Hwang,&nbsp;<strong>Leveraging Distributed Supercomputing Infrastructures to support Large-Scale Scientific Computing</strong>, 3rd International Conference on Convergence Technology (ICCT&rsquo;2013), July 2013.</li>
<li>Jik-Soo Kim, Sangwan Kim, Seokkyoo Kim, Seoyoung Kim, Seungwoo Rho, Ok-Hwan Byeon, and Soonwook Hwang,&nbsp;<strong>From High-Throughput Computing to Many-Task Computing: Challenges, Systems and Applications</strong>, 2nd International Conference on Software Technology (SoftTech 2013), April 2013.</li>
<li>Sangwan Kim, Seoyoung Kim, Seungwoo Rho, Seokkyoo Kim, Jik-Soo Kim and Soonwook Hwang,&nbsp;<strong>HTCaaS, a Viable Choice for Efficient and Simplified Large-Scale Scientific Computing</strong>, Research Poster at YongPyong International Winter Conference on Particle Physics (YongPyong-2013), February 2013.</li>
<li>Seungwoo Rho, Seoyoung Kim, Sangwan Kim, Seokkyoo Kim, Jik-Soo Kim and Soonwook Hwang,&nbsp;<strong>HTCaaS: A Large-Scale High-Throughput Computing by Leveraging Grids, Supercomputers and Cloud</strong>, Research Poster at International Conference for High Performance Computing, Networking, Storage and Analysis (SC12), November 2012. (<a class="internal" title="HTCaaS Poster-4.5Fx3F(SC'12).pdf" href="http://htcaas.kisti.re.kr/$wikiurl/images/0/05/HTCaaS_Poster-4.5Fx3F%28SC%2712%29.pdf">PDF</a>)</li>
<li>Sehoon Lee, Seokkyoo Kim, Seungwoo Rho and Soonwook Hwang,&nbsp;<strong>HTCaaS (HTC as a Service): A Large-scale HTC Problem Solving Environment Using Distributed and Heterogeneous Infrastructures</strong>, 2012 International Symposium on Grids and Clouds (ISGC), Feb 2012. (<a class="internal" title="HTCaaS-ISGC2012.pdf" href="http://htcaas.kisti.re.kr/$wikiurl/images/e/eb/HTCaaS-ISGC2012.pdf">PDF</a>)</li>
</ol>
				<br/>
<h3><span id="Patent_Applications" class="mw-headline">Patent Applications</span></h3>
<ol>
<li>Seoyoung Kim, Eunkyu Byun, Soonwook Hwang, Seokkyoo Kim, Jik-Soo Kim, Sangwan Kim, and Seungwoo Rho,&nbsp;<strong>METHOD AND APPARSTUS FOR ALLOCATING RESOURCE REFLECTING ADAPTIVE EVALUATION IN CLOUD COMPUTING FOR HIGH-THROUGHPUT COMPUTING</strong>&nbsp;(14/326,618), July 2014, U.S.A.</li>
<li>Jik-Soo Kim, Seungwoo Rho, Seokkyoo Kim, Sangwan Kim, Soonwook Hwang,&nbsp;<strong>APPARATUS AND METHOD FOR ALLOCATING COMPUTING RESOURCE TO MULTIPLE USERS</strong>&nbsp;(10-2013-0087452), July 2013, Republic of Korea</li>
<li>Seoyoung Kim, Soonwook Hwang, Seokkyoo Kim, Jik-Soo Kim and Eunkyu Byun,&nbsp;<strong>METHOD AND APPARATUS FOR JOB PROFILING FOR HIGH THROUGHPUT COMPUTING</strong>&nbsp;(10-2013-0080181), July 2013, Republic of Korea</li>
<li>Seoyoung Kim, Soonwook Hwang, Sangwan Kim, Seungwoo Rho and Eunkyu Byun,&nbsp;<strong>METHOD AND APPARATUS FOR ALLOCATING RESOURCE REFLECTING ADAPTIVE EVALUATION IN CLOUD COMPUTING</strong>&nbsp;(10-2013-0080182), July 2013, Republic of Korea</li>
</ol>

				</div>
			</div>
		
		
		
		</div>		
	
	

		
	</div><!-- #content -->  
	
	</div>
</div>



</body>

</html>
EOS;

?>
