<?php
function docDuLieuJsonSearch($file)
{
    if (!file_exists($file)) {
        return [];
    }

    $jsonData = file_get_contents($file);
    return json_decode($jsonData, true); // Trả về dữ liệu dưới dạng mảng PHP
}
function timKiemSinhVien($searchKeyword)
{
    // Đường dẫn đến file JSON chứa dữ liệu sinh viên
    $file = 'sinhvien.json';

    // Đọc dữ liệu từ file JSON
    $sinhVienList = docDuLieuJsonSearch($file);

    // Nếu từ khóa tìm kiếm rỗng, trả về toàn bộ danh sách sinh viên
    if (empty($searchKeyword)) {
        return $sinhVienList;
    }

    // Lọc danh sách sinh viên theo từ khóa tìm kiếm
    $ketQua = [];
    foreach ($sinhVienList as $sinhVien) {
        // Chuyển tất cả về dạng chữ thường để tìm kiếm không phân biệt hoa thường
        $searchKeywordLower = strtolower($searchKeyword);

        // Kiểm tra nếu từ khóa xuất hiện trong mã sinh viên hoặc họ tên
        if (
            strpos(strtolower($sinhVien['maSinhVien']), $searchKeywordLower) !== false ||
            strpos(strtolower($sinhVien['hoTen']), $searchKeywordLower) !== false ||
            strpos(strtolower($sinhVien['nganhHoc']), $searchKeywordLower) !== false
        ) {
            $ketQua[] = $sinhVien; // Thêm sinh viên vào kết quả tìm kiếm
        }
    }

    // Trả về danh sách sinh viên khớp với từ khóa tìm kiếm
    return $ketQua;
}