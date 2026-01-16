<?php
    // Původní pole článků
    $articles = [
      [
        'heading' => 'Lorem',
        'author' => 'Prokupek',
        'category' => 'IT'
      ],
      [
        'heading' => 'Fotbal',
        'author' => 'Slatinsky',
        'category' => 'Sport'
      ],
      [
        'heading' => 'Baseball',
        'author' => 'Mario',
        'category' => 'Sport'
      ],
      [
        'heading' => 'Perplexity',
        'author' => 'Zdenda',
        'category' => 'IT'
      ],
      [
        'heading' => 'PHP Tutorial',
        'author' => 'Novak',
        'category' => 'IT'
      ],
      [
        'heading' => 'Hokej',
        'author' => 'Svoboda',
        'category' => 'Sport'
      ],
      [
        'heading' => 'Web Design',
        'author' => 'Dvorak',
        'category' => 'IT'
      ],
      [
        'heading' => 'Basketbal',
        'author' => 'Cerny',
        'category' => 'Sport'
      ]
    ];

    // Zpracování POST pro přidání nového článku
    $zobrazeni_clanky = $articles;
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['heading'])) {
        $novy_clanek = [
            'heading' => $_POST['heading'] ?? '',
            'author' => $_POST['author'] ?? '',
            'category' => $_POST['category'] ?? ''
        ];
        $zobrazeni_clanky[] = $novy_clanek;
    }

    // Zpracování GET filtrů
    $hledani = $_GET['search'] ?? '';
    $kategorie = $_GET['category'] ?? '';

    $filtrovane_clanky = $zobrazeni_clanky;

    if (!empty($hledani) || (!empty($kategorie) && $kategorie !== 'all')) {
        $filtrovane_clanky = array_filter($zobrazeni_clanky, function($clanek) use ($hledani, $kategorie) {
            $shoda_hledani = empty($hledani) || 
                stripos($clanek['heading'], $hledani) !== false || 
                stripos($clanek['author'], $hledani) !== false;
            
            $shoda_kategorie = empty($kategorie) || $kategorie === 'all' || 
                $clanek['category'] === $kategorie;
            
            return $shoda_hledani && $shoda_kategorie;
        });
    }
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
 
  <style>
table {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}
 
td, th {
  border: 1px solid #ddd;
  padding: 8px;
}
 
tr:nth-child(even){background-color: #f2f2f2;}
 
tr:hover {background-color: #ddd;}
 
th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}
</style>
</head>
<body>
  <form method="GET">
    <input type="text" name="search" value="<?= htmlspecialchars($hledani) ?>" placeholder="Hledat název nebo autora...">
    <select name="category">
      <option value="all" <?= ($kategorie === 'all' || empty($kategorie)) ? 'selected' : '' ?>>Všechny</option>
      <option value="IT" <?= ($kategorie === 'IT') ? 'selected' : '' ?>>IT</option>
      <option value="Sport" <?= ($kategorie === 'Sport') ? 'selected' : '' ?>>Sport</option>
    </select>
    <input type="submit" value="Filtrovat">
  </form>
 
  <table>
  <tr>
    <th>Nadpis</th>
    <th>Autor</th>
    <th>Kategorie</th>
  </tr>
 
  <?php foreach($filtrovane_clanky as $article): ?>
    <tr>
      <td><?= $article['heading'] ?></td>
      <td><?= $article['author'] ?></td>
      <td><?= $article['category'] ?></td>
    </tr>
  <?php endforeach; ?>
 
</table>

  <h3>Přidat nový článek</h3>
  <form method="POST">
    <input type="text" name="heading" placeholder="Název článku" required><br><br>
    <input type="text" name="author" placeholder="Autor" required><br><br>
    <select name="category" required>
      <option value="">-- Vyberte kategorii --</option>
      <option value="IT">IT</option>
      <option value="Sport">Sport</option>
    </select><br><br>
    <input type="submit" value="Přidat článek">
  </form>
</body>
</html>