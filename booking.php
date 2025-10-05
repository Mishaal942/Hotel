<?php require_once 'db.php';

$hotel_id = (int)($_GET['hotel_id'] ?? $_POST['hotel_id'] ?? 0);
$room_id  = (int)($_GET['room_id'] ?? $_POST['room_id'] ?? 0);
$check_in = $_GET['check_in'] ?? $_POST['check_in'] ?? '';
$check_out= $_GET['check_out'] ?? $_POST['check_out'] ?? '';

$h = $pdo->prepare("SELECT * FROM hotels WHERE hotel_id=?"); $h->execute([$hotel_id]); $hotel = $h->fetch(PDO::FETCH_ASSOC);
$r = $pdo->prepare("SELECT * FROM rooms WHERE room_id=? AND hotel_id=?"); $r->execute([$room_id,$hotel_id]); $room = $r->fetch(PDO::FETCH_ASSOC);
if(!$hotel || !$room){ die("Invalid hotel/room"); }

$booking_id = null;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $check_in = $_POST['check_in'] ?? '';
    $check_out = $_POST['check_out'] ?? '';

    if ($full_name==='') $errors[]="Name required";
    if ($email==='') $errors[]="Email required";
    if ($check_in==='' || $check_out==='') $errors[]="Dates required";

    if (!$errors) {
        $nights = nights_between($check_in,$check_out);
        $total = $nights * (float)$room['price'];

        $ins = $pdo->prepare("INSERT INTO bookings (hotel_id, room_id, full_name, email, phone, check_in_date, check_out_date, total_price)
                              VALUES (?,?,?,?,?,?,?,?)");
        $ins->execute([$hotel_id,$room_id,$full_name,$email,$phone,$check_in,$check_out,$total]);
        $booking_id = (int)$pdo->lastInsertId();
        // JS Redirect (no PHP header redirect)
        echo "<script>window.location.href='confirmation.php?id=".$booking_id."';</script>";
        exit;
    }
}
$nights = $check_in && $check_out ? nights_between($check_in,$check_out) : 1;
$est_total = $nights * (float)$room['price'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Booking — <?= e($hotel['name']); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
  :root{--bg:#0f172a;--muted:#94a3b8;--text:#e5e7eb;--brand:#22c55e;--brand2:#06b6d4}
  body{margin:0;background:linear-gradient(120deg,var(--bg),#0b1020);font-family:Inter,system-ui,Arial;color:var(--text)}
  .wrap{max-width:900px;margin:auto;padding:18px}
  .grid{display:grid;grid-template-columns:1fr 320px;gap:16px}
  .panel{background:#0b1324;border:1px solid #243047;border-radius:16px;padding:14px}
  .in{background:#0e1729;border:1px solid #243047;border-radius:12px;padding:12px;color:#e5e7eb;width:100%;margin-bottom:10px}
  .btn{cursor:pointer;border:0;border-radius:12px;padding:12px 14px;font-weight:700;background:linear-gradient(90deg,var(--brand),var(--brand2));color:#08111f;width:100%}
  @media(max-width:900px){.grid{grid-template-columns:1fr}}
  .err{background:#3b0d16;border:1px solid #7a1f2e;color:#fecaca;padding:10px;border-radius:10px;margin-bottom:10px}
</style>
</head>
<body>
<div class="wrap">
  <h2 style="margin-top:0">Book Your Stay</h2>
  <?php if($errors): ?>
    <div class="err"><?= e(implode(' • ', $errors)); ?></div>
  <?php endif; ?>

  <div class="grid">
    <div class="panel">
      <form method="post">
        <input type="hidden" name="hotel_id" value="<?= (int)$hotel_id; ?>">
        <input type="hidden" name="room_id" value="<?= (int)$room_id; ?>">

        <label>Full Name</label>
        <input class="in" name="full_name" required>

        <label>Email</label>
        <input class="in" type="email" name="email" required>

        <label>Phone</label>
        <input class="in" name="phone" placeholder="+92...">

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
          <div>
            <label>Check-in</label>
            <input class="in" type="date" name="check_in" value="<?= e($check_in); ?>" required>
          </div>
          <div>
            <label>Check-out</label>
            <input class="in" type="date" name="check_out" value="<?= e($check_out); ?>" required>
          </div>
        </div>

        <button class="btn" type="submit">Confirm Booking</button>
      </form>
    </div>

    <div class="panel">
      <h3 style="margin-top:0"><?= e($hotel['name']); ?></h3>
      <div style="color:#9fb0cc"><?= e($hotel['location']); ?> • <?= e(number_format((float)$hotel['rating'],1)); ?>★</div>
      <div style="margin-top:8px"><strong>Room:</strong> <?= e($room['room_type']); ?></div>
      <div><strong>Price:</strong> PKR <?= number_format((float)$room['price']); ?>/night</div>
      <div style="margin-top:8px"><strong>Estimated Nights:</strong> <?= (int)$nights; ?></div>
      <div style="font-weight:800;margin-top:6px">Estimated Total: PKR <?= number_format((float)$est_total); ?></div>
    </div>
  </div>
</div>
</body>
</html>
