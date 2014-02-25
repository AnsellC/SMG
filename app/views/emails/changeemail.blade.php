<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<strong>Hi {{$username}},</strong>

		<p>
			You've requested to change your e-mail address. Please {{link_to('users/validate/'. $id .'/'. $code, 'click this link.')}} to verify this new address. Your upload capabilities will be suspended until you click the above link.
			
		</p>
		<p>
			<strong>Important:</strong> Do not reply to this e-mail. This is an automated mail and all emails sent to this address are discarded automatically.
		</p>
	</body>
</html>