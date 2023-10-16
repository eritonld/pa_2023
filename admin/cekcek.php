<head>

<link href="../dist/js/select2.min.css" rel="stylesheet" />
<script src="../plugins/jQuery/jQuery-2.1.3.min.js"></script>
<script src="../dist/js/select2.min.js"></script>
</head>

<body>
<select class="js-example-basic-multiple" name="states[]" multiple="multiple">
  <option value="AL">Alabama</option>
  <option value="AD">Adabama</option>
  <option value="WY">asd</option>
</select>
</body>
<script>
	$(document).ready(function() {
		$('.js-example-basic-multiple').select2();
	});
</script>