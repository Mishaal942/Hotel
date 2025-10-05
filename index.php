<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Hotels.com Clone — Home</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');
    
    :root{
        --bg-primary: #0a0e27;
        --bg-secondary: #131830;
        --card-bg: #1a1f3a;
        --card-hover: #222847;
        --text-primary: #ffffff;
        --text-secondary: #b8c5d6;
        --text-muted: #7b8ba8;
        --brand-primary: #00d4ff;
        --brand-secondary: #0099ff;
        --accent-gold: #ffd700;
        --accent-orange: #ff6b35;
        --success: #00e676;
        --danger: #ff5252;
        --border-color: #2a3555;
        --shadow-sm: 0 2px 8px rgba(0,0,0,0.1);
        --shadow-md: 0 4px 16px rgba(0,0,0,0.2);
        --shadow-lg: 0 8px 32px rgba(0,0,0,0.3);
        --shadow-xl: 0 12px 48px rgba(0,0,0,0.4);
    }
    
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #0a0e27 0%, #1a1f3a 50%, #0f1429 100%);
        background-attachment: fixed;
        color: var(--text-primary);
        overflow-x: hidden;
        position: relative;
    }
    
    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: 
            radial-gradient(circle at 20% 30%, rgba(0, 212, 255, 0.08) 0%, transparent 50%),
            radial-gradient(circle at 80% 70%, rgba(255, 107, 53, 0.06) 0%, transparent 50%);
        pointer-events: none;
        z-index: 0;
    }
    
    header {
        position: sticky;
        top: 0;
        background: rgba(10, 14, 39, 0.85);
        backdrop-filter: blur(20px) saturate(180%);
        border-bottom: 1px solid rgba(42, 53, 85, 0.5);
        z-index: 1000;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.2);
    }
    
    .nav {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 24px;
        gap: 20px;
    }
    
    .logo {
        font-weight: 900;
        font-size: 1.5rem;
        letter-spacing: -0.5px;
        background: linear-gradient(135deg, var(--brand-primary) 0%, var(--brand-secondary) 50%, var(--accent-gold) 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: 0 0 30px rgba(0, 212, 255, 0.3);
        position: relative;
        animation: logoGlow 3s ease-in-out infinite;
    }
    
    @keyframes logoGlow {
        0%, 100% { filter: brightness(1); }
        50% { filter: brightness(1.2); }
    }
    
    .chip {
        padding: 10px 20px;
        border: 1px solid rgba(0, 212, 255, 0.3);
        border-radius: 50px;
        color: var(--text-secondary);
        font-size: 0.85rem;
        font-weight: 500;
        background: rgba(26, 31, 58, 0.5);
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }
    
    .chip:hover {
        border-color: var(--brand-primary);
        background: rgba(0, 212, 255, 0.1);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 212, 255, 0.2);
    }
    
    .hero {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 24px 60px;
        position: relative;
        z-index: 1;
    }
    
    .card {
        background: linear-gradient(145deg, rgba(26, 31, 58, 0.9) 0%, rgba(19, 24, 48, 0.9) 100%);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(42, 53, 85, 0.6);
        border-radius: 24px;
        padding: 32px;
        box-shadow: 
            var(--shadow-xl),
            inset 0 1px 0 rgba(255,255,255,0.05),
            0 0 0 1px rgba(0, 212, 255, 0.05);
        position: relative;
        overflow: hidden;
        transition: all 0.4s ease;
    }
    
    .card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(
            45deg,
            transparent 30%,
            rgba(0, 212, 255, 0.03) 50%,
            transparent 70%
        );
        animation: shimmer 6s infinite;
    }
    
    @keyframes shimmer {
        0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
        100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
    }
    
    .card:hover {
        transform: translateY(-4px);
        box-shadow: 
            0 16px 64px rgba(0, 0, 0, 0.5),
            0 0 0 1px rgba(0, 212, 255, 0.2);
        border-color: rgba(0, 212, 255, 0.4);
    }
    
    .search-grid {
        display: grid;
        grid-template-columns: 1.6fr repeat(3, 1fr) 0.9fr;
        gap: 14px;
        position: relative;
        z-index: 1;
    }
    
    .in {
        background: rgba(10, 14, 39, 0.6);
        border: 2px solid rgba(42, 53, 85, 0.5);
        color: var(--text-primary);
        outline: none;
        border-radius: 16px;
        padding: 16px 18px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.95rem;
        font-weight: 400;
        transition: all 0.3s ease;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.2);
    }
    
    .in:focus {
        border-color: var(--brand-primary);
        background: rgba(10, 14, 39, 0.9);
        box-shadow: 
            inset 0 2px 4px rgba(0,0,0,0.3),
            0 0 0 4px rgba(0, 212, 255, 0.1),
            0 4px 12px rgba(0, 212, 255, 0.2);
        transform: translateY(-2px);
    }
    
    .in::placeholder {
        color: var(--text-muted);
    }
    
    .btn {
        cursor: pointer;
        border: none;
        border-radius: 16px;
        padding: 16px 24px;
        font-weight: 700;
        font-size: 0.95rem;
        font-family: 'Poppins', sans-serif;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-md);
    }
    
    .btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }
    
    .btn:hover::before {
        width: 300px;
        height: 300px;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, var(--brand-primary) 0%, var(--brand-secondary) 100%);
        color: #ffffff;
        box-shadow: 
            0 4px 16px rgba(0, 153, 255, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
        position: relative;
        z-index: 1;
    }
    
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 
            0 8px 24px rgba(0, 153, 255, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
    }
    
    .btn-primary:active {
        transform: translateY(-1px);
    }
    
    h2 {
        margin: 48px 0 24px;
        font-size: 2rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--text-primary) 0%, var(--text-secondary) 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        letter-spacing: -0.5px;
    }
    
    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 24px;
        margin-top: 24px;
    }
    
    .hotel {
        overflow: hidden;
        border-radius: 20px;
        border: 1px solid rgba(42, 53, 85, 0.5);
        background: linear-gradient(145deg, rgba(26, 31, 58, 0.8) 0%, rgba(19, 24, 48, 0.8) 100%);
        backdrop-filter: blur(10px);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        box-shadow: var(--shadow-md);
    }
    
    .hotel::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(0, 212, 255, 0.1) 0%, rgba(255, 107, 53, 0.1) 100%);
        opacity: 0;
        transition: opacity 0.4s ease;
        z-index: 1;
        pointer-events: none;
    }
    
    .hotel:hover::before {
        opacity: 1;
    }
    
    .hotel:hover {
        transform: translateY(-12px) scale(1.02);
        border-color: rgba(0, 212, 255, 0.5);
        box-shadow: 
            0 20px 60px rgba(0, 0, 0, 0.4),
            0 0 0 1px rgba(0, 212, 255, 0.3),
            0 0 40px rgba(0, 212, 255, 0.15);
    }
    
    .hotel img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        display: block;
        transition: transform 0.6s ease;
        position: relative;
    }
    
    .hotel:hover img {
        transform: scale(1.1);
    }
    
    .hotel .p {
        padding: 20px;
        position: relative;
        z-index: 2;
    }
    
    .tag {
        display: inline-block;
        padding: 8px 14px;
        border-radius: 50px;
        background: linear-gradient(135deg, rgba(0, 212, 255, 0.15) 0%, rgba(0, 153, 255, 0.15) 100%);
        border: 1px solid rgba(0, 212, 255, 0.3);
        color: var(--brand-primary);
        font-size: 0.8rem;
        font-weight: 600;
        backdrop-filter: blur(10px);
        box-shadow: 0 2px 8px rgba(0, 212, 255, 0.1);
        transition: all 0.3s ease;
    }
    
    .hotel:hover .tag {
        background: linear-gradient(135deg, rgba(0, 212, 255, 0.25) 0%, rgba(0, 153, 255, 0.25) 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 212, 255, 0.2);
    }
    
    .hotel h3 {
        margin: 12px 0 8px;
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--text-primary);
        letter-spacing: -0.3px;
        transition: color 0.3s ease;
    }
    
    .hotel:hover h3 {
        color: var(--brand-primary);
    }
    
    .hotel p {
        color: var(--text-secondary);
        line-height: 1.6;
        font-size: 0.9rem;
        min-height: 48px;
        margin-bottom: 16px;
    }
    
    .price {
        font-size: 1.4rem;
        font-weight: 900;
        background: linear-gradient(135deg, var(--accent-gold) 0%, var(--accent-orange) 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        letter-spacing: -0.5px;
        text-shadow: 0 0 20px rgba(255, 215, 0, 0.3);
        animation: priceGlow 2s ease-in-out infinite;
    }
    
    @keyframes priceGlow {
        0%, 100% { filter: brightness(1); }
        50% { filter: brightness(1.2); }
    }
    
    .hotel .btn {
        background: linear-gradient(135deg, rgba(0, 212, 255, 0.2) 0%, rgba(0, 153, 255, 0.2) 100%);
        color: var(--brand-primary);
        border: 1px solid rgba(0, 212, 255, 0.4);
        padding: 12px 24px;
        font-size: 0.9rem;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(0, 212, 255, 0.15);
    }
    
    .hotel .btn:hover {
        background: linear-gradient(135deg, var(--brand-primary) 0%, var(--brand-secondary) 100%);
        color: #ffffff;
        border-color: var(--brand-primary);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 212, 255, 0.4);
    }
    
    .footer {
        max-width: 1200px;
        margin: 60px auto 40px;
        padding: 32px 24px;
        text-align: center;
        color: var(--text-muted);
        font-size: 0.9rem;
        border-top: 1px solid rgba(42, 53, 85, 0.3);
        position: relative;
        z-index: 1;
    }
    
    /* Responsive Design */
    @media(max-width: 1024px) {
        .search-grid {
            grid-template-columns: 1fr 1fr;
        }
        
        .grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
    }
    
    @media(max-width: 768px) {
        .nav {
            flex-direction: column;
            text-align: center;
            gap: 12px;
        }
        
        .logo {
            font-size: 1.3rem;
        }
        
        .hero {
            padding: 24px 16px 40px;
        }
        
        .card {
            padding: 24px 20px;
            border-radius: 20px;
        }
        
        .search-grid {
            grid-template-columns: 1fr;
            gap: 12px;
        }
        
        h2 {
            font-size: 1.6rem;
            margin: 32px 0 20px;
        }
        
        .grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }
        
        .hotel img {
            height: 180px;
        }
    }
    
    @media(max-width: 480px) {
        .logo {
            font-size: 1.1rem;
        }
        
        .chip {
            font-size: 0.75rem;
            padding: 8px 16px;
        }
        
        .card {
            padding: 20px 16px;
        }
        
        .in {
            padding: 14px 16px;
            font-size: 0.9rem;
        }
        
        .btn {
            padding: 14px 20px;
            font-size: 0.9rem;
        }
        
        h2 {
            font-size: 1.4rem;
        }
        
        .hotel h3 {
            font-size: 1.15rem;
        }
        
        .price {
            font-size: 1.2rem;
        }
    }
    
    /* Loading Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .hotel {
        animation: fadeIn 0.6s ease forwards;
    }
    
    .hotel:nth-child(1) { animation-delay: 0.1s; }
    .hotel:nth-child(2) { animation-delay: 0.2s; }
    .hotel:nth-child(3) { animation-delay: 0.3s; }
    .hotel:nth-child(4) { animation-delay: 0.4s; }
    .hotel:nth-child(5) { animation-delay: 0.5s; }
    .hotel:nth-child(6) { animation-delay: 0.6s; }
    
    /* Scrollbar Styling */
    ::-webkit-scrollbar {
        width: 10px;
    }
    
    ::-webkit-scrollbar-track {
        background: var(--bg-primary);
    }
    
    ::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, var(--brand-primary) 0%, var(--brand-secondary) 100%);
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, var(--brand-secondary) 0%, var(--brand-primary) 100%);
    }
</style>
</head>
<body>
<header>
  <div class="nav">
    <div class="logo">Hotels.com Clone</div>
    <div class="chip">Search • Book • Stay</div>
  </div>
</header>

<section class="hero">
  <div class="card">
    <form id="searchForm" class="search-grid" action="search.php" method="get">
      <input class="in" type="text" name="q" placeholder="Destination (e.g., Lahore, Karachi, Islamabad)" required>
      <input class="in" type="date" name="check_in" required>
      <input class="in" type="date" name="check_out" required>
      <select class="in" name="hotel_type">
        <option value="">Any Type</option>
        <option>Luxury</option>
        <option>Resort</option>
        <option>Budget</option>
      </select>
      <button class="btn btn-primary" type="submit">Search</button>
    </form>
  </div>

  <h2 style="margin:48px 0 24px">Featured & Top Rated</h2>
  <div class="grid">
    <?php
      $stmt = $pdo->query("SELECT h.*, (SELECT image_url FROM images i WHERE i.hotel_id=h.hotel_id LIMIT 1) AS img FROM hotels h ORDER BY rating DESC, price_per_night DESC LIMIT 6");
      foreach ($stmt as $h):
    ?>
      <div class="hotel">
        <img src="<?= e($h['img'] ?: 'https://via.placeholder.com/900x500?text=Hotel'); ?>" alt="<?= e($h['name']); ?>">
        <div class="p">
          <div class="tag"><?= e($h['location']); ?> • <?= e(number_format((float)$h['rating'],1)); ?>★</div>
          <h3><?= e($h['name']); ?></h3>
          <p><?= e($h['description']); ?></p>
          <div style="display:flex;align-items:center;justify-content:space-between;margin-top:8px">
            <span class="price">PKR <?= number_format((float)$h['price_per_night']); ?>/night</span>
            <button class="btn" onclick="gotoHotel(<?= (int)$h['hotel_id'];?>)">View</button>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<div class="footer">© <?= date('Y'); ?> Hotels.com Clone — Built with PHP, internal CSS & JS</div>

<script>
  // JS Redirection helper
  function gotoHotel(id){ window.location.href = 'hotel.php?id='+encodeURIComponent(id); }
</script>
</body>
</html>
