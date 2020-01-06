<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset='utf-8'>
	<title><?= $accountPayablePayment['no_account_payable'] ?></title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900">
	<style>
		@page {
			margin: 20px 30px 20px 20px;
		}

		* {
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box;
		}

		body {
			margin: 5px;
			background: none;
			font-family: Roboto, sans-serif;
			font-weight: normal;
			font-size: 12px;
		}

		hr {
			height: 0;
			-webkit-box-sizing: content-box;
			-moz-box-sizing: content-box;
			box-sizing: content-box;
			margin-top: 10px;
			margin-bottom: 10px;
			border: 0;
			border-top: 1px solid #ddd;
		}

		p {
			margin: 0;
			font-family: Roboto, sans-serif;
		}

		table {
			width: 100%;
			border-collapse: collapse;
			vertical-align: middle;
		}

		table th {
			font-family: Roboto, sans-serif;
			font-weight: 600;
		}

		table.table {
			width: 100%;
			border-collapse: collapse;
			border: 1px solid #000;
		}

		table.table td, table.table th {
			vertical-align: middle;
			border: 1px solid #000;
			padding: 3px;
		}

		.text-center {
			text-align: center;
		}

		.rotate {
			text-align: center;
			white-space: nowrap;
			vertical-align: middle;
			width: 1.5em;
		}

		.rotate .rotate-wrapper {
			-moz-transform: rotate(-90.0deg);  /* FF3.5+ */
			-o-transform: rotate(-90.0deg);  /* Opera 10.5 */
			-webkit-transform: rotate(-90.0deg);  /* Saf3.1+, Chrome */
			filter:  progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083);  /* IE6,IE7 */
			-ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083)"; /* IE8 */
			margin-left: -10em;
			margin-right: -10em;
		}

		.box-check:before {
			content: "";
			width: 15px;
			height: 15px;
			display: inline-block;
			border: 1px solid #333333;
			margin-right: 5px;
			text-align: center;
			top: 0;
			left: 0;
			color: transparent;
		}

		.box-check.checked:before {
			content: "v";
			font-weight: bold;
		}

		.box-check {
			position: relative;
			margin-bottom: 10px;
		}

		.box-check span {
			display: inline-block;
			margin-right: 10px;
		}
	</style>
</head>
<body>

</body>
</html>
