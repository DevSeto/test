<h1>Profile information: <?php echo $first_name . " " . $last_name; ?></h1>
<div class="menu"><a href="/login/logout">Logout</a><?php if ($admin) { ?>&nbsp;&nbsp;&nbsp;<a href="/users">View users</a><?php } ?></div>
<br />
<form action="<?php echo $action; ?>" method="post">
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
			<td>First name:</td>
			<td><input type="text" name="first_name" value="<?php echo $first_name; ?>" /></td>
		</tr>
		<tr>
			<td>Last name:</td>
			<td><input type="text" name="last_name" value="<?php echo $last_name; ?>" /></td>
		</tr>
		<tr>
			<td>Login:</td>
			<td><input type="text" name="login" value="<?php echo $login; ?>" /></td>
		</tr>
		<tr>
			<td>E-mail:</td>
			<td><input type="text" name="email" value="<?php echo $email; ?>" /></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="password" name="pwd1" value=""></td>
		</tr>
		<tr>
			<td>Password (retype):</td>
			<td><input type="password" name="pwd2" value=""></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" name="change" value="<?php echo $submit_button; ?>" /></td>
		</tr>
	</table>
</form>