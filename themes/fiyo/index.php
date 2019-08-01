<!DOCTYPE html>
<html lang="{lang}">
  <head>
    <meta charset="utf-8">
    <title>{siteTitle}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{metadesc}">
    <meta name="author" content="{metaauthor}">
    <meta name="keywords" content="{metakeys}">

    <!-- Le styles -->
		<script src="/assets/js/jquery.min.js"></script>
		<script src="/assets/js/jquery-ui.min.js"></script>	
		<script src="/assets/js/loader.js"></script>
		<script src="/assets/js/main.js"></script>	
		
		<link href="/assets/css/font/font-awesome.css" rel="stylesheet" />
    <link href="/assets/css/bootstrap-responsive.css" rel="stylesheet">
		<link href="/assets/css/chosen.css" rel="stylesheet" />
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="/assets/css/datetimepicker.css" rel="stylesheet" />
		<link href="/assets/css/main.css" rel="stylesheet" />

		<link href="/css/fonts.css" rel="stylesheet" />
		<link href="/css/{m-}style.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="/assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="/image/favicon.png">
  </head>

  <body class="{home} {appView}">
		
<?php if(!checkMobile()): ?>
  <header>
	<!--div class="topheads">{module:header}</div-->
	<div  class="container">

		<div class="logo"><h1><a href="{homeurl}"><?php echo str_replace("-","<br>" , SiteName ); ?></a></h1>
		</div>

		<div class="right">
			
			</div>



		</div>

  </header>
 <?php endif; ?>


		<div class="navbar">
		  <div class="navbar-inner">

			<div class="container">
					<?php if(checkMobile()): ?>
						<div class="logo">
							<h1><a href="<?php echo FUrl; ?>"><?php echo SiteName; ?></a></h1>
						</div>
					<?php endif; ?>
					<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
			  <div class="nav-collapse">
			   {module:mainmenu}
						<div>
						{module:search}
						</div>
			  </div>
			  <!--/.nav-collapse -->
		  </div>
		</div>
	</div>

{chkmod:slide}
<section id="slide">
		<div class="slide-wrapper">
				<div class="container">
							{module:slide}
				</div>
				</div>
</section>
	{/chkmod}

<section class="section-main">
	{chkmod:atas1,atas2,atas3}
	<div id="atas">
		<div class="container">
			<div class="row-fluid">

	  			<div class="span4"> {module:atas1}
					</div>
	  			<div class="span4">	{module:atas2}
					</div>
	  			<div class="span4">	{module:atas3}
					</div>
			</div>
		</div>
	</div>
	{/chkmod}

  <div class="container">
	<div class="row-fluid main">
	
	<div class="padding10">
	  <div class="span12">
		<div class="row-fluid">
			<?php if(checkModule('left') AND checkModule('right')): ?>
		  <div class="span7">
			<?php elseif(checkModule('right') or checkModule('left')): ?>
		  <div class="span8">
			<?php else: ?>
		  <div class="span12">
			<?php endif; ?>


			{loadApps}
			
			
		  </div>

				<?php if(checkModule('left') AND checkModule('right')): ?>
				<div class="span5 right-top">
				<?php endif; ?>

				<?php if(checkModule('left') or checkModule('right')): ?>
				<div class="span4 row-fluid right-item">


					<?php if(checkModule('left')): ?>
						<?php if(checkModule('right')): ?>
							<div class="span5">
						<?php else: ?>
							<div class="span12">
						<?php endif; ?>
						{module:left}
							</div>
					<?php endif; ?>

					<?php if(checkModule('right')): ?>
						<?php if(checkModule('left')): ?>
							<div class="span7">
						<?php else: ?>
							<div class="span12">
						<?php endif; ?>
						{module:right}
							</div>
					<?php endif; ?>
				</div>
				<?php endif; ?>

			<?php if(checkModule('bottom')): ?>
			<div class="row-fluid">
			  <div class="span12">{module:bottom}</div>
			</div>
			<?php endif; ?>
		  </div>
		</div>
	  </div>
	</div>

		<div class="breadcrumb">
			<div class="container">
				{module:breadchumb}
			</div>
		</div>

	</div>
	</div>

	{chkmod:tengah}
	<div id="tengah">
		<div class="container">
			<div class="row-fluid">
				{module:tengah}

			</div>
			</div>
	</div>
	{/chkmod}

	{chkmod:bawah1,bawah2,bawah3}
	<div id="bawah">
		<div class="container">
			<div class="row-fluid">

	  			<div class="span4"> {module:bawah1}
					</div>
	  			<div class="span4">	{module:bawah2}
					</div>
	  			<div class="span4">	{module:bawah3}
					</div>
			</div>
		</div>
	</div>
	{/chkmod}

</section>
	<footer class="{layout}">
		<div class="container">
			<div class="row-fluid">

	  			<div class="span4"> {module:footer1}
					</div>
	  			<div class="span4">	{module:footer2}
					</div>
	  			<div class="span4">	{module:footer3}
					</div>
			</div>
		</div>
		<div class="container footnote">
			<div class="padding10">Copyright &copy; <a href="<?php echo FUrl; ?>"><?php echo SiteName; ?></a> <?php echo date("Y") ;?>. All Rights Reserved.


			</div>
		</div>
	</footer>



    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
</body></html>
