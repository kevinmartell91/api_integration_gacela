<!doctype html>
<html>

<head>
	<!-- Include Ecwid JS SDK -->
	<script src="https://djqizrxa6f10j.cloudfront.net/ecwid-sdk/js/1.2.9/ecwid-app.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

	<script>
		// Initialize the application
		EcwidApp.init({
			app_id: "gacela-delivery-dev", // your client_id
			autoloadedflag: true,
			autoheight: true
		});

		// Get the store ID and access token
		var storeData = EcwidApp.getPayload();
		var storeId = storeData.store_id;
		var accessToken = storeData.access_token;
		var language = storeData.lang;

		if (storeData.public_token !== undefined) {
			var publicToken = storeData.public_token;
		}

		if (storeData.app_state !== undefined) {
			var appState = storeData.app_state;
		}
	</script>


	<!-- Include Ecwid CSS Framework -->
	<link rel="stylesheet" href="https://d35z3p2poghz10.cloudfront.net/ecwid-sdk/css/1.3.13/ecwid-app-ui.css" />
</head>

<body class='normalized'>

	<div class="gacela-form-section"></div>

	<!-- JS for loading native app form -->
	<script>
		jQuery(document).ready(function() {
			jQuery.ajax({
				url: 'form-company-load-settings.php',
				type: 'post',
				data: {
					'storeId': storeId,
					'accessToken': accessToken
				},
				success: function(data) {
					jQuery(".gacela-form-section").html(data);
				}
			});
		});
	</script>

	<!-- JS for CSS Framework components -->
	<script src="https://d35z3p2poghz10.cloudfront.net/ecwid-sdk/css/1.3.13/ecwid-app-ui.min.js"></script>
</body>

</html>