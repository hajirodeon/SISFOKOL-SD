<?php
session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/paging.php");
require("../../inc/cek/admgr.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "nil_sikap.php";
$judul = "Penilaian Sikap";
$judulku = "[$guru_session : $nip1_session.$nm1_session] ==> $judul";
$juduly = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$progkd = nosql($_REQUEST['progkd']);
$jnskd = nosql($_REQUEST['jnskd']);
$skkd = nosql($_REQUEST['skkd']);
$swkd = nosql($_REQUEST['swkd']);
$s = nosql($_REQUEST['s']);
$page = nosql($_REQUEST['page']);

//page...
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd&".
			"skkd=$skkd&jnskd=$jnskd&progkd=$progkd&page=$page";

$limit = "50";


//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$progkd = nosql($_POST['progkd']);
	$jnskd = nosql($_POST['jnskd']);
	$page = nosql($_POST['page']);

	//page...
	if ((empty($page)) OR ($page == "0"))
		{
		$page = "1";
		}




	for ($k=1;$k<=$limit;$k++)
		{
		$xyzb = md5("$x$k");


		//skkd
		$xskkd = "skkd";
		$xskkd1 = "$xskkd$k";
		$xskkdxx = nosql($_POST["$xskkd1"]);


		//nilai
		$xnilnp = "nil_obs1";
		$xnilnp1 = "$xnilnp$k";
		$xnilnpxx = nosql($_POST["$xnilnp1"]);
		$inil_obs1 = $xnilnpxx;
		
		$xnilnp = "nil_obs2";
		$xnilnp1 = "$xnilnp$k";
		$xnilnpxx = nosql($_POST["$xnilnp1"]);
		$inil_obs2 = $xnilnpxx;
		
		$xnilnp = "nil_obs3";
		$xnilnp1 = "$xnilnp$k";
		$xnilnpxx = nosql($_POST["$xnilnp1"]);
		$inil_obs3 = $xnilnpxx;
		
		$xnilnp = "nil_obs4";
		$xnilnp1 = "$xnilnp$k";
		$xnilnpxx = nosql($_POST["$xnilnp1"]);
		$inil_obs4 = $xnilnpxx;

		
		$xnilnp = "nil_diri";
		$xnilnp1 = "$xnilnp$k";
		$xnilnpxx = nosql($_POST["$xnilnp1"]);
		$inil_diri = $xnilnpxx;


		
		$xnilnp = "nil_sejawat";
		$xnilnp1 = "$xnilnp$k";
		$xnilnpxx = nosql($_POST["$xnilnp1"]);
		$inil_sejawat = $xnilnpxx;



	


		//kumpulkan dulu ya.... nilai observasi...
		//netralkan dulu
		mysql_query("DELETE FROM siswa_observasi ".
						"WHERE kd_siswa_kelas = '$xskkdxx' ".
						"AND kd_smt = '$smtkd' ".
						"AND kd_prog_pddkn = '$progkd'");

		mysql_query("INSERT INTO siswa_observasi(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
						"nilkd, nilai, postdate) VALUES ".
						"('$x', '$xskkdxx', '$smtkd', '$progkd', ".
						"'obs1', '$inil_obs1', '$today')");

		mysql_query("INSERT INTO siswa_observasi(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
						"nilkd, nilai, postdate) VALUES ".
						"('$x', '$xskkdxx', '$smtkd', '$progkd', ".
						"'obs2', '$inil_obs2', '$today')");

		mysql_query("INSERT INTO siswa_observasi(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
						"nilkd, nilai, postdate) VALUES ".
						"('$x', '$xskkdxx', '$smtkd', '$progkd', ".
						"'obs3', '$inil_obs3', '$today')");
						
		mysql_query("INSERT INTO siswa_observasi(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
						"nilkd, nilai, postdate) VALUES ".
						"('$x', '$xskkdxx', '$smtkd', '$progkd', ".
						"'obs4', '$inil_obs4', '$today')");
						
	


		

		//ke mysql
		$qcc = mysql_query("SELECT m_siswa.*, siswa_kelas.*, siswa_kelas.kd AS skkd ".
								"FROM m_siswa, siswa_kelas ".
								"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
								"AND siswa_kelas.kd_tapel = '$tapelkd' ".
								"AND siswa_kelas.kd = '$xskkdxx'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);

		//jika ada
		if ($tcc != 0)
			{
			//entry...
			$qcc1 = mysql_query("SELECT * FROM siswa_nilai_raport ".
									"WHERE kd_siswa_kelas = '$xskkdxx' ".
									"AND kd_smt = '$smtkd' ".
									"AND kd_prog_pddkn = '$progkd'");
			$rcc1 = mysql_fetch_assoc($qcc1);
			$tcc1 = mysql_num_rows($qcc1);


			//jika ada, update
			if ($tcc1 != 0)
				{
				mysql_query("UPDATE siswa_nilai_raport SET nil_sikap_observasi1 = '$inil_obs1', ".
								"nil_sikap_observasi2 = '$inil_obs2', ".
								"nil_sikap_observasi3 = '$inil_obs3', ".
								"nil_sikap_observasi4 = '$inil_obs4', ".
								"nil_sikap_observasi = '$inil_obs', ".
								"nil_sikap_dirisendiri = '$inil_diri', ".
								"nil_sikap_antarteman = '$inil_sejawat', ".
								"rata_sikap = '$xnilnpxx', ".
								"rata_sikap_a = '$xnilnraxx', ".
								"rata_sikap_p = '$xnilnrpxx' ".
								"WHERE kd_siswa_kelas = '$xskkdxx' ".
								"AND kd_smt = '$smtkd' ".
								"AND kd_prog_pddkn = '$progkd'");
				}

			//jika blm ada, insert
			else
				{
				mysql_query("INSERT INTO siswa_nilai_raport(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
								"nil_sikap_observasi1, nil_sikap_observasi2, nil_sikap_observasi3, nil_sikap_observasi4, ".
								"nil_sikap_dirisendiri, nil_sikap_antarteman, postdate) VALUES ".
								"('$xyzb', '$xskkdxx', '$smtkd', '$progkd', ".
								"'$inil_obs1', '$inil_obs2', '$inil_obs3', '$inil_obs4', '$inil_obs', ".
								"'$inil_diri', '$inil_sejawat', '$today')");
				}
				
				
				
				
				

			//rata2 observasi
			$qcc2 = mysql_query("SELECT AVG(nilai) AS rataku FROM siswa_observasi ".
									"WHERE kd_siswa_kelas = '$xskkdxx' ".
									"AND kd_smt = '$smtkd' ".
									"AND kd_prog_pddkn = '$progkd' ".
									"AND nilai <> '0' ".
									"AND nilai <> ''");
			$rcc2 = mysql_fetch_assoc($qcc2);
			$cc2_obs = nosql($rcc2['rataku']);
			
			//update lg...					
			mysql_query("UPDATE siswa_nilai_raport SET nil_sikap_observasi = '$cc2_obs' ".
							"WHERE kd_siswa_kelas = '$xskkdxx' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_prog_pddkn = '$progkd'");





				
					
			//nilai akhir
			$xpel_nil_nr = round(((2 * $cc2_obs) + $inil_diri + $inil_sejawat) / 4,2);
	
		
			$xpel_nil_nr_a = round(($xpel_nil_nr / 100) * 4,2);
			
			
			//jika SB
			if ($xpel_nil_nr_a >= "3.51")
				{
				$xpel_nil_nr_p = "SB";
				}
			else if (($xpel_nil_nr_a >= "2.51") AND ($xpel_nil_nr_a <= "3.5"))
				{
				$xpel_nil_nr_p = "B";
				}
			else if (($xpel_nil_nr_a >= "1.51") AND ($xpel_nil_nr_a <= "2.5"))
				{
				$xpel_nil_nr_p = "C";
				} 
			else 
				{
				$xpel_nil_nr_p = "K";
				}
			

			
			
			//update lg...					
			mysql_query("UPDATE siswa_nilai_raport SET rata_sikap = '$xpel_nil_nr', ".
							"rata_sikap_a = '$xpel_nil_nr_a', ".
							"rata_sikap_p = '$xpel_nil_nr_p' ".
							"WHERE kd_siswa_kelas = '$xskkdxx' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_prog_pddkn = '$progkd'");
							
				
				
							

			}



		}




	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd&".
			"progkd=$progkd&page=$page";
	xloc($ke);
	exit();
	}





//reset
if ($_POST['btnRST'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$progkd = nosql($_POST['progkd']);
	$jnskd = nosql($_POST['jnskd']);
	$page = nosql($_POST['page']);

	//page...
	if ((empty($page)) OR ($page == "0"))
		{
		$page = "1";
		}




	for ($k=1;$k<=$limit;$k++)
		{
		$xyzb = md5("$x$k");


		//skkd
		$xskkd = "skkd";
		$xskkd1 = "$xskkd$k";
		$xskkdxx = nosql($_POST["$xskkd1"]);



		


		mysql_query("UPDATE siswa_nilai_raport SET nil_sikap_observasi1 = '$inil_obs1', ".
						"nil_sikap_observasi2 = '$inil_obs2', ".
						"nil_sikap_observasi3 = '$inil_obs3', ".
						"nil_sikap_observasi4 = '$inil_obs4', ".
						"nil_sikap_observasi = '$inil_obs', ".
						"nil_sikap_dirisendiri = '$inil_diri', ".
						"nil_sikap_antarteman = '$inil_sejawat', ".
						"rata_sikap = '$xnilnpxx', ".
						"rata_sikap_a = '$xnilnraxx', ".
						"rata_sikap_p = '$xnilnrpxx' ".
						"WHERE kd_siswa_kelas = '$xskkdxx' ".
						"AND kd_smt = '$smtkd' ".
						"AND kd_prog_pddkn = '$progkd'");
		}




	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd&".
			"progkd=$progkd&page=$page";
	xloc($ke);
	exit();
	}








//btl
if ($_POST['btnBTL'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$progkd = nosql($_POST['progkd']);
	$jnskd = nosql($_POST['jnskd']);
	$page = nosql($_POST['page']);

	//page...
	if ((empty($page)) OR ($page == "0"))
		{
		$page = "1";
		}






	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd&".
			"progkd=$progkd&page=$page";
	xloc($ke);
	exit();
	}
	
	






//ke import
if ($_POST['btnIM'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$progkd = nosql($_POST['progkd']);
	$jndks = nosql($_POST['jnskd']);


	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&smtkd=$smtkd&progkd=$progkd&jnskd=$jnskd&s=import";
	xloc($ke);
	exit();
	}





//import
if ($_POST['btnIM2'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$progkd = nosql($_POST['progkd']);
	$jnskd = nosql($_POST['jnskd']);
	$filex_namex = strip(strtolower($_FILES['filex_xls']['name']));

	//nek null
	if (empty($filex_namex))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&smtkd=$smtkd&progkd=$progkd&jnskd=$jnskd&s=import";
		pekem($pesan,$ke);
		}
	else
		{
		//deteksi .xls
		$ext_filex = substr($filex_namex, -4);

		if ($ext_filex == ".xls")
			{
			//nilai
			$path1 = "../../filebox";
			$path2 = "../../filebox/excel";
			chmod($path1,0777);
			chmod($path2,0777);

			//nama file import, diubah menjadi baru...
			$filex_namex2 = "file_importnya.xls";

			//mengkopi file
			copy($_FILES['filex_xls']['tmp_name'],"../../filebox/excel/$filex_namex2");

			//chmod
                        $path3 = "../../filebox/excel/$filex_namex2";
			chmod($path1,0755);
			chmod($path2,0777);
			chmod($path3,0777);


			//re-direct
			$ke = "nil_sikap_import.php?tapelkd=$tapelkd&kelkd=$kelkd&smtkd=$smtkd&progkd=$progkd&jnskd=$jnskd&filex_namex2=$filex_namex2";
			xloc($ke);
			exit();
			}
		else
			{
			//re-direct
			$pesan = "Bukan File .xls . Harap Diperhatikan...!!";
			$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&smtkd=$smtkd&progkd=$progkd&jnskd=$jnskd&s=import";
			pekem($pesan,$ke);
			exit();
			}
		}
	}





//export
if ($_POST['btnEX'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$progkd = nosql($_POST['progkd']);
	$jnskd = nosql($_POST['jnskd']);




	//require
	require('../../inc/class/excel/OLEwriter.php');
	require('../../inc/class/excel/BIFFwriter.php');
	require('../../inc/class/excel/worksheet.php');
	require('../../inc/class/excel/workbook.php');


	
	


	//mapel e...
	$qstdx = mysql_query("SELECT * FROM m_prog_pddkn ".
							"WHERE kd = '$progkd'");
	$rowstdx = mysql_fetch_assoc($qstdx);
	$stdx_kd = nosql($rowstdx['kd']);
	$stdx_jnskd = nosql($rowstdx['kd_jenis']);
	$stdx_pel = strip(balikin($rowstdx['xpel']));


	//nama file e...
	$excelfile = "Nilai_sikap_$stdx_pel.xls";
	$i_judul = "Nilai_sikap_$stdx_pel";
	
	
	//nama file e...
	$i_filename = "Nilai_Sikap_$stdx_pel.xls";
	$i_judul = "Sikap";
	

	
	//header file
	function HeaderingExcel($i_filename)
		{
		header("Content-type:application/vnd.ms-excel");
		header("Content-Disposition:attachment;filename=$i_filename");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
		header("Pragma: public");
		}

	
	
	
	//bikin...
	HeaderingExcel($i_filename);
	$workbook = new Workbook("-");
	$worksheet1 =& $workbook->add_worksheet($i_judul);
	$worksheet1->write_string(0,0,"NO.");
	$worksheet1->write_string(0,1,"NIS");
	$worksheet1->write_string(0,2,"NAMA");
	$worksheet1->write_string(0,3,"OBSERVASI_1");
	$worksheet1->write_string(0,4,"OBSERVASI_2");
	$worksheet1->write_string(0,5,"OBSERVASI_3");
	$worksheet1->write_string(0,6,"OBSERVASI_4");
	$worksheet1->write_string(0,7,"RATA_OBSERVASI");
	$worksheet1->write_string(0,8,"DIRISENDIRI");
	$worksheet1->write_string(0,9,"SEJAWAT");
	$worksheet1->write_string(0,10,"NAS");
	$worksheet1->write_string(0,11,"ANGKA");
	$worksheet1->write_string(0,12,"HURUF");




	//data
	$qdt = mysql_query("SELECT m_siswa.*, siswa_kelas.*, siswa_kelas.kd AS skkd ".
							"FROM m_siswa, siswa_kelas ".
							"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
							"AND siswa_kelas.kd_tapel = '$tapelkd' ".
							"AND siswa_kelas.kd_kelas = '$kelkd' ".
							"ORDER BY m_siswa.nama ASC");
	$rdt = mysql_fetch_assoc($qdt);

	do
		{
		//nilai
		$dt_nox = $dt_nox + 1;
		$dt_skkd = nosql($rdt['skkd']);
		$dt_no = nosql($rdt['no_absen']);
		$dt_nis = nosql($rdt['nis']);
		$dt_nama = balikin($rdt['nama']);

		//nil prog_pddkn
		$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
								"WHERE kd_siswa_kelas = '$dt_skkd' ".
								"AND kd_smt = '$smtkd' ".
								"AND kd_prog_pddkn = '$progkd'");
		$rxpel = mysql_fetch_assoc($qxpel);
		$txpel = mysql_num_rows($qxpel);
		$xpel_nil_obs1 = nosql($rxpel['nil_sikap_observasi1']);
		$xpel_nil_obs2 = nosql($rxpel['nil_sikap_observasi2']);
		$xpel_nil_obs3 = nosql($rxpel['nil_sikap_observasi3']);
		$xpel_nil_obs4 = nosql($rxpel['nil_sikap_observasi4']);
		$xpel_nil_obss = nosql($rxpel['nil_sikap_observasi']);
		$xpel_nil_dirisendiri = nosql($rxpel['nil_sikap_dirisendiri']);
		$xpel_nil_sejawat = nosql($rxpel['nil_sikap_antarteman']);
		$xpel_rata = nosql($rxpel['rata_sikap']);
		$xpel_rata_a = nosql($rxpel['rata_sikap_a']);
		$xpel_rata_p = nosql($rxpel['rata_sikap_p']);





		//ciptakan
		$worksheet1->write_string($dt_nox,0,$dt_nox);
		$worksheet1->write_string($dt_nox,1,$dt_nis);
		$worksheet1->write_string($dt_nox,2,$dt_nama);
		$worksheet1->write_string($dt_nox,3,$xpel_nil_obs1);
		$worksheet1->write_string($dt_nox,4,$xpel_nil_obs2);
		$worksheet1->write_string($dt_nox,5,$xpel_nil_obs3);
		$worksheet1->write_string($dt_nox,6,$xpel_nil_obs4);
		$worksheet1->write_string($dt_nox,7,$xpel_nil_obss);
		$worksheet1->write_string($dt_nox,8,$xpel_nil_dirisendiri);
		$worksheet1->write_string($dt_nox,9,$xpel_nil_sejawat);
		$worksheet1->write_string($dt_nox,10,$xpel_rata);
		$worksheet1->write_string($dt_nox,11,$xpel_rata_a);
		$worksheet1->write_string($dt_nox,12,$xpel_rata_p);
		}
	while ($rdt = mysql_fetch_assoc($qdt));



	//close
	$workbook->close();
	

	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&smtkd=$smtkd&progkd=$progkd&jnskd=$jnskd";	
	xloc($ke);
	exit();
	}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////










//focus....focus...
if (empty($smtkd))
	{
	$diload = "document.formx.smt.focus();";
	}





//isi *START
ob_start();

//menu
require("../../inc/menu/admgr.php");

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
echo '<form name="formx" method="post" action="'.$filenya.'" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>';
xheadline($judul);
echo ' [<a href="../index.php?tapelkd='.$tapelkd.'" title="Daftar Mata Pelajaran">Daftar Mata Pelajaran</a>]</td>
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

echo '<strong>'.$tpx_thn1.'/'.$tpx_thn2.'</strong>,

Kelas : ';
//terpilih
$qbtx = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd = '$kelkd'");
$rowbtx = mysql_fetch_assoc($qbtx);

$btxkd = nosql($rowbtx['kd']);
$btxno = nosql($rowbtx['no']);
$btxkelas = balikin($rowbtx['kelas']);

echo '<strong>'.$btxkelas.'</strong>
</td>
</tr>
</table>

<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Mata Pelajaran : ';
//terpilih
$qstdx = mysql_query("SELECT * FROM m_prog_pddkn ".
						"WHERE kd = '$progkd'");
$rowstdx = mysql_fetch_assoc($qstdx);
$stdx_kd = nosql($rowstdx['kd']);
$stdx_jnskd = nosql($rowstdx['kd_jenis']);
$stdx_pel = balikin($rowstdx['prog_pddkn']);

//jenis
$qjnsx = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
			"WHERE kd = '$stdx_jnskd'");
$rjnsx = mysql_fetch_assoc($qjnsx);
$tjnsx = mysql_num_rows($qjnsx);
$jnsx_jenis = balikin($rjnsx['jenis']);

echo '<strong>'.$jnsx_jenis.' --> '.$stdx_pel.'</strong>,

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

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&progkd='.$progkd.'&smtkd='.$st_kd.'">'.$st_smt.'</option>';
	}
while ($rowst = mysql_fetch_assoc($qst));

echo '</select>,


<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
<input name="smtkd" type="hidden" value="'.$smtkd.'">
<input name="jnskd" type="hidden" value="'.$stdx_jnskd.'">
<input name="progkd" type="hidden" value="'.$progkd.'">
</td>
</tr>
</table>
<br>';


//nek drg
if (empty($tapelkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>
	</p>';
	}

else if (empty($kelkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>KELAS Belum Dipilih...!</strong></font>
	</p>';
	}

else if (empty($smtkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>SEMESTER Belum Dipilih...!</strong></font>
	</p>';
	}

else if (empty($progkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>MATA PELAJARAN Belum Dipilih...!</strong></font>
	</p>';
	}

else
	{
	//jika import
	if ($s == "import")
		{
		echo '<p>
		Silahkan Masukkan File yang akan Di-Import :
		<br>
		<input name="filex_xls" type="file" size="30">
		<br>
		<input name="s" type="hidden" value="'.$s.'">
		<input name="btnBTL" type="submit" value="BATAL">
		<input name="btnIM2" type="submit" value="IMPORT >>">
		</p>';
		}




	//jika diri sendiri
	else if ($s == "dirisendiri")
		{
		//detail bocah e
		$qku2 = mysql_query("SELECT m_siswa.* ".
								"FROM m_siswa, siswa_kelas ".
								"WHERE m_siswa.kd = '$swkd' ". 
								"AND siswa_kelas.kd = '$skkd' ".
								"AND siswa_kelas.kd_tapel = '$tapelkd' ".
								"AND siswa_kelas.kd_kelas = '$kelkd'");
		$rku2 = mysql_fetch_assoc($qku2);
		$ku2_nis = nosql($rku2['nis']);
		$ku2_nama = balikin($rku2['nama']);
		
		echo '
		<input name="btnBTL" type="submit" value="<< KEMBALI KE DAFTAR SISWA">
		<hr>
		<p>
		<b>
		DETAIL NILAI SIKAP : Diri Sendiri
		</b>
		<br>
		'.$ku2_nis.'. '.$ku2_nama.'
		</p>
		
		
		<p>
		<table width="500" border="1" cellpadding="3" cellspacing="0">
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="5"><strong><font color="'.$warnatext.'">No.</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Pernyataan</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Nilai</font></strong></td>
		</tr>';
	
		//query
		$q = mysql_query("SELECT * FROM m_sikap_dirisendiri ".
								"WHERE kd_tapel = '$tapelkd' ".
								"ORDER BY round(no) ASC");
		$row = mysql_fetch_assoc($q);
		$total = mysql_num_rows($q);
	
		
		if ($total != 0)
			{
			do
				{
				if ($warna_set ==0)
					{
					$warna = $warna01;
					$warna_set = 1;
					}
				else
					{
					$warna = $warna02;
					$warna_set = 0;
					}
	
				$nomer = $nomer + 1;
				$i_kd = nosql($row['kd']);
				$i_no = nosql($row['no']);
				$i_nama = balikin($row['nama']);
	
	
	
				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>'.$i_no.'.</td>
				<td>'.$i_nama.'</td>
				<td>
				<input name="pilkd'.$nomer.'" type="hidden" value="'.$i_kd.'">';
				
				
				
				
				//lihat
				$qku = mysql_query("SELECT * FROM siswa_sikap_dirisendiri ".
									"WHERE kd_tapel = '$tapelkd' ".
									"AND kd_kelas = '$kelkd' ".
									"AND kd_mapel = '$progkd' ".
									"AND kd_siswa = '$swkd' ". 
									"AND kd_ket = '$i_kd'");
				$rku = mysql_fetch_assoc($qku);
				$ku_pilihan = nosql($rku['pilihan']);
	
				
				//jika
				if ($ku_pilihan == "1")
					{
					$ku_detail = "Tidak Pernah";	
					}
				else if ($ku_pilihan == "2")
					{
					$ku_detail = "Kadang - kadang";	
					}
				else if ($ku_pilihan == "3")
					{
					$ku_detail = "Sering";	
					}
				else if ($ku_pilihan == "4")
					{
					$ku_detail = "Selalu";	
					}
					
					
					
				echo ''.$ku_detail.'
				</td>
				</tr>';
				}
			while ($row = mysql_fetch_assoc($q));
			}
	
		echo '</table>';
		
	
		//last update
		$qku = mysql_query("SELECT * FROM siswa_sikap_dirisendiri ".
								"WHERE kd_tapel = '$tapelkd' ".
								"AND kd_kelas = '$kelkd' ".
								"AND kd_mapel = '$progkd' ".
								"AND kd_siswa = '$swkd'");
		$rku = mysql_fetch_assoc($qku);
		$ku_tgl = $rku['tgl'];
	
	
	
		//last update
		$qku2 = mysql_query("SELECT AVG(nilai) AS rataku ".
								"FROM siswa_sikap_dirisendiri ".
								"WHERE kd_tapel = '$tapelkd' ".
								"AND kd_kelas = '$kelkd' ".
								"AND kd_mapel = '$progkd' ".
								"AND kd_siswa = '$swkd'");
		$rku2 = mysql_fetch_assoc($qku2);
		$ku2_rataku = nosql($rku2['rataku']);
	
		
		echo '[Rata - Rata : <b>'.$ku2_rataku.'</b>]. 
		[Kiriman terakhir : <b>'.$ku_tgl.'</b>].
		</p>';
		}






	//jika sejawat
	else if ($s == "sejawat")
		{
		//detail bocah e
		$qku2 = mysql_query("SELECT m_siswa.* ".
								"FROM m_siswa ".
								"WHERE kd = '$swkd'");
		$rku2 = mysql_fetch_assoc($qku2);
		$ku2_nis = nosql($rku2['nis']);
		$ku2_nama = balikin($rku2['nama']);
		
		echo '<input name="btnBTL" type="submit" value="<< KEMBALI KE DAFTAR SISWA">
		<hr>
		<p>
		<b>
		DETAIL NILAI SIKAP : Antar Teman / Sejawat
		</b>
		<br>
		'.$ku2_nis.'. '.$ku2_nama.'
		</p>';
		
		
	
	
		//query
		$p = new Pager();
		$start = $p->findStart($limit);
	
		$sqlcount = "SELECT m_siswa.*, m_siswa.kd AS mskd, siswa_kelas.* ".
						"FROM m_siswa, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"AND m_siswa.kd <> '$swkd' ".
						"ORDER BY m_siswa.nama ASC";
		$sqlresult = $sqlcount;
	
		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?tapelkd=$tapelkd&kompkd=$kompkd&kelkd=$kelkd&smtkd=$smtkd&progkd=$progkd";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
	
	
		//nek ada
		if ($count != 0)
			{
			echo '<table border="1" cellpadding="3" cellspacing="0">
		    <tr bgcolor="'.$warnaheader.'">
			<td width="50"><strong>NIS</strong></td>
			<td width="250"><strong>Nama</strong></td>';
		
			//query
			$q = mysql_query("SELECT * FROM m_sikap_antarteman ".
									"WHERE kd_tapel = '$tapelkd' ".
									"ORDER BY round(no) ASC");
			$row = mysql_fetch_assoc($q);
			$total = mysql_num_rows($q);
	
			do
				{
				$i_kd = nosql($row['kd']);
				$i_no = nosql($row['no']);
				$i_nama = balikin($row['nama']);
	
				echo '<td width="50" valign="top"><strong>'.$i_nama.'</strong></td>';
				}
			while ($row = mysql_fetch_assoc($q));
						
		  	echo '</tr>';
	
			do
	  			{
				if ($warna_set ==0)
					{
					$warna = $warna01;
					$warna_set = 1;
					}
				else
					{
					$warna = $warna02;
					$warna_set = 0;
					}
	
				$nomer = $nomer + 1;
	
				$i_kd = nosql($data['mskd']);
				$i_nis = nosql($data['nis']);
				$i_nama = balikin2($data['nama']);
	
	
	
				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td valign="top">
				<input name="kd'.$nomer.'" type="hidden" value="'.$i_kd.'">
				'.$i_nis.'
				</td>
				<td valign="top">'.$i_nama.'</td>';
	
		
				//query
				$q = mysql_query("SELECT * FROM m_sikap_antarteman ".
									"WHERE kd_tapel = '$tapelkd' ".
									"ORDER BY round(no) ASC");
				$row = mysql_fetch_assoc($q);
				$total = mysql_num_rows($q);
		
				do
					{
					$nomerx = $nomerx + 1;
					$i_kd2 = nosql($row['kd']);
					$i_no2 = nosql($row['no']);
					$i_nama2 = balikin($row['nama']);
	
		
					//lihat
					$qku = mysql_query("SELECT * FROM siswa_sikap_antarteman ".
										"WHERE kd_tapel = '$tapelkd' ".
										"AND kd_kelas = '$kelkd' ".
										"AND kd_mapel = '$progkd' ".
										"AND kd_siswa = '$swkd' ".
										"AND kd_siswa2 = '$i_kd' ". 
										"AND kd_ket = '$i_kd2' ".
										"AND pilihan <> ''");
					$rku = mysql_fetch_assoc($qku);
					$tku = mysql_num_rows($qku);
					
					
					//jika ada
					if (!empty($tku))
						{
						$ku_pilihan = nosql($rku['pilihan']);
				
			
						//jika
						if ($ku_pilihan == "1")
							{
							$ku_detail = "Tidak Pernah";			
							$ku_nilai = "40";	
							}
						else if ($ku_pilihan == "2")
							{
							$ku_detail = "Kadang - kadang";			
							$ku_nilai = "60";		
							}
						else if ($ku_pilihan == "3")
							{
							$ku_detail = "Sering";			
							$ku_nilai = "80";		
							}
						else if ($ku_pilihan == "4")
							{
							$ku_detail = "Selalu";			
							$ku_nilai = "100";		
							}
						}
					else
						{
						$ku_detail = "";
						$ku_pilihan = "";
						}
						
						
						
							
					//update
					mysql_query("UPDATE siswa_sikap_antarteman SET nilai = '$ku_nilai' ".
									"WHERE kd_tapel = '$tapelkd' ".
									"AND kd_kelas = '$kelkd' ".
									"AND kd_mapel = '$progkd' ".
									"AND kd_siswa = '$swkd' ".
									"AND kd_siswa2 = '$i_kd' ". 
									"AND kd_ket = '$i_kd2' ".
									"AND pilihan = '$ku_pilihan'");
					
				
				
					echo '<td valign="top">
					<input name="'.$nomer.'pilkd'.$nomerx.'" type="hidden" value="'.$i_kd.'">
					'.$ku_detail.'
					</td>';
					}
				while ($row = mysql_fetch_assoc($q));
	
				
				echo '</tr>';
				}
			while ($data = mysql_fetch_assoc($result));
	
			echo '</table>
			<table width="900" border="0" cellspacing="0" cellpadding="3">
			<tr>';
			
			//last update
			$qku = mysql_query("SELECT * FROM siswa_sikap_antarteman ".
									"WHERE kd_tapel = '$tapelkd' ".
									"AND kd_kelas = '$kelkd' ".
									"AND kd_mapel = '$progkd' ".
									"AND kd_siswa = '$swkd'");
			$rku = mysql_fetch_assoc($qku);
			$ku_tgl = $rku['tgl'];
		
			
			//last update
			$qku2 = mysql_query("SELECT AVG(nilai) AS rataku ".
									"FROM siswa_sikap_antarteman ".
									"WHERE kd_tapel = '$tapelkd' ".
									"AND kd_kelas = '$kelkd' ".
									"AND kd_mapel = '$progkd' ".
									"AND kd_siswa = '$swkd'");
			$rku2 = mysql_fetch_assoc($qku2);
			$ku2_rataku = nosql($rku2['rataku']);
		
			echo '<td>
			<input name="jml" type="hidden" value="'.$total.'">
			[Rata - rata : <b>'.$ku2_rataku.'</b>]. 
			[Kiriman terakhir : <b>'.$ku_tgl.'</b>].';
			}		
	
		}



	else
		{
		//daftar siswa
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT m_siswa.*, m_siswa.kd AS mskd, siswa_kelas.*, siswa_kelas.kd AS skkd ".
						"FROM m_siswa, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"ORDER BY m_siswa.nama ASC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&smtkd=$smtkd&jnskd=$jnskd&progkd=$progkd";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);



		echo '<input name="btnIM" type="submit" value="IMPORT">
		<input name="btnEX" type="submit" value="EXPORT">
		<table width="1200" border="1" cellspacing="0" cellpadding="3">
		<tr bgcolor="'.$warnaheader.'">
		<td width="50"><strong>NIS</strong></td>
		<td><strong>NAMA</strong></td>
		<td width="50"><strong>OBSERVASI 1</strong></td>
		<td width="50"><strong>OBSERVASI 2</strong></td>
		<td width="50"><strong>OBSERVASI 3</strong></td>
		<td width="50"><strong>OBSERVASI 4</strong></td>
		<td width="50"><strong>RATA</strong></td>
		<td width="50"><strong>PENILAIAN DIRI</strong></td>
		<td width="50"><strong>PENILAIAN SEJAWAT</strong></td>
		<td width="50"><strong>N.A.S</strong></td>
		<td width="50"><strong>ANGKA</strong></td>
		<td width="50"><strong>HURUF</strong></td>
		</tr>';


		do
			{
			if ($warna_set ==0)
				{
				$warna = $warna01;
				$warna_set = 1;
				}
			else
				{
				$warna = $warna02;
				$warna_set = 0;
				}

			//nilainya
			$i_nomer = $i_nomer + 1;
			$i_mskd = nosql($data['mskd']);
			$i_skkd = nosql($data['skkd']);
			$i_nis = nosql($data['nis']);
			$i_nama = balikin($data['nama']);





			//last update
			$qku2 = mysql_query("SELECT AVG(nilai) AS rataku ".
									"FROM siswa_sikap_dirisendiri ".
									"WHERE kd_tapel = '$tapelkd' ".
									"AND kd_kelas = '$kelkd' ".
									"AND kd_mapel = '$progkd' ".
									"AND kd_siswa = '$i_mskd'");
			$rku2 = mysql_fetch_assoc($qku2);
			$ku2_rataku = nosql($rku2['rataku']);
		
		




			//last update
			$qku3 = mysql_query("SELECT AVG(nilai) AS rataku ".
									"FROM siswa_sikap_antarteman ".
									"WHERE kd_tapel = '$tapelkd' ".
									"AND kd_kelas = '$kelkd' ".
									"AND kd_mapel = '$progkd' ".
									"AND kd_siswa = '$i_mskd'");
			$rku3 = mysql_fetch_assoc($qku3);
			$ku3_rataku = nosql($rku3['rataku']);
		


		
			//update ke raport
			mysql_query("UPDATE siswa_nilai_raport SET nil_sikap_dirisendiri = '$ku2_rataku', ".
							"nil_sikap_antarteman = '$ku3_rataku' ".
							"WHERE kd_siswa_kelas = '$i_skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_prog_pddkn = '$progkd'");
	
	

			//nil mapel
			$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
									"WHERE kd_siswa_kelas = '$i_skkd' ".
									"AND kd_smt = '$smtkd' ".
									"AND kd_prog_pddkn = '$progkd'");
			$rxpel = mysql_fetch_assoc($qxpel);
			$txpel = mysql_num_rows($qxpel);
			
			$xpel_obs1 = nosql($rxpel['nil_sikap_observasi1']);
			$xpel_obs2 = nosql($rxpel['nil_sikap_observasi2']);
			$xpel_obs3 = nosql($rxpel['nil_sikap_observasi3']);
			$xpel_obs4 = nosql($rxpel['nil_sikap_observasi4']);
			$xpel_obs = nosql($rxpel['nil_sikap_observasi']);
	
			
			$xpel_diri = nosql($rxpel['nil_sikap_dirisendiri']);
			$xpel_sejawat = nosql($rxpel['nil_sikap_antarteman']);
			

			
			$xpel_nil_nr = nosql($rxpel['rata_sikap']);
			$xpel_nil_nr_a = nosql($rxpel['rata_sikap_a']);
			$xpel_nil_nr_p = balikin($rxpel['rata_sikap_p']);





			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input name="skkd'.$i_nomer.'" type="hidden" value="'.$i_skkd.'">
			'.$i_nis.'
			</td>
			<td>
			'.$i_nama.'
			</td>

			<td>
			<input name="nil_obs1'.$i_nomer.'" type="text" value="'.$xpel_obs1.'" size="3" style="text-align:right">
			</td>

			<td>
			<input name="nil_obs2'.$i_nomer.'" type="text" value="'.$xpel_obs2.'" size="3" style="text-align:right">
			</td>

			<td>
			<input name="nil_obs3'.$i_nomer.'" type="text" value="'.$xpel_obs3.'" size="3" style="text-align:right">
			</td>
			
			<td>
			<input name="nil_obs4'.$i_nomer.'" type="text" value="'.$xpel_obs4.'" size="3" style="text-align:right">
			</td>
			
			<td>
			<input name="nil_obss'.$i_nomer.'" type="text" value="'.$xpel_obs.'" size="3" style="text-align:right" class="input" readonly>
			</td>


			<td>
			<input name="nil_diri'.$i_nomer.'" type="text" value="'.$xpel_diri.'" size="3" style="text-align:right" class="input" readonly>
			
			
			<a href="'.$filenya.'?s=dirisendiri&swkd='.$i_mskd.'&smtkd='.$smtkd.'&skkd='.$i_skkd.'&mmkd='.$mmkd.'&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&progkd='.$progkd.'&mpkd='.$mpkd.'&kompkd='.$kompkd.'">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
			</td>

			<td>
			<input name="nil_sejawat'.$i_nomer.'" type="text" value="'.$xpel_sejawat.'" size="3" style="text-align:right" class="input" readonly>
			
			<a href="'.$filenya.'?s=sejawat&swkd='.$i_mskd.'&smtkd='.$smtkd.'&skkd='.$i_skkd.'&mmkd='.$mmkd.'&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&progkd='.$progkd.'&mpkd='.$mpkd.'&kompkd='.$kompkd.'">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
			</td>

			<td>
			<input name="nil_raport'.$i_nomer.'" type="text" value="'.$xpel_nil_nr.'" size="3" style="text-align:right" class="input" readonly>
			</td>
			<td>
			<input name="nil_raport_a'.$i_nomer.'" type="text" value="'.$xpel_nil_nr_a.'" size="3" style="text-align:right" class="input" readonly>
			</td>
			<td>
			<input name="nil_raport_p'.$i_nomer.'" type="text" value="'.$xpel_nil_nr_p.'" size="3" style="text-align:right" class="input" readonly>
			</td>
			</tr>';
			}
		while ($data = mysql_fetch_assoc($result));


		echo '</table>
		<table width="1200" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td>
		<input name="btnSMP" type="submit" value="SIMPAN">
		<input name="page" type="hidden" value="'.$page.'">
		'.$pagelist.'
		
		<input name="btnRST" type="submit" value="HAPUS SEMUA">
		</td>
		</tr>
		</table>';

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
