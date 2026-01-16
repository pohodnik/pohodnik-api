<?php
include("../../blocks/db.php"); //����������� � ��
include("../../blocks/for_auth.php"); //������ ��� ��������������
$result = array();
$id_user	= intval($_COOKIE["user"]);
$id_iv		= intval($_POST['id_iv']);
$id_qq		= isset($_POST['id_qq'])?intval($_POST['id_qq']):0;
if($id_qq>0){
	$q = $mysqli->query("DELETE FROM iv_qq WHERE id={$id_qq}");
	if(!$q){die(json_encode(array("error"=>"������ ���������� \r\n".$mysqli->error)));}
	$result['success'] = true;
}
echo json_encode($result);
?>
