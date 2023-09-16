<!DOCTYPE html>
<html>
<head>
	<title>Contact Us</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/contact.css">
</head>
<body>

<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<h2>Contact Us</h2>
			<form action="process_form.php" method="post">
				<div class="form-group">
					<label for="name">Name:</label>
					<input type="text" class="form-control" id="name" name="name" required>
				</div>
				<div class="form-group">
					<label for="email">Email:</label>
					<input type="email" class="form-control" id="email" name="email" required>
				</div>
				<div class="form-group">
					<label for="subject">Subject:</label>
					<input type="text" class="form-control" id="subject" name="subject" required>
				</div>
				<div class="form-group">
					<label for="message">Message:</label>
					<textarea class="form-control" id="message" name="message" required></textarea>
				</div>
					<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
	</div>
</div>

</body>
</html>
