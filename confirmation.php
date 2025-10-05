<?php require_once 'db.php';
$id = (int)($_GET['id'] ?? 0);
$s = $pdo->prepare("SELECT b.*, h.name AS hotel_name, h.location, r.room_type, r.price FROM bookings b 
                    JOIN hotels h ON h.hotel_id=b.hotel_id
                    JOIN rooms r ON r.room_id=b.room_id
                    WHERE b.booking_id=?");
$s->execute([$id]);
$b = $s->fetch(PDO::FETCH_ASSOC);
if(!$b){ die("Booking not found"); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Booking Confirmation #<?= (int)$id; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
  :root{--bg:#0f172a;--muted:#94a3b8;--text:#e5e7eb;--brand:#22c55e;--brand2:#06b6d4}
  body{margin:0;background:linear-gradient(120deg,var(--bg),#0b1020);font-family:Inter,system-ui,Arial;color:var(--text)}
  .wrap{max-width:700px;margin:auto;padding:18px}
  .card{background:#0b1324;border:1px solid #243047;border-radius:16px;padding:16px}
  .ok{display:inline-block;padding:8px 12px;border-radius:999px;background:linear-gradient(90deg,var(--brand),var(--brand2));color:#08111f;font-weight:800}
  .row{display:grid;grid-template-columns:1fr 1fr;gap:10px}
  @media(max-width:700px){.row{grid-template-columns:1fr}}
  .btn{margin-top:12px;cursor:pointer;border:0;border-radius:12px;padding:12px 14px;font-weight:700;background:#0e1729;border:1px solid #243047;color:#e5e7eb}
</style>
</head>
<body>
<div class="wrap">
  <h2 style="margin-top:0">Booking Confirmed 🎉</h2>
  <div class="card">
    <div class="ok">#<?= (int)$id; ?></div>
    <h3 style="margin:10px 0 6px"><?= e($b['hotel_name']); ?></h3>
    <div style="color:#9fb0cc"><?= e($b['location']); ?> • Room: <?= e($b['room_type']); ?></div>
    <div class="row" style="margin-top:10px">
      <div><strong>Guest:</strong> <?= e($b['full_name']); ?> (<?= e($b['email']); ?>)</div>
      <div><strong>Phone:</strong> <?= e($b['phone']); ?></div>
      <div><strong>Check-in:</strong> <?= e($b['check_in_date']); ?></div>
      <div><strong>Check-out:</strong> <?= e($b['check_out_date']); ?></div>
      <div><strong>Total Paid:</strong> PKR <?= number_format((float)$b['total_price']); ?></div>
      <div><strong>Created:</strong> <?= e($b['created_at']); ?></div>
    </div>
    <button class="btn" onclick="goHome()">Back to Home</button>
  </div>
</div>
<script>
  function goHome(){ window.location.href='index.php'; }
</script>
</body>
</html>
