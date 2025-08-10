<?php require_once('../include/head.php'); ?>
<?php require_once('../include/nav.php'); ?>
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card" style="max-width: 1000px; margin: auto;">
    <div class="card-body">
      <div class="row justify-content-center">
        <div class="col-md-5">
          <li class="d-flex mb-4 pb-1">
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-0">Fake Bill Chuyển Tiền: <b style="color:#00e3cc;">ACB Bank</b>
                </h6>
              </div>
            </div>
          </li>
          <form id="td-acb" method="POST">
            <input name="forbank" value="acb" hidden="">
            <div id="namegui" class="row mb-3">
              <label class="col-sm-3 col-form-label" for="thanhdieudeptrai">Tên của bạn</label>
              <div class="col-sm-9">
                <input type="text" id="name_gui" name="name_gui" class="form-control" required placeholder="Tên người chuyển">
              </div>
            </div>
            <div id="stkgui" class="row mb-3">
              <label class="col-sm-3 col-form-label" for="thanhdieudeptrai">STK của bạn</label>
              <div class="col-sm-9">
                <input type="text" id="stk_gui" name="stk_gui" class="form-control" required placeholder="Số tài khoản người chuyển">
              </div>
            </div>
            <div id="bank1" class="row mb-3">
              <label class="col-sm-3 col-form-label" for="thanhdieudeptrai">Tên ngân hàng người nhận</label>
              <div class="col-sm-9">
                <select required="" id="bank" name="bank" class="form-control" onchange="chonBank()">
                  <?php
                  // Hardcode danh sách ngân hàng để tránh lỗi API
                  $banks = [
                    ['name' => 'Ngân hàng TMCP Công thương Việt Nam', 'shortName' => 'VietinBank', 'code' => 'ICB'],
                    ['name' => 'Ngân hàng TMCP Ngoại Thương Việt Nam', 'shortName' => 'Vietcombank', 'code' => 'VCB'],
                    ['name' => 'Ngân hàng TMCP Đầu tư và Phát triển Việt Nam', 'shortName' => 'BIDV', 'code' => 'BIDV'],
                    ['name' => 'Ngân hàng Nông nghiệp và Phát triển Nông thôn Việt Nam', 'shortName' => 'Agribank', 'code' => 'VBA'],
                    ['name' => 'Ngân hàng TMCP Phương Đông', 'shortName' => 'OCB', 'code' => 'OCB'],
                    ['name' => 'Ngân hàng TMCP Quân đội', 'shortName' => 'MBBank', 'code' => 'MB'],
                    ['name' => 'Ngân hàng TMCP Kỹ thương Việt Nam', 'shortName' => 'Techcombank', 'code' => 'TCB'],
                    ['name' => 'Ngân hàng TMCP Á Châu', 'shortName' => 'ACB', 'code' => 'ACB'],
                    ['name' => 'Ngân hàng TMCP Việt Nam Thịnh Vượng', 'shortName' => 'VPBank', 'code' => 'VPB'],
                    ['name' => 'Ngân hàng TMCP Sài Gòn Thương Tín', 'shortName' => 'Sacombank', 'code' => 'STB'],
                    ['name' => 'Ngân hàng TMCP Xuất Nhập khẩu Việt Nam', 'shortName' => 'Eximbank', 'code' => 'EIB'],
                    ['name' => 'Ngân hàng TMCP Phát triển TP. Hồ Chí Minh', 'shortName' => 'HDBank', 'code' => 'HDB'],
                    ['name' => 'Ngân hàng TMCP Liên Việt', 'shortName' => 'LienVietPostBank', 'code' => 'LPB'],
                    ['name' => 'Ngân hàng TMCP Tiên Phong', 'shortName' => 'TPBank', 'code' => 'TPB'],
                    ['name' => 'Ngân hàng TMCP Sài Gòn - Hà Nội', 'shortName' => 'SHB', 'code' => 'SHB'],
                    ['name' => 'Ngân hàng TMCP Đông Nam Á', 'shortName' => 'SeABank', 'code' => 'SEAB'],
                    ['name' => 'Ngân hàng TMCP Bản Việt', 'shortName' => 'VietCapitalBank', 'code' => 'BVB'],
                    ['name' => 'Ngân hàng TMCP Việt Á', 'shortName' => 'VietABank', 'code' => 'VAB'],
                    ['name' => 'Ngân hàng TMCP Nam Á', 'shortName' => 'NamABank', 'code' => 'NAB'],
                    ['name' => 'Ngân hàng TMCP Bảo Việt', 'shortName' => 'BaoVietBank', 'code' => 'BVB'],
                    // Thêm các ngân hàng khác nếu cần từ nguồn khác, nhưng danh sách này đã bao quát phổ biến
                  ];

                  $options = '';
                  foreach ($banks as $item) {
                    $options .= '<option ant="' . htmlspecialchars($item['shortName']) . '" int="' . htmlspecialchars($item['code']) . '" value="' . htmlspecialchars($item['name']) . '">' . htmlspecialchars($item['shortName']) . '</option>';
                  }
                  echo $options;
                  ?>
                </select>
              </div>
            </div>
            <script>
              function chonBank() {
                var selectElement = document.getElementById("bank");
                var selectedOption = selectElement.options[selectElement.selectedIndex];
                var intValues = selectedOption.getAttribute("int");
                document.getElementById('code').value = intValues;
                var selectElement = document.getElementById("bank");
                var selectedOption = selectElement.options[selectElement.selectedIndex];
                var intValues = selectedOption.getAttribute("ant");
                document.getElementById('code1').value = intValues;
              }
            </script>
            <input id="code1" value="Vietinbank" name="code1" hidden="">
            <input id="code" value="ICB" name="code" hidden="">
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="thanhdieudeptrai">STK nhận</label>
              <div class="col-sm-9">
                <input type="number" id="stk" name="stk" required="" class="form-control" placeholder="Số tài khoản người nhận">
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="thanhdieudeptrai">Tên người nhận</label>
              <div class="col-sm-9">
                <input type="text" id="name_nhan" name="name_nhan" required="" class="form-control" placeholder="Tên người nhận">
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="thanhdieudeptrai">Số tiền chuyển</label>
              <div class="col-sm-9">
                <input type="number" id="amount" name="amount" required="" class="form-control" placeholder="Ví dụ: 100000">
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="thanhdieudeptrai">Nội dung chuyển khoản</label>
              <div class="col-sm-9">
                <textarea type="text" id="noidung" name="noidung" required class="form-control" placeholder="chuyển tiền"></textarea>
              </div>
            </div>
            <div class="row mb-3" id="magiaodichx">
              <label class="col-sm-3 col-form-label" for="thanhdieudeptrai">Mã giao dịch</label>
              <div class="col-sm-9">
                <input type="text" id="magiaodich" name="magiaodich" class="form-control" placeholder="Mã giao dịch" value="<?php echo(rand(1000000000,10000000000));?>">
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="thanhdieudeptrai">Ngày lập lệnh</label>
              <div class="col-sm-9">
                <input type="text" id="time1" name="time1" required="" class="form-control" placeholder="Time" value="<?php date_default_timezone_set('Asia/Ho_Chi_Minh');echo date('d/m/Y - H:i:s');?>">
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="thanhdieudeptrai">Ngày hiệu lực</label>
              <div class="col-sm-9">
                <input type="text" id="time2" name="time2" disabled class="form-control" placeholder="Time" value="<?php date_default_timezone_set('Asia/Ho_Chi_Minh');echo date('d/m/Y');?>">
              </div>
            </div>
            <div class="d-grid">
              <button type="submit" class="btn btn-primary waves-effect waves-light">Tạo bill (miễn phí)</button>
            </div>
          </form>
        </div>
        <div id="creator-success"></div>
        <div id="download-img"></div>
        <div id="done-fakebill-td"></div>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function() {
    $('#td-acb').submit(function(e) {
        e.preventDefault();
        var submitButton = $(this).find('button[type="submit"]');
        submitButton.html('Đang fake bill...').prop('disabled', true);
        showToastrNotification('info', 'Đang tạo bill...', 'Thông báo');
        var randomDelay = Math.floor(Math.random() * (2000 - 1000 + 1)) + 1000;
        setTimeout(function() {
            var formData = $('#td-acb').serialize();
            $.ajax({
                type: 'POST',
                url: 'ajax/acb.php',
                data: formData,
                success: function(response) {
                    $('#creator-success').html('');
                    $('#download-img').html('');
                    $('#done-fakebill-td').html('');
                    $('#creator-success').html('<br/><p class="alert alert-success mb-3">Đã tạo ảnh fake-bill thành công!</p>');
                    $('#download-img').html('<a href="data:image/jpeg;base64,' + response + '" download="bill-acb.jpg" class="btn btn-success">Tải Bill Xuống</a><br/><br/>');
                    var image = $('<img>').attr('src', 'data:image/jpeg;base64,' + response);
                    $('#done-fakebill-td').append(image);
                    showToastrNotification('success', 'Tạo bill thành công', 'Thông báo');
                    submitButton.html('thành công, nhấn để tạo lại').prop('disabled', false);
                },
                error: function(error) {
                    console.log(error);
                    showToastrNotification('error', 'Tạo thất bại...', 'Thông báo');
                    submitButton.html('Tạo bill (miễn phí)').prop('disabled', false);
                }
            });
        }, randomDelay);
    });
});
</script>
<?php require_once('../include/foot.php'); ?>

<?php
$current_page = basename($_SERVER['PHP_SELF'], '.php');
if (!$current_page || $current_page !== 'index') {
    require_once('../config/conn.php');
} else {
    require_once('config/conn.php');
}
?>
<!DOCTYPE html>
<html lang="vi" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="./assets/" data-template="horizontal-menu-template-starter">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title><?=$title?></title>
    <meta name="title" content="<?=$title?>" />
    <meta name="description" content="<?=$description?>" />
    <meta name="author" content="trongthao" />
    <link rel="canonical" href="<?=$domain?>"/>
    <meta property="og:title" content="<?=$title?>" />
    <meta property="og:description" content="<?=$description?>" />
    <meta property="og:image" content="<?=$imgreviews?>" />
    <meta name="keywords" content="<?=$keyword?>">
    <link rel="shortcut icon" href="<?=$iconshortcut?>" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap" rel="stylesheet" />
    <link rel="stylesheet" href="./assets/vendor/fonts/materialdesignicons.css" />
    <link rel="stylesheet" href="./assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="./assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="./assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="./assets/css/demo.css<?=cache($hakibavuong)?>" />
    <link rel="stylesheet" href="./assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <script src="./assets/vendor/js/helpers.js"></script>
    <script src="./assets/vendor/js/template-customizer.js"></script>
    <script src="./assets/js/config.js<?=cache($hakibavuong)?>"></script>
    <link rel="stylesheet" href="./assets/vendor/libs/toastr/toastr.css" />
    <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.11/dist/clipboard.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  </head>
  <body>
  <style>body{user-select:none;}
  .Blob {
  background: black;
  border-radius: 15%;
  height: 50px;
  width: 50px; 
  box-shadow: 0 1px 7px rgb(231, 231, 231);
}</style>
  </body>
</html>