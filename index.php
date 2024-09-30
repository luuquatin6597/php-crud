<?php
include 'addNew.php';
include 'search.php';
if (isset($_POST['addNewForm'])) {
    xuLyForm();
}

if (isset($_GET['searchForm'])) {
    $searchKeyword = $_GET['search'];
    $sinhVienList = timKiemSinhVien($searchKeyword);
} else {
    $sinhVienList = docDuLieuJson($file);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Sinh Viên</title>

    <link rel="stylesheet" href="index.css?=<?php echo time(); ?>">
</head>

<body>
    <div class="container">
        <div class="title flex">
            <h1>DANH SÁCH SINH VIÊN</h1>
            <button id="openModal" onclick="openModal()">Thêm sinh viên</button>
        </div>

        <form class="flex" action="index.php" method="GET">
            <div class="flex form-group">
                <label for="search">Tìm kiếm:</label>
                <input type="text" name="search" id="search">

                <button type="submit" name="searchForm">Tìm kiếm</button>
                <input type="reset" value="Reset" onclick="resetSearch()">
            </div>
        </form>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Mã sinh viên</th>
                        <th>Họ tên</th>
                        <th>Ngày sinh</th>
                        <th>Điện thoại</th>
                        <th>Email</th>
                        <th>Địa chỉ</th>
                        <th>Ngành học</th>
                        <th>Hành động</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    if (!empty($sinhVienList)) {
                        foreach ($sinhVienList as $sinhVien) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($sinhVien['maSinhVien']) . "</td>";
                            echo "<td>" . htmlspecialchars($sinhVien['hoTen']) . "</td>";
                            echo "<td>" . htmlspecialchars($sinhVien['ngaySinh']) . "</td>";
                            echo "<td>" . htmlspecialchars($sinhVien['dienThoai']) . "</td>";
                            echo "<td>" . htmlspecialchars($sinhVien['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($sinhVien['diaChi']) . "</td>";
                            echo "<td>" . htmlspecialchars($sinhVien['nganhHoc']) . "</td>";
                            echo "<td><div class='flex'><button onclick='deleteSinhVien(\"" . $sinhVien['maSinhVien'] . "\")'>Xoá</button><button onclick='editSinhVien(\"" . $sinhVien['maSinhVien'] . "\")'>Sửa</button></div></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>Không tìm thấy kết quả nào.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal-container" id="modalAddNew">
        <div class="modal">
            <div class="modal-header">
                <div class="flex">
                    <h2>Thêm sinh viên</h2>
                    <button onclick="closeModal()">X</button>
                </div>
            </div>
            <div class="modal-body">
                <form id="addNewForm" action="index.php" method="POST">
                    <div class="flex form-group">
                        <label for="hoTen">Họ tên:</label>
                        <input type="text" name="hoTen" id="hoTen" required>
                    </div>
                    <div class="flex form-group">
                        <label for="ngaySinh">Ngày sinh:</label>
                        <input type="date" name="ngaySinh" id="ngaySinh" required>
                    </div>
                    <div class="flex form-group">
                        <label for="dienThoai">Điện thoại:</label>
                        <input type="text" name="dienThoai" id="dienThoai" required>
                    </div>
                    <div class="flex form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" required>
                    </div>
                    <div class="flex form-group">
                        <label for="diaChi">Địa chỉ:</label>
                        <input type="text" name="diaChi" id="diaChi" required>
                    </div>
                    <div class="flex form-group">
                        <label for="nganhHoc">Ngành học:</label>
                        <select name="nganhHoc" id="nganhHoc" required>
                            <option value="CN">Công nghệ thông tin (CN)</option>
                            <option value="CD">Cơ điện tử (CD)</option>
                            <option value="KT">Kế toán (KT)</option>
                            <option value="VH">Văn hoá học (VH)</option>
                            <option value="QT">Quản trị văn phòng (QT)</option>
                            <option value="NN">Ngôn ngữ Anh (NN)</option>
                            <option value="TK">Thiết kế thời trang (TK)</option>
                            <option value="CK">Cơ khí (CK)</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer flex">
                <button type="button" onclick="closeModal()">Đóng</button>
                <button type="submit" form="addNewForm" name="addNewForm">Thêm sinh viên</button>
            </div>
        </div>
    </div>

    <div id="popup" class="<?php echo $popupClass; ?>">
        <div class="flex">
            <p id="popupContent"><?php echo $popupContent; ?></p>
            <button onclick="closePopup()">X</button>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('addNewForm').reset();
            document.getElementById('modalAddNew').classList.add('show');
        }
        function closeModal() {
            document.getElementById('addNewForm').reset();
            document.getElementById('modalAddNew').classList.remove('show');
        }
        function closePopup() {
            document.getElementById('popup').setAttribute('class', '');
        }
        function resetSearch() {
            window.location.href = 'index.php'; // Điều hướng lại trang 'index.php'
        }

        window.onload = function () {
            const popup = document.getElementById('popup');
            if (popup.classList.contains('show')) {
                setTimeout(function () {
                    popup.classList.remove('show', 'success', 'error'); // Xóa cả 'show' và class động (success/error)
                }, 3000);
            }
        }
    </script>
</body>

</html>