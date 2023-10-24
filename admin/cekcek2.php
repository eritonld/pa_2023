<!DOCTYPE html>
<html>
<head>
  <title>Pencarian pada Select</title>
</head>
<body>
  <input type="text" id="searchInput" placeholder="Cari...">
  <select id="selectList">
    <option value="1">Pilihan 1</option>
    <option value="2">Pilihan 2</option>
    <option value="3">Pilihan 3</option>
    <option value="4">Pilihan 4</option>
  </select>

  <script>
    document.getElementById('searchInput').addEventListener('input', function() {
      var input = this.value.toLowerCase();
      var select = document.getElementById('selectList');

      for (var i = 0; i < select.options.length; i++) {
        var optionText = select.options[i].text.toLowerCase();
        if (optionText.includes(input)) {
          select.options[i].style.display = '';
        } else {
          select.options[i].style.display = 'none';
        }
      }
    });
  </script>
</body>
</html>
