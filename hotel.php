<?php require_once 'db.php';
$id = (int)($_GET['id'] ?? 0);
$check_in  = $_GET['check_in'] ?? '';
$check_out = $_GET['check_out'] ?? '';

$hstmt = $pdo->prepare("SELECT * FROM hotels WHERE hotel_id=?");
$hstmt->execute([$id]);
$hotel = $hstmt->fetch(PDO::FETCH_ASSOC);
if(!$hotel){ die("Hotel not found"); }

$imgs = $pdo->prepare("SELECT image_url FROM images WHERE hotel_id=?");
$imgs->execute([$id]);
$images = $imgs->fetchAll(PDO::FETCH_COLUMN);

$rstmt = $pdo->prepare("SELECT * FROM rooms WHERE hotel_id=? ORDER BY price ASC");
$rstmt->execute([$id]);
$rooms = $rstmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= e($hotel['name']); ?> — Details</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
  :root{--bg:#0f172a;--surface:#1f2937;--muted:#94a3b8;--text:#e5e7eb;--brand:#22c55e;--brand2:#06b6d4}
  body{margin:0;background:linear-gradient(120deg,var(--bg),#0b1020);font-family:Inter,system-ui,Arial;color:var(--text)}
  .wrap{max-width:1000px;margin:auto;padding:18px}
  .hero{background:#0b1324;border:1px solid #243047;border-radius:18px;overflow:hidden}
  .hero img{width:100%;height:360px;object-fit:cover;display:block}
  .p{padding:14px}
  .tag{display:inline-block;padding:6px 10px;border-radius:999px;background:#0f1a31;border:1px solid #253150;color:#9fb0cc}
  .grid{display:grid;grid-template-columns:1fr 320px;gap:16px;margin-top:16px}
  .panel{background:#0b1324;border:1px solid #243047;border-radius:16px;padding:14px}
  .room{display:flex;align-items:center;justify-content:space-between;border:1px solid #243047;border-radius:12px;padding:10px;margin-bottom:10px;background:#0e1729}
  .btn{cursor:pointer;border:0;border-radius:12px;padding:12px 14px;font-weight:700;background:linear-gradient(90deg,var(--brand),var(--brand2));color:#08111f}
  @media(max-width:900px){.grid{grid-template-columns:1fr}}
  .thumbs{display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:10px;margin-top:10px}
  .thumbs img{width:100%;height:90px;object-fit:cover;border-radius:10px;border:1px solid #243047}
</style>
</head>
<body>
<div class="wrap">
  <div class="hero">
    <img src="<?= e($images[0] ?? 'https://via.placeholder.com/1200x500?text=Hotel'); ?>" alt="<?= e($hotel['name']); ?>">
    <div class="p">
      <div class="tag"><?= e($hotel['location']); ?> • <?= e(number_format((float)$hotel['rating'],1)); ?>★ • <?= e($hotel['hotel_type']); ?></div>
      <h1 style="margin:8px 0 6px"><?= e($hotel['name']); ?></h1>
      <p style="color:#9fb0cc"><?= e($hotel['description']); ?></p>
      <div class="thumbs">
        <?php foreach ($images as $img): ?>
          <img src="<?= e($img); ?>" alt="Photo">
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <div class="grid">
    <div class="panel">
      <h3 style="margin-top:0">Available Rooms</h3>
      <?php foreach ($rooms as $r): ?>
        <div class="room">
          <div>
            <strong><?= e($r['room_type']); ?></strong>
            <div style="color:#9fb0cc">Max Guests: <?= (int)$r['max_guests']; ?> • Availability: <?= (int)$r['availability']; ?></div>
          </div>
          <div style="text-align:right">
            <div style="font-weight:800">PKR <?= number_format((float)$r['price']); ?>/night</div>
            <button class="btn" onclick="book(<?= (int)$hotel['hotel_id'];?>,<?= (int)$r['room_id'];?>)">Book</button>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="panel">
      <h3 style="margin-top:0">Your Dates</h3>
      <form id="dateForm">
        <input type="date" id="ci" class="in" style="width:100%;padding:10px;border-radius:10px;border:1px solid #243047;background:#0e1729;color:#e5e7eb;margin-bottom:8px" value="<?= e($check_in); ?>">
        <input type="date" id="co" class="in" style="width:100%;padding:10px;border-radius:10px;border:1px solid #243047;background:#0e1729;color:#e5e7eb;margin-bottom:8px" value="<?= e($check_out); ?>">
        <button class="btn" type="button" onclick="updateDates()">Apply</button>
      </form>
      <div style="color:#9fb0cc;margin-top:8px">Tip: Pehle dates select karein, phir Book dabayen.</div>
    </div>
  </div>
</div>
<script>
  function updateDates(){
    const ci=document.getElementById('ci').value;
    const co=document.getElementById('co').value;
    const url=new URL(window.location.href);
    if(ci) url.searchParams.set('check_in',ci);
    if(co) url.searchParams.set('check_out',co);
    window.location.href=url.toString();
  }
  function book(hotelId, roomId){
    const url=new URL('booking.php', window.location.origin+window.location.pathname);
    url.pathname = (window.location.pathname.replace(/[^\/]*$/, 'booking.php'));
    const params=new URLSearchParams();
    params.set('hotel_id',hotelId);
    params.set('room_id',roomId);
    const ci=new URL(window.location.href).searchParams.get('check_in')||'';
    const co=new URL(window.location.href).searchParams.get('check_out')||'';
    if(ci) params.set('check_in',ci);
    if(co) params.set('check_out',co);
    window.location.href=url.pathname+'?'+params.toString();
  }
</script>
</body>
</html>
