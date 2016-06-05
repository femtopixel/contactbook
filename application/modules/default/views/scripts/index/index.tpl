<div id='recherche'>
	<form action='javascript:void(0);' method='post' id='searchform'>
		<div>
			{$search} : <input type='text' name='term' id='term'/>
			<button value='input' id='submit_searchform' class="submitBtn submitForm"><span>{$launchSearch}</span></button>
			<input type='submit' value='Rechercher !' class='hidden' />
		</div>
	</form>
</div>
<br/>
<div id='rechercheresult'>
</div>