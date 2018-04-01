<?php
session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/paging.php");
require("../../inc/cek/admwk.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "ledger_nilai.php";
$judul = "Ledger Nilai";
$judulku = "[$wk_session : $nip3_session.$nm3_session] ==> $judul";
$juduly = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$s = nosql($_REQUEST['s']);


$ke = "$filenya?s=$s&tapelkd=$tapelkd&kelkd=$kelkd&smtkd=$smtkd";









//proses //////////////////////////////////////////////////////////////////////////////////////////////////////////

	
//proses //////////////////////////////////////////////////////////////////////////////////////////////////////////













//isi *START
ob_start();

//menu
require("../../inc/menu/admwk.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();







//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/checkall.js");
require("../../inc/js/number.js");

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" enctype="multipart/form-data" action="'.$filenya.'">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>';
xheadline($judul);
echo ' [<a href="../index.php?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'" title="Daftar Kelas">Daftar Kelas</a>]</td>
</tr>
</table>

<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Tahun Pelajaran : ';

//terpilih
$qtpx = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd = '$tapelkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_thn1 = nosql($rowtpx['tahun1']);
$tpx_thn2 = nosql($rowtpx['tahun2']);

echo '<b>'.$tpx_thn1.'/'.$tpx_thn2.'</b>,

Kelas : ';

//terpilih
$qbtx = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd = '$kelkd'");
$rowbtx = mysql_fetch_assoc($qbtx);
$btxkd = nosql($rowbtx['kd']);
$btxno = nosql($rowbtx['no']);
$btxkelas = balikin($rowbtx['kelas']);

echo '<b>'.$btxkelas.'</b>
</td>
</tr>
</table>
<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Semester : ';
echo "<select name=\"smt\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qstx = mysql_query("SELECT * FROM m_smt ".
						"WHERE kd = '$smtkd'");
$rowstx = mysql_fetch_assoc($qstx);
$stx_kd = nosql($rowstx['kd']);
$stx_no = nosql($rowstx['no']);
$stx_smt = nosql($rowstx['smt']);

echo '<option value="'.$stx_kd.'">'.$stx_smt.'</option>';

$qst = mysql_query("SELECT * FROM m_smt ".
						"WHERE kd <> '$smtkd' ".
						"ORDER BY smt ASC");
$rowst = mysql_fetch_assoc($qst);

do
	{
	$st_kd = nosql($rowst['kd']);
	$st_smt = nosql($rowst['smt']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&swkd='.$swkd.'&skkd='.$skkd.'&smtkd='.$st_kd.'">'.$st_smt.'</option>';
	}
while ($rowst = mysql_fetch_assoc($qst));

echo '</select>
<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
<input name="smtkd" type="hidden" value="'.$smtkd.'">
<input name="progkd" type="hidden" value="'.$progkd.'">
<input name="skkd" type="hidden" value="'.$skkd.'">
<input name="swkd" type="hidden" value="'.$swkd.'">
<input name="s" type="hidden" value="'.$s.'">
</td>
</tr>
</table>
<br>';

if (empty($smtkd))
	{
	echo '<h3>
	<font color="#FF0000"><strong>SEMESTER Belum Dipilih...!</strong></font>
	</h3>';
	}

else
	{
	//cek aktif kurikulum
	$qku = mysql_query("SELECT * FROM m_kurikulum ".
							"WHERE aktif = 'true'");
	$rku = mysql_fetch_assoc($qku);
	$ku_no = nosql($rku['no']);		
	
	
	//jika kurikulum KTSP
	if ($ku_no == "1")
		{		
		echo '<p>
		[<a href="ledger_nilai_xls.php?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&smtkd='.$smtkd.'" target="_blank" title="Legger Nilai"><img src="'.$sumber.'/img/xls.gif" width="16" height="16" border="0"></a>]. 
		</p>';
		}

	//jika kurikulum 2013
	else if ($ku_no == "2")
		{		
		echo '<p>
		[<a href="ledger_nilai_xls2.php?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&smtkd='.$smtkd.'" target="_blank" title="Legger Nilai"><img src="'.$sumber.'/img/xls.gif" width="16" height="16" border="0"></a>]. 
		</p>';
		}
	}


echo '</form>
<br>
<br>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi
$isi = ob_get_contents();
ob_end_clean();


require("../../inc/niltpl.php");


//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>