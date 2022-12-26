<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>{$title}</title>
	<link rel="stylesheet" type="text/css" href="/css/engine.css?{$cssver}" media="screen" />
	{*
	<link rel="stylesheet" type="text/css" href="/css/private/01-thickbox.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/css/private/02-crir.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/css/private/03-style.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/css/private/04-common.css" media="screen" />
	{**}
	
	<script type="text/javascript" src="/javascript/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript" src="/javascript/engine.js?{$jsver}"></script>
	{*
	<script type="text/javascript" src="/javascript/private/01-jquery.js"></script>
	<script type="text/javascript" src="/javascript/private/02-jquery.jeditable.js"></script>
	<script type="text/javascript" src="/javascript/private/03-jquery.richeditor.js"></script>
	<script type="text/javascript" src="/javascript/private/04-behaviour.js"></script>
	<script type="text/javascript" src="/javascript/private/05-crir.js"></script>
	<script type="text/javascript" src="/javascript/private/06-thickbox.js"></script>
	<script type="text/javascript" src="/javascript/private/07-library.js"></script>
	<script type="text/javascript" src="/javascript/private/08-engine.js"></script><!---->
	{**}

	<link rel="shortcut icon" href="/favicon.ico" />
  
  <meta http-equiv="content-type" content="text/html;charset=utf-8" />	
	<meta name="author" content="FemtoPixel" />
	<meta name="description" content="Site description" />
	<meta name="keywords" content="key, words" />	
</head>

<body>
<div id='allcontent'>
<div id='languageSelector'>
	{if $locale neq 'fr'}<a href='/language/fr' title="Français">{/if}<img src='/image/flag/fr.jpg' alt='Français' />{if $locale neq 'fr'}</a>{/if}
	{if $locale neq 'en'}<a href='/language/en' title="English">{/if}<img src='/image/flag/en.jpg' alt='English' />{if $locale neq 'en'}</a>{/if}
</div>
<div id='loginDetails'>
	{if $connected eq 1}
		<b>{$mylogin}</b> ({$mymail}) | <a href='/ws/disconnect'>{$disconnect}</a>
	{else}
		<a href='/ws/login'>{$loginOrRegister}</a>
	{/if}
</div>
<div id="wrap">
<div id="top">
<h2><a href="/">ContactBook</a></h2>
{if $connected eq 1}
<div id="menu">
<ul>
<li><a href="/" {if $onglet eq 1} class="current" {/if}>{$consult}</a></li>
<li><a href="/contact/add" {if $onglet eq 2} class="current" {/if}>{$add}</a></li>
<li><a href="/Deletesociete" {if $onglet eq 3} class="current" {/if}>{$deletecompanie}</a></li>
{if $useShare}
	<li><a href="/sharemanager" {if $onglet eq 4} class="current" {/if}>{$sharemanager}</a></li>
	{if $newShared neq 0}<li><a href="/ajax/share" title="{$newSharedTitle}" class='thickbox'>{$newShared}</a></li>{/if}
{/if}
</ul>
</div>
{/if}
</div>
<div id="content">
{$templateRenderer}
<div id="clear"></div>
</div>
<div id="footer">
<p>Copyright 2009 <a href='https://jaymoulin.me' target='_blank'>Jay MOULIN</a>. Valid <a href="http://jigsaw.w3.org/css-validator/check/referer" rel="external">CSS</a> &amp; <a href="http://validator.w3.org/check?uri=referer" rel="external">XHTML</a></p>
</div>
</div>
</div>
<script type="text/javascript">
	//<![CDATA[
	setJsTexts('{$JavaScriptTexts}');
	//]]>
</script>
</body>
</html>
