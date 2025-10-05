<?php require_once 'db.php';

$q = trim($_GET['q'] ?? '');
$check_in  = $_GET['check_in'] ?? '';
$check_out = $_GET['check_out'] ?? '';
$hotel_type = $_GET['hotel_type'] ?? '';
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';
$min_rating = $_GET['min_rating'] ?? '';
$sort = $_GET['sort'] ?? 'relevance';

$sql = "SELECT h.*, (SELECT image_url FROM images i WHERE i.hotel_id=h.hotel_id LIMIT 1) AS img
        FROM hotels h WHERE 1=1";
$args = [];

if ($q !== '') { $sql .= " AND (h.location LIKE :q OR h.name LIKE :q2)"; $args[':q']="%$q%"; $args[':q2']="%$q%"; }
if ($hotel_type !== '') { $sql .= " AND h.hotel_type = :t"; $args[':t']=$hotel_type; }
if ($min_price !== '') { $sql .= " AND h.price_per_night >= :minp"; $args[':minp']=(float)$min_price; }
if ($max_price !== '') { $sql .= " AND h.price_per_night <= :maxp"; $args[':maxp']=(float)$max_price; }
if ($min_rating !== '') { $sql .= " AND h.rating >= :minr"; $args[':minr']=(float)$min_rating; }

switch($sort){
    case 'price_asc': $sql .= " ORDER BY h.price_per_night ASC"; break;
    case 'price_desc': $sql .= " ORDER BY h.price_per_night DESC"; break;
    case 'rating_desc': $sql .= " ORDER BY h.rating DESC, h.price_per_night DESC"; break;
    default: $sql .= " ORDER BY h.rating DESC, h.price_per_night DESC";
}

$stmt = $pdo->prepare($sql);
$stmt->execute($args);
$hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Search Results — Hotels.com Clone</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
    :root{--bg:#0f172a;--card:#111827;--muted:#94a3b8;--text:#e5e7eb;--brand:#22c55e;--brand2:#06b6d4;--surface:#1f2937}
    body{margin:0;background:linear-gradient(120deg,var(--bg),#0b1020);font-family:Inter,system-ui,Arial;color:var(--text)}
    .wrap{max-width:1100px;margin:auto;padding:18px}
    .bar{display:grid;gap:10px;grid-template-columns:1.2fr repeat(2,1fr) repeat(2,1fr) .8fr}
    .in{background:#0b1324;border:1px solid #253150;color:var(--text);outline:none;border-radius:12px;padding:12px}
    .btn{cursor:pointer;border:0;border-radius:12px;padding:12px 14px;font-weight:700;background:linear-gradient(90deg,var(--brand),var(--brand2));color:#08111f}
    .grid{display:grid;grid-template-columns:260px 1fr;gap:16px;margin-top:16px}
    .panel{background:#0b1324;border:1px solid #243047;border-radius:16px;padding:14px}
    .filters .in{width:100%;margin-bottom:10px}
    .hotel{display:grid;grid-template-columns:220px 1fr;gap:12px;background:#0b1324;border:1px solid #243047;border-radius:18px;overflow:hidden}
    .hotel img{width:100%;height:160px;object-fit:cover}
    .hotel .p{padding:12px}
    .tag{display:inline-block;padding:6px 10px;border-radius:999px;background:#0f1a31;border:1px solid #253150;color:#9fb0cc;font-size:.8rem}
    .price{font-size:1.1rem;font-weight:800;background:linear-gradient(90deg,#f59e0b,var(--brand));-webkit-background-clip:text;color:transparent}
    @media(max-width:900px){.grid{grid-template-columns:1fr}.hotel{grid-template-columns:1fr}}
</style>
</head>
<body>
<div class="wrap">
  <form class="bar" method="get" action="search.php">
    <input class="in" type="text" name="q" placeholder="Destination" value="<?= e($q) ?>">
    <input class="in" type="date" name="check_in" value="<?= e($check_in) ?>">
    <input class="in" type="date" name="check_out" value="<?= e($check_out) ?>">
    <select class="in" name="sort">
      <option value="relevance" <?= $sort==='relevance'?'selected':'';?>>Best match</option>
      <option value="price_asc" <?= $sort==='price_asc'?'selected':'';?>>Price ↑</option>
      <option value="price_desc" <?= $sort==='price_desc'?'selected':'';?>>Price ↓</option>
      <option value="rating_desc" <?= $sort==='rating_desc'?'selected':'';?>>Top rated</option>
    </select>
    <button class="btn">Update</button>
  </form>

  <div class="grid">
    <div class="panel filters">
      <h3 style="margin-top:0">Filters</h3>
      <form method="get" action="search.php">
        <input type="hidden" name="q" value="<?= e($q) ?>">
        <input type="hidden" name="check_in" value="<?= e($check_in) ?>">
        <input type="hidden" name="check_out" value="<?= e($check_out) ?>">
        <input class="in" name="min_price" type="number" placeholder="Min Price" value="<?= e($min_price) ?>">
        <input class="in" name="max_price" type="number" placeholder="Max Price" value="<?= e($max_price) ?>">
        <select class="in" name="hotel_type">
          <option value="">Any Type</option>
          <option <?= $hotel_type==='Luxury'?'selected':'';?>>Luxury</option>
          <option <?= $hotel_type==='Resort'?'selected':'';?>>Resort</option>
          <option <?= $hotel_type==='Budget'?'selected':'';?>>Budget</option>
        </select>
        <select class="in" name="min_rating">
          <option value="">Any Rating</option>
          <option value="3" <?= $min_rating==='3'?'selected':'';?>>3+ stars</option>
          <option value="4" <?= $min_rating==='4'?'selected':'';?>>4+ stars</option>
          <option value="4.5" <?= $min_rating==='4.5'?'selected':'';?>>4.5+ stars</option>
        </select>
        <select class="in" name="sort">
          <option value="relevance" <?= $sort==='relevance'?'selected':'';?>>Best match</option>
          <option value="price_asc" <?= $sort==='price_asc'?'selected':'';?>>Price ↑</option>
          <option value="price_desc" <?= $sort==='price_desc'?'selected':'';?>>Price ↓</option>
          <option value="rating_desc" <?= $sort==='rating_desc'?'selected':'';?>>Top rated</option>
        </select>
        <button class="btn" type="submit">Apply Filters</button>
      </form>
    </div>

    <div style="display:grid;gap:12px">
      <div class="panel" style="display:flex;justify-content:space-between;align-items:center">
        <div><strong><?= count($hotels); ?></strong> results for <em><?= e($q ?: 'All'); ?></em></div>
        <div style="color:#9fb0cc">Dates: <?= e($check_in ?: '—'); ?> → <?= e($check_out ?: '—'); ?></div>
      </div>

      <?php if(!$hotels): ?>
        <div class="panel">No hotels found. Try adjusting filters.</div>
      <?php else: foreach ($hotels as $h): ?>
        <div class="hotel">
          <div><img src="<?= e($h['img'] ?: 'https://via.placeholder.com/900x500?text=Hotel'); ?>" alt="<?= e($h['name']); ?>"></div>
          <div class="p">
            <div class="tag"><?= e($h['location']); ?> • <?= e(number_format((float)$h['rating'],1)); ?>★ • <?= e($h['hotel_type']); ?></div>
            <h3 style="margin:8px 0 6px"><?= e($h['name']); ?></h3>
            <p style="color:#9fb0cc"><?= e($h['description']); ?></p>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-top:8px">
              <span class="price">PKR <?= number_format((float)$h['price_per_night']); ?>/night</span>
              <button class="btn" onclick="viewHotel(<?= (int)$h['hotel_id'];?>)">View</button>
            </div>
          </div>
        </div>
      <?php endforeach; endif; ?>
    </div>
  </div>
</div>
<script>
  function viewHotel(id){ window.location.href = 'hotel.php?id='+encodeURIComponent(id)+
    '<?= $check_in? '&check_in='.urlencode($check_in):''; ?>' + 
    '<?= $check_out? '&check_out='.urlencode($check_out):''; ?>'; }
</script>
</body>
</html>
