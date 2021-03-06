<?php
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
/////// SISFOKOL_SD_v5.0_(PernahJaya)                          ///////
/////// (Sistem Informasi Sekolah untuk SD)                    ///////
///////////////////////////////////////////////////////////////////////
/////// Dibuat oleh :                                           ///////
/////// Agus Muhajir, S.Kom                                     ///////
/////// URL 	:                                               ///////
///////     * http://omahbiasawae.com/                          ///////
///////     * http://sisfokol.wordpress.com/                    ///////
///////     * http://hajirodeon.wordpress.com/                  ///////
///////     * http://yahoogroup.com/groups/sisfokol/            ///////
///////     * http://yahoogroup.com/groups/linuxbiasawae/       ///////
/////// E-Mail	:                                               ///////
///////     * hajirodeon@yahoo.com                              ///////
///////     * hajirodeon@gmail.com                              ///////
/////// HP/SMS/WA : 081-829-88-54                               ///////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////



session_start();

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admwaka.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "guru_prog_pddkn_tmp.php";
$judul = "Penempatan Guru Mengajar";
$judulku = "[$waka_session : $nip10_session.$nm10_session] ==> $judul";
$judulx = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$jnskd = nosql($_REQUEST['jnskd']);
$s = nosql($_REQUEST['s']);
$ke = "$filenya?tapelkd=$tapelkd&jnskd=$jnskd";




//focus...
if (empty($tapelkd))
	{
	$diload = "document.formx.tapel.focus();";
	}
else if (empty($jnskd))
	{
	$diload = "document.formx.jenis.focus();";
	}





//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$jnskd = nosql($_POST['jnskd']);
	$pelkd = nosql($_POST['pelkd']);
	$gurkd = nosql($_POST['gurkd']);

	//nek null
	if ((empty($pelkd)) OR (empty($gurkd)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//cek
		$qc = mysql_query("SELECT m_guru_prog_pddkn.*, m_guru.* ".
							"FROM m_guru_prog_pddkn, m_guru ".
							"WHERE m_guru_prog_pddkn.kd_guru = m_guru.kd ".
							"AND m_guru.kd_tapel = '$tapelkd' ".
							"AND m_guru.kd_kelas = '$kelkd' ".
							"AND m_guru_prog_pddkn.kd_prog_pddkn = '$pelkd' ".
							"AND m_guru.kd_pegawai = '$gurkd'");
		$rc = mysql_fetch_assoc($qc);
		$tc = mysql_num_rows($qc);
		$guru = balikin2($rx['nama']);

		//nek ada, msg
		if ($tc != 0)
			{
			//re-direct
			$pesan = "Guru Tersebut Telah Mengajar Mata Pelajaran Tersebut. Silahkan Ganti...!";
			pekem($pesan,$ke);
			}
		else
			{
			//deteksi
			$qcc = mysqL_query("SELECT m_guru.*, m_guru.kd AS mgkd, ".
									"m_pegawai.*, m_pegawai.kd AS mpkd ".
									"FROM m_guru, m_pegawai ".
									"WHERE m_guru.kd_pegawai = m_pegawai.kd ".
									"AND m_guru.kd_pegawai = '$gurkd' ".
									"AND m_guru.kd_tapel = '$tapelkd' ".
									"AND m_guru.kd_kelas = '$kelkd'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);
			$cc_mgkd = nosql($rcc['mgkd']);
			$cc_mpkd = nosql($rcc['mpkd']);
			$cc_nip = nosql($rcc['nip']);
			$cc_nm = balikin($rcc['nama']);
			$cc_xyz = md5("$today");


			//nek iya
			if ($tcc != 0)
				{
				//query
				mysql_query("INSERT INTO m_guru_prog_pddkn(kd, kd_prog_pddkn, kd_guru) VALUES ".
						"('$x', '$pelkd', '$cc_mgkd')");
				}
			else
				{
				//query
				mysql_query("INSERT INTO m_guru(kd, kd_tapel, kd_keahlian, kd_keahlian_kompetensi, ".
						"kd_kelas, kd_pegawai) VALUES ".
						"('$cc_xyz', '$tapelkd', '$keakd', '$kompkd', ".
						"'$kelkd', '$gurkd')");


				//query
				mysql_query("INSERT INTO m_guru_prog_pddkn(kd, kd_prog_pddkn, kd_guru) VALUES ".
					"('$x', '$pelkd', '$cc_xyz')");
				}


			//re-direct
			xloc($ke);
			exit();
			}
		}
	}



//jika hapus
if ($s == "hapus")
	{
	//nilai
	$tapelkd = nosql($_REQUEST['tapelkd']);
	$kelkd = nosql($_REQUEST['kelkd']);
	$jnskd = nosql($_REQUEST['jnskd']);
	$pelkd = nosql($_REQUEST['pelkd']);
	$gurkd = nosql($_REQUEST['gurkd']);
	$gkd = nosql($_REQUEST['gkd']);

	//query
	mysql_query("DELETE FROM m_guru_prog_pddkn ".
			"WHERE kd = '$gkd'");

	//re-direct
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();

//menu
require("../../inc/menu/admwaka.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();






//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/checkall.js");
require("../../inc/js/swap.js");
xheadline($judul);

//VIEW //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$ke.'">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Tahun Pelajaran : ';
echo "<select name=\"tapel\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qtpx = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd = '$tapelkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_thn1 = nosql($rowtpx['tahun1']);
$tpx_thn2 = nosql($rowtpx['tahun2']);

echo '<option value="'.$tpx_kd.'">'.$tpx_thn1.'/'.$tpx_thn2.'</option>';

$qtp = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd <> '$tapelkd' ".
						"ORDER BY tahun1 ASC");
$rowtp = mysql_fetch_assoc($qtp);

do
	{
	$tpkd = nosql($rowtp['kd']);
	$tpth1 = nosql($rowtp['tahun1']);
	$tpth2 = nosql($rowtp['tahun2']);

	echo '<option value="'.$filenya.'?tapelkd='.$tpkd.'">'.$tpth1.'/'.$tpth2.'</option>';
	}
while ($rowtp = mysql_fetch_assoc($qtp));

echo '</select>,


Jenis Mata Pelajaran : ';
echo "<select name=\"jenis\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qjnx = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE kd = '$jnskd'");
$rowjnx = mysql_fetch_assoc($qjnx);

$jnx_kd = nosql($rowjnx['kd']);
$jnx_jns = balikin($rowjnx['jenis']);

echo '<option value="'.$jnx_kd.'">'.$jnx_jns.'</option>';

//jenis
$qjn = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE kd <> '$jnskd' ".
						"ORDER BY no ASC, ".
						"no_sub ASC");
$rowjn = mysql_fetch_assoc($qjn);

do
	{
	$jn_kd = nosql($rowjn['kd']);
	$jn_jns = balikin($rowjn['jenis']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&jnskd='.$jn_kd.'">'.$jn_jns.'</option>';
	}
while ($rowjn = mysql_fetch_assoc($qjn));

echo '</select>

<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="jnskd" type="hidden" value="'.$jnskd.'">
</td>
</tr>
</table>
<br>';


//nek blm
if (empty($tapelkd))
	{
	echo '<h4>
	<strong><font color="#FF0000">TAHUN PELAJARAN Belum Dipilih...!</font></strong>
	</h4>';
	}

else if (empty($jnskd))
	{
	echo '<h4>
	<strong><font color="#FF0000">JENIS PROGRAM PENDIDIKAN Belum Dipilih...!</font></strong>
	</h4>';
	}
else
	{
	echo '<select name="gurkd">
	<option value="" selected>-GURU-</option>';

	//daftar guru
	$qg = mysql_query("SELECT nip, nama ".
						"FROM m_pegawai ".
						"ORDER BY nama ASC");
	$rg = mysql_fetch_assoc($qg);



	do
		{
		$i_nip = nosql($rg['nip']);



		//detail
		$qpd = mysql_query("SELECT m_pegawai.*, m_pegawai.kd AS mpkd ".
								"FROM m_pegawai ".
								"WHERE nip = '$i_nip'");
		$rpd = mysql_fetch_assoc($qpd);
		$pd_mpkd = nosql($rpd['mpkd']);
		$pd_nama = balikin($rpd['nama']);


		echo '<option value="'.$pd_mpkd.'">'.$pd_nama.'  ['.$i_nip.'].</option>';
		}
	while ($rg = mysql_fetch_assoc($qg));

	echo '</select>
	<br>

	<select name="pelkd">
	<option value="" selected>-MATA PELAJARAN-</option>';
	//daftar mapel
	$qbs = mysql_query("SELECT DISTINCT(m_prog_pddkn.kd) AS mmkd ".
							"FROM m_prog_pddkn_kelas, m_prog_pddkn ".
							"WHERE m_prog_pddkn_kelas.kd_prog_pddkn = m_prog_pddkn.kd ".
							"AND m_prog_pddkn_kelas.kd_tapel = '$tapelkd' ".
							"AND m_prog_pddkn.kd_jenis = '$jnskd' ".
							"ORDER BY round(m_prog_pddkn.no) ASC, ".
							"round(m_prog_pddkn.no_sub) ASC");
	$rbs = mysql_fetch_assoc($qbs);

	do
		{
		$bskd = nosql($rbs['mmkd']);


		//prog-nya
		$qprog = mysql_query("SELECT * FROM m_prog_pddkn ".
					"WHERE kd = '$bskd'");
		$rprog = mysql_fetch_assoc($qprog);
		$bspel = balikin2($rprog['prog_pddkn']);

		echo '<option value="'.$bskd.'">'.$bspel.'</option>';
		}
	while ($rbs = mysql_fetch_assoc($qbs));

	echo '</select>
	<br>

	<select name="kelkd">
	<option value="" selected>-KELAS-</option>';
	//kelas
	$qrua = mysql_query("SELECT * FROM m_kelas ".
							"WHERE kelas LIKE '%$keax_singk%' ".
							"ORDER BY round(no) ASC, ".
							"kelas ASC");
	$rrua = mysql_fetch_assoc($qrua);

	do
		{
		$ruakd = nosql($rrua['kd']);
		$rua = balikin2($rrua['kelas']);

		echo '<option value="'.$ruakd.'">'.$rua.'</option>';
		}
	while ($rrua = mysql_fetch_assoc($qrua));

	echo '</select>
	<br>

	<input name="keakd" type="hidden" value="'.$keakd.'">
	<input name="kompkd" type="hidden" value="'.$kompkd.'">
	<input name="jnskd" type="hidden" value="'.$jnskd.'">
	<input name="btnSMP" type="submit" value="TAMBAH >>">
	</p>';

	//query
	$q = mysql_query("SELECT DISTINCT(m_pegawai.nip) AS nip ".
						"FROM m_guru, m_pegawai ".
						"WHERE m_guru.kd_pegawai = m_pegawai.kd ".
						"ORDER BY round(m_pegawai.nip) ASC");
	$row = mysql_fetch_assoc($q);
	$total = mysql_num_rows($q);

	if ($total != 0)
		{
		echo '<table width="700" border="1" cellpadding="3" cellspacing="0">
	    	<tr bgcolor="'.$warnaheader.'">
			<td width="5" valign="top"><strong>No.</strong></td>
			<td width="5" valign="top"><strong>NIP</strong></td>
	    	<td valign="top"><strong><font color="'.$warnatext.'">Guru</font></strong></td>
	    	<td width="300" valign="top"><strong><font color="'.$warnatext.'">Kelas - Mata Pelajaran</font></strong></td>
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

			$nomer = $nomer + 1;
			$i_nip = nosql($row['nip']);

			//detail
			$qpd = mysql_query("SELECT * FROM m_pegawai ".
						"WHERE nip = '$i_nip'");
			$rpd = mysql_fetch_assoc($qpd);
			$pd_kd = nosql($rpd['kd']);
			$pd_nama = balikin($rpd['nama']);


			//nek null
			if (empty($i_nip))
				{
				$i_nip = "-";
				}

			echo "<tr bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td valign="top">'.$nomer.'. </td>
    			<td valign="top">'.$i_nip.'</td>
			<td valign="top">
			'.$pd_nama.'
			</td>
			<td valign="top">';

			//pel-nya
			$quru = mysql_query("SELECT m_guru_prog_pddkn.*, m_guru_prog_pddkn.kd AS mgkd, m_guru.* ".
									"FROM m_guru_prog_pddkn, m_guru ".
									"WHERE m_guru_prog_pddkn.kd_guru = m_guru.kd ".
									"AND m_guru.kd_pegawai = '$pd_kd'");
			$ruru = mysql_fetch_assoc($quru);


			do
				{
				$gkd = nosql($ruru['mgkd']);
				$kd_prog_pddkn = nosql($ruru['kd_prog_pddkn']);
				$pkd = nosql($ruru['kd_prog_pddkn']);
				$kd_kelas = nosql($ruru['kd_kelas']);


				//mapel
				$q1 = mysql_query("SELECT * FROM m_prog_pddkn ".
							"WHERE kd = '$kd_prog_pddkn'");
				$r1 = mysql_fetch_assoc($q1);
				$gpel = balikin($r1['prog_pddkn']);


				//kelas
				$q2 = mysql_query("SELECT * FROM m_kelas ".
							"WHERE kd = '$kd_kelas'");
				$r2 = mysql_fetch_assoc($q2);
				$gkelas = balikin($r2['kelas']);


				//nek null
				if (empty($gkd))
					{
					echo "-";
					}
				else
					{
					//cek janissari
					$qcc1 = mysql_query("SELECT * FROM guru_mapel ".
								"WHERE kd_user = '$pd_kd' ".
								"AND kd_mapel = '$pkd'");
					$rcc1 = mysql_fetch_assoc($qcc1);
					$tcc1 = mysql_num_rows($qcc1);

					//jika ada, update
					if ($tcc1 != 0)
						{
						//cuekin aja...
						}
					else
						{
						//masukkan ke janissari
						mysql_query("INSERT INTO guru_mapel(kd, kd_user, kd_mapel) VALUES ".
								"('$pkd', '$pd_kd', '$pkd')");
						}

					echo '<strong>*</strong>('.$gkelas.') '.$gpel.'
					[<a href="'.$ke.'&s=hapus&gkd='.$gkd.'" title="HAPUS --> '.$gpel.'"><img src="'.$sumber.'/img/delete.gif" width="16" height="16" border="0"></a>]. <br>';
					}
				}
			while ($ruru = mysql_fetch_assoc($quru));



			echo '</td>
    			</tr>';
			}
		while ($row = mysql_fetch_assoc($q));

		echo '</table>
		<table width="700" border="0" cellspacing="0" cellpadding="3">
    	<tr>
    	<td align="right">Total : <strong><font color="#FF0000">'.$total.'</font></strong> Data.</td>
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
?>