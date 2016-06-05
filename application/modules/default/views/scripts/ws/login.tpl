<h1>{$login}</h1>

<form method='post' action="#" id='login'>
	<span class='block'><label for='mail'>{$mail}</label><input type='text' name='mail' value="{$loginValue}"/></span>
	<span class='block'><label for='password'>{$password}</label><input type='password' name='password' value="{$passwordValue}"/></span>
	<span class="block"><label for='rememberme'>{$rememberMe}</label><input type="checkbox" id='rememberme' name='rememberme' class="crirHiddenJS" value="{$remembered}" {if $remembered eq 'true'}checked='checked'{/if}/></span>
	<br/>
	<br/>
	<br/>
	<button value="input" id='submit_login' class="submitBtn submitForm"><span>{$connect}</span></button>
</form>

{if $errorMsg ne "none"}<div id="errormsg">{$errorMsg}</div>{/if}