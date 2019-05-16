<H1><?php echo $title; ?></H1>

<form action="/login" method="post">
	<table>
		<?php if (!empty($error)) { ?>
		<tr>
			<td colspan="2" class="error">
				<?php foreach ($error as $err) {
				echo $err; ?><br />
				<?php } ?>
			</td>
		</tr>
		<?php } ?>
		<tr>
			<td>Login:</td>
			<td><input type="text" name="login" value="<?php echo $name; ?>" /></td>
		</tr>
		<td>Password:</td>
		<td><input type="password" name="password" /></td>
		<tr>
		<tr>
			<td><input type="submit" value="LogIn" /></td>
		</tr>
		<tr>
			<td colspan="2"><a href="/register">Click here to register</a></td>
		</tr>
		</tr>
	</table>
</form>