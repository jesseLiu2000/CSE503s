<!DOCTYPE html>
<html>
<head>
	<title>My First PHP Script</title>
</head>
<body>
<?php

function getFileCacheCount($pathName)
{
    $data = [
        'num' => 0,
        'size' => 0
    ];
    $dir = opendir($pathName);
    while(false !== ($file_name = readdir($dir))){
        if(!($file_name == "." || $file_name == "..")){
            $fileName = $pathName . "/" . $file_name;
            if(is_dir($fileName)){
                $subData = $this->getFileCacheCount($fileName);
                $data['size'] += $subData['size'];
                $data['num'] += $subData['num'];
            }else{
                $data['size'] += filesize($fileName);
                $data['num']++;
            }
        }
    }
    closedir($dir);
    return $data;
}
$cachePath = '/home/jesse/module2/userfile/Jesse/private';
$data = getFileCacheCount($cachePath);
switch ($data['size']){
    case $data['size'] > 1024:
        $data['size'] = round($data['size']/1024, 2) . 'KB';
		echo "$data[size]";
        break;
    case $data['size'] > 1024*1024:
        $data['size'] = round($data['size']/1024/1024, 2) . 'MB';
        break;
    default:
        $data['size'] = $data['size'] . 'B';
};
?>

</body>
</html>

// $dir = "/home/jesse/module2/userfile/123";
// if( mkdir($dir, 0755))
// {
//  echo '目录'.$dir.'成功创建';
// }
// else
// {
//  echo '创建目录失败，请检查权限';
// }