<?php

function showException($e) { ?>
	<table style="border:2px solid #777" cellpadding="5px;" cellspacing="0px;">
		<tr>
			<th colspan=2 style="background-color:red; color:white; font-weight:bold; font-size:22px;">Exception Info</th>
		</tr>
		<tr>
			<td>Code:</td><td><?php echo $e->getCode(); ?></td>
		</tr>
		<tr>
			<td>Message:</td><td><?php echo $e->getMessage(); ?></td>
		</tr>
		<tr>
			<td>File:</td><td><?php echo $e->getFile(); ?></td>
		</tr>
		<tr>
			<td>Line:</td><td><?php echo $e->getLine(); ?></td>
		</tr>
		<tr>
			<td  style="border-top: solid 1 px #777;">Trace stack:</td><td style="border-top: solid 1 px #777;border-left: solid 1px #777;"><pre><?php var_dump($e->getTrace()); ?></pre></td>
				</tr>
			</table>

	<?php
}
