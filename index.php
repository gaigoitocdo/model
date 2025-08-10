<?php
// dashboard.php — Demo Receipt Hub (UI only, for learning/testing)
// Trang này chỉ phục vụ mục đích học tập & demo UI.
?>
<?php require_once('include/head.php'); ?>
<?php require_once('include/nav.php'); ?>

<style>
  :root{ --ink:#0f172a; --muted:#6b7280; --line:#e5e7eb; --bg:#0b1020; --card:#11162a; --glass:rgba(255,255,255,.06);} 
  body{ background: radial-gradient(1200px 600px at 50% -10%, #1d2550 0%, #0b1020 40%, #090b12 100%); }
  .page-wrap{ max-width: 1000px; margin: 0 auto; padding: 24px 16px 56px; }
  .hero{ text-align:center; padding:16px 0 8px; }
  .hero h1{ font-size: 24px; color:#fff; margin:0; }
  .hero p{ margin:6px 0 0; color:#aab0c0; font-size: 13px; }
  .badge{ display:inline-flex; align-items:center; gap:8px; border:1px solid #2b324a; background:var(--glass); color:#d1d5db; border-radius:999px; padding:6px 10px; font-size:12px; margin-top:8px; }
  .toolbar{ display:flex; gap:10px; flex-wrap:wrap; align-items:center; justify-content:center; margin:14px 0 18px; }
  .search{ flex:1; min-width:220px; max-width:300px; }
  .search input{ width:100%; height:36px; border-radius:8px; border:1px solid #27304a; background:rgba(255,255,255,.06); color:#e5e7eb; padding:0 12px; outline:none; }
  .tabs{ display:flex; gap:8px; flex-wrap:wrap; justify-content:center; }
  .tab{ padding:6px 10px; border-radius:999px; border:1px solid #2b324a; color:#cbd5e1; cursor:pointer; user-select:none; font-size:12px; }
  .tab.active{ background:rgba(255,255,255,.08); border-color:#47558a; color:#fff; }
  .section-title{ text-align:center; color:#cbd5e1; font-weight:700; margin:18px 0 8px; }
  .grid{ display:grid; gap:20px; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); justify-items:center; margin-top:20px; }
  .card-bank{ width:160px; background:linear-gradient(180deg, rgba(255,255,255,.06), rgba(255,255,255,.03)); border:1px solid #232a42; border-radius:16px; padding:14px; transition: all .25s ease; text-align:center; }
  .card-bank:hover{ transform: translateY(-3px); box-shadow:0 12px 28px rgba(0,0,0,.35); border-color:#3e4a73; }
  .bank-logo-wrapper{ height:56px; display:flex; align-items:center; justify-content:center; margin-bottom:8px; }
  .bank-logo{ max-height:50px; max-width:100%; object-fit:contain; filter: drop-shadow(0 6px 14px rgba(0,0,0,.35)); }
  .bank-name{ color:#e5e7eb; font-weight:600; }
  .bank-status{ font-size:12px; margin-top:2px; }
  .st-ok{ color:#34d399; } .st-soon{ color:#f87171; }
  .btn{ display:inline-flex; align-items:center; justify-content:center; gap:8px; width:100%; margin-top:8px; height:34px; border-radius:8px; border:1px solid #2b324a; background:rgba(255,255,255,.05); color:#e5e7eb; font-weight:600; font-size:12px; text-decoration:none; transition:all .2s; }
  .btn:hover{ background:rgba(255,255,255,.1); border-color:#45507a; }
  .btn:disabled{ opacity:.5; cursor:not-allowed; }
  .disclaimer{ font-size:12px; color:#9aa3b4; margin-top:12px; text-align:center; }
  .watermark-tip{ font-size:11px; color:#8b97ad; }
  .pill{ display:inline-flex; align-items:center; gap:6px; font-size:11px; padding:6px 10px; border-radius:999px; border:1px dashed #3a456e; color:#cbd5e1; }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="page-wrap">

    <div class="hero">
      <h1>Kho Giao Diện Hóa Đơn Demo</h1>
      <p>Giao diện luyện tập tạo hóa đơn/biên lai <strong>(demo)</strong> — luôn kèm watermark "SAMPLE" để học tập an toàn.</p>
      <span class="badge">🛡️ Chỉ Dùng Demo • Luôn Có Watermark</span>
    </div>

    <div class="toolbar">
      <div class="search">
        <input id="searchBox" type="text" placeholder="Tìm ngân hàng (MBBank, ACB, Vietcombank...)" oninput="filterBanks()" />
      </div>
      <div class="tabs" id="tabs">
        <div class="tab active" data-type="receipt" onclick="switchTab(this)">Mẫu biên lai</div>
        <div class="tab" data-type="balance" onclick="switchTab(this)">Mẫu số dư</div>
        <div class="tab" data-type="ledger" onclick="switchTab(this)">Mẫu biến động</div>
      </div>
    </div>

    <div class="section-title">Ngân hàng phổ biến</div>
    <div class="grid" id="bankGrid">
      <?php
        // Danh sách ngân hàng hiển thị
        $banks = [
          ['key'=>'momo','name'=>'MoMo','logo'=>'https://i.imgur.com/e5S4ykm.png','ok'=>false],
          ['key'=>'mbbank','name'=>'MBBank','logo'=>'https://i.imgur.com/TRv85q8.png','ok'=>true],
          ['key'=>'acb','name'=>'ACB Bank','logo'=>'https://i.imgur.com/oJPKN3C.png','ok'=>true],
          ['key'=>'techcom','name'=>'Techcombank','logo'=>'https://i.imgur.com/sgLMGn6.png','ok'=>true],
          ['key'=>'agribank','name'=>'Agribank','logo'=>'https://i.imgur.com/anbwDQk.png','ok'=>false],
          ['key'=>'vietin','name'=>'VietinBank','logo'=>'https://ipay.vietinbank.vn/logo.png','ok'=>true],
          ['key'=>'vcb','name'=>'Vietcombank','logo'=>'https://i.imgur.com/7JYXAos.png','ok'=>true],
        ];

        // Map link thực tế trong /mod (bỏ /mod/invoice.php/...)
        function link_for_bill($k){
          $map = [
            'mbbank'  => '/mod/mb-bank.php',
            'acb'     => '/mod/acb.php',
            'techcom' => '/mod/techcombank.php',
            'vietin'  => '/mod/vietinbank.php',
            'vcb'     => '/mod/vietcombank.php',
          ];
          return $map[$k] ?? '';
        }
        function link_for_balance($k){
          $map = [
            'mbbank'  => '/mod/sodu-mbbank.php',
            'techcom' => '/mod/sodu-techcombank.php',
          ];
          return $map[$k] ?? '';
        }
        $ledgerLink = '/mod/biendong.php';

        foreach($banks as $b):
          $k = $b['key'];
          $bill = link_for_bill($k);
          $bal  = link_for_balance($k);
      ?>
        <div class="bank-card" data-name="<?= htmlspecialchars(strtolower($b['name'])) ?>">
          <div class="card-bank">
            <div class="bank-logo-wrapper">
              <img class="bank-logo" src="<?= htmlspecialchars($b['logo']) ?>" alt="<?= htmlspecialchars($b['name']) ?>" />
            </div>
            <div class="bank-name"><?= htmlspecialchars($b['name']) ?></div>
            <div class="bank-status <?= $b['ok']?'st-ok':'st-soon' ?>">
              <?= $b['ok']? 'Hoạt động' : 'Sắp có' ?>
            </div>
            <?php if($b['ok']): ?>
              <?php if($bill): ?>
                <a class="btn" href="<?= $bill ?>" title="Mở mẫu bill">Mở mẫu bill</a>
              <?php else: ?>
                <button class="btn" disabled>Chưa có file bill</button>
              <?php endif; ?>

              <?php if($bal): ?>
                <a class="btn" href="<?= $bal ?>" title="Mẫu số dư">Mẫu số dư</a>
              <?php else: ?>
                <button class="btn" disabled>Mẫu số dư: chưa có</button>
              <?php endif; ?>

              <a class="btn" href="<?= $ledgerLink ?>" title="Mẫu biến động">Mẫu biến động</a>
            <?php else: ?>
              <button class="btn" disabled>Đang phát triển</button>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="disclaimer">
      <div class="pill">⚠️ Chỉ dùng cho học tập & demo UI • Không phải chứng từ tài chính hợp lệ</div>
      <div class="watermark-tip" style="margin-top:8px;">Tất cả mẫu xuất ra phải có watermark "SAMPLE – NOT A FINANCIAL DOCUMENT" hoặc chú thích tương đương.</div>
    </div>

  </div>
</div>

<script>
  function switchTab(node){
    document.querySelectorAll('.tab').forEach(t=>t.classList.remove('active'));
    node.classList.add('active');
  }
  function filterBanks(){
    const q = (document.getElementById('searchBox').value || '').trim().toLowerCase();
    document.querySelectorAll('#bankGrid .bank-card').forEach(card=>{
      const name = card.getAttribute('data-name');
      card.style.display = name.includes(q) ? '' : 'none';
    });
  }
</script>

<?php require_once('include/foot.php'); ?>
