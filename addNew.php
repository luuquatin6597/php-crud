<?php
$file = 'sinhvien.json';

function docDuLieuJson($file)
{
    if (file_exists($file)) {
        $data = file_get_contents($file);
        return json_decode($data, true);
    }
    return [];
}

function createPopup($type)
{
    global $popupClass, $popupContent;

    if ($type === 'success') {
        $popupClass = 'show success'; // Popup sẽ có class 'show' và 'success'
        $popupContent = 'Đã thêm thành công';
    } else {
        $popupClass = 'show error'; // Popup sẽ có class 'show' và 'error'
        $popupContent = 'Đã xảy ra lỗi';
    }
}


function ghiDuLieuJson($file, $data)
{
    $jsonData = json_encode($data, JSON_PRETTY_PRINT);
    $result = file_put_contents($file, $jsonData);

    if ($result) {
        createPopup('success');
    } else {
        createPopup('error');
    }
}

function taoMaSinhVien($nganhHoc, $sinhVienList)
{
    $dem = 1;
    foreach ($sinhVienList as $sv) {
        if ($sv['nganhHoc'] === $nganhHoc) {
            $dem++;
        }
    }
    return $nganhHoc . str_pad($dem, 3, '0', STR_PAD_LEFT);
}

function xuLyForm()
{
    global $file;

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
        $hoTen = $_POST['hoTen'];
        $ngaySinh = $_POST['ngaySinh'];
        $dienThoai = $_POST['dienThoai'];
        $email = $_POST['email'];
        $diaChi = $_POST['diaChi'];
        $nganhHoc = $_POST['nganhHoc'];

        $sinhVienList = docDuLieuJson($file);

        $maSinhVien = taoMaSinhVien($nganhHoc, $sinhVienList);

        $sinhVienMoi = [
            'maSinhVien' => $maSinhVien,
            'hoTen' => $hoTen,
            'ngaySinh' => $ngaySinh,
            'dienThoai' => $dienThoai,
            'email' => $email,
            'diaChi' => $diaChi,
            'nganhHoc' => $nganhHoc
        ];

        $sinhVienList[] = $sinhVienMoi;

        ghiDuLieuJson($file, $sinhVienList);
    }
}