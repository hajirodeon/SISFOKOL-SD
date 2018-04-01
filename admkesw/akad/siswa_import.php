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

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admkesw.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "siswa_import.php";
$judul = "Import Siswa";
$judulku = "[$kesw_session : $nip12_session. $nm12_session] ==> $judul";
$juduly = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);



//PROSES //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//batal
if ($_POST['btnBTL'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$filex_namex = $_POST['filex_namex'];


	//hapus file
	$path1 = "../../filebox/excel/$filex_namex";
	chmod($path1,0777);
	unlink ($path1);

	//re-direct
	$ke = "siswa.php?tapelkd=$tapelkd&kelkd=$kelkd";
	xloc($ke);
	exit();
	}





//import sekarang
if ($_POST['btnIMx'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$filex_namex = $_POST['filex_namex'];

	//nek null
	if (empty($filex_namex))
		{
		//null-kan
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "siswa.php?tapelkd=$tapelkd&kelkd=$kelkd&s=import";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//deteksi .xls
		$ext_filex = substr($filex_namex, -4);

		if ($ext_filex == ".xls")
			{
			//nilai
			$path1 = "../../filebox/excel";

			//file-nya...
			$uploadfile = "$path1/$filex_namex";



			//require
			require_once '../../inc/class/excel/excel_reader2.php';
			$data = new Spreadsheet_Excel_Reader($uploadfile);


			// membaca jumlah baris dari data excel
			$baris = $data->rowcount($sheet_index=0);
			$jml_kolom = $data->colcount($sheet=0);



			// import data excel mulai baris ke-2 (karena baris pertama adalah nama kolom)
			for ($i=2; $i<=$baris; $i++)
				{
				$i_xyz = md5("$x$i");
				$i_nis = $data->val($i,'A');
				$i_nisn = $data->val($i,'B');
				$i_nama = $data->val($i,'C');
				$i_panggilan = $data->val($i,'D');

				//kelamin
				$i_kelamin = $data->val($i,'E');
				$qkela = mysql_query("SELECT * FROM m_kelamin ".
										"WHERE kelamin = '$i_kelamin'");
				$rkela = mysql_fetch_assoc($qkela);
				$kela_kd = nosql($rkela['kd']);
				$i_kelamin = $kela_kd;


				$i_tmp_lahir = $data->val($i,'F');
				$i_tgl_lahir = titikdua($data->val($i,'G'));
				$i_lahir_tgl = substr($i_tgl_lahir,0,2);
				$i_lahir_bln = substr($i_tgl_lahir,3,2);
				$i_lahir_thn = substr($i_tgl_lahir,-4);
				$i_tgl_lahir = "$i_lahir_thn:$i_lahir_bln:$i_lahir_tgl";

				//agama
				$i_agama = $data->val($i,'H');
				$qagm = mysql_query("SELECT * FROM m_agama ".
										"WHERE agama = '$i_agama'");
				$ragm = mysql_fetch_assoc($qagm);
				$agm_kd = nosql($ragm['kd']);
				$i_agama = $agm_kd;


				$i_warga_negara = $data->val($i,'I');
				$i_anak_ke = $data->val($i,'J');
				$i_jml_sdr_kandung = $data->val($i,'K');
				$i_jml_sdr_tiri = $data->val($i,'L');
				$i_jml_sdr_angkat = $data->val($i,'M');
				$i_bahasa = $data->val($i,'N');



				$i_alamat = $data->val($i,'O');
				$i_telp = $data->val($i,'P');
				$i_jarak = $data->val($i,'Q');



				$i_gol_darah = $data->val($i,'R');
				$i_penyakit = $data->val($i,'S');
				$i_kelainan = $data->val($i,'T');
				$i_tb = $data->val($i,'U');
				$i_bb = $data->val($i,'V');



				$i_tamat_dari = $data->val($i,'W');

				$i_tgl_ijazah = titikdua($data->val($i,'X'));
				$i_ijazah_tgl = substr($i_tgl_ijazah,0,2);
				$i_ijazah_bln = substr($i_tgl_ijazah,3,2);
				$i_ijazah_thn = substr($i_tgl_ijazah,-4);
				$i_tgl_ijazah = "$i_ijazah_thn:$i_ijazah_bln:$i_ijazah_tgl";

				$i_no_ijazah = $data->val($i,'Y');

				$i_lama_belajar = $data->val($i,'Z');



				$i_diterima_kelas = $data->val($i,'AA');

				$i_tgl_diterima = titikdua($data->val($i,'AB'));
				$i_diterima_tgl = substr($i_tgl_diterima,0,2);
				$i_diterima_bln = substr($i_tgl_diterima,3,2);
				$i_diterima_thn = substr($i_tgl_diterima,-4);
				$i_tgl_diterima = "$i_diterima_thn:$i_diterima_bln:$i_diterima_tgl";



				$i_ayah_nama = $data->val($i,'AC');
				$i_ayah_tmp_lahir = $data->val($i,'AD');

				$i_ayah_tgl_lahir = titikdua($data->val($i,'AE'));
				$i_ayah_lahir_tgl = substr($i_ayah_tgl_lahir,0,2);
				$i_ayah_lahir_bln = substr($i_ayah_tgl_lahir,3,2);
				$i_ayah_lahir_thn = substr($i_ayah_tgl_lahir,-4);
				$i_ayah_tgl_lahir = "$i_ayah_lahir_thn:$i_ayah_lahir_bln:$i_ayah_lahir_tgl";

				//agama
				$i_ayah_agama = $data->val($i,'AF');
				$qagmx = mysql_query("SELECT * FROM m_agama ".
										"WHERE agama = '$i_ayah_agama'");
				$ragmx = mysql_fetch_assoc($qagmx);
				$agmx_kd = nosql($ragmx['kd']);
				$i_ayah_agama = $agmx_kd;


				$i_ayah_warga_negara = $data->val($i,'AG');
				$i_ayah_pendidikan = $data->val($i,'AH');

				//pekerjaan
				$i_ayah_pekerjaan = $data->val($i,'AI');
				$qpekx = mysql_query("SELECT * FROM m_pekerjaan ".
										"WHERE pekerjaan = '$i_ayah_pekerjaan'");
				$rpekx = mysql_fetch_assoc($qpekx);
				$pekx_kd = nosql($rpekx['kd']);
				$i_ayah_pekerjaan = $pekx_kd;

				$i_ayah_penghasilan = $data->val($i,'AJ');
				$i_ayah_alamat = $data->val($i,'AK');
				$i_ayah_telp = $data->val($i,'AL');
				$i_ayah_hidup = $data->val($i,'AM');



				//ibu
				$i_ibu_nama = $data->val($i,'AN');
				$i_ibu_tmp_lahir = $data->val($i,'AO');

				$i_ibu_tgl_lahir = titikdua($data->val($i,'AP'));
				$i_ibu_lahir_tgl = substr($i_ibu_tgl_lahir,0,2);
				$i_ibu_lahir_bln = substr($i_ibu_tgl_lahir,3,2);
				$i_ibu_lahir_thn = substr($i_ibu_tgl_lahir,-4);
				$i_ibu_tgl_lahir = "$i_ibu_lahir_thn:$i_ibu_lahir_bln:$i_ibu_lahir_tgl";

				//agama
				$i_ibu_agama = $data->val($i,'AQ');
				$qagmx = mysql_query("SELECT * FROM m_agama ".
										"WHERE agama = '$i_ibu_agama'");
				$ragmx = mysql_fetch_assoc($qagmx);
				$agmx_kd = nosql($ragmx['kd']);
				$i_ibu_agama = $agmx_kd;


				$i_ibu_warga_negara = $data->val($i,'AR');
				$i_ibu_pendidikan = $data->val($i,'AS');

				//pekerjaan
				$i_ibu_pekerjaan = $data->val($i,'AT');
				$qpekx = mysql_query("SELECT * FROM m_pekerjaan ".
										"WHERE pekerjaan = '$i_ibu_pekerjaan'");
				$rpekx = mysql_fetch_assoc($qpekx);
				$pekx_kd = nosql($rpekx['kd']);
				$i_ibu_pekerjaan = $pekx_kd;

				$i_ibu_penghasilan = $data->val($i,'AU');
				$i_ibu_alamat = $data->val($i,'AV');
				$i_ibu_telp = $data->val($i,'AW');
				$i_ibu_hidup = $data->val($i,'AX');



				//wali
				$i_wali_nama = $data->val($i,'AY');
				$i_wali_tmp_lahir = $data->val($i,'AZ');

				$i_wali_tgl_lahir = titikdua($data->val($i,'BA'));
				$i_wali_lahir_tgl = substr($i_wali_tgl_lahir,0,2);
				$i_wali_lahir_bln = substr($i_wali_tgl_lahir,3,2);
				$i_wali_lahir_thn = substr($i_wali_tgl_lahir,-4);
				$i_wali_tgl_lahir = "$i_wali_lahir_thn:$i_wali_lahir_bln:$i_wali_lahir_tgl";

				//agama
				$i_wali_agama = $data->val($i,'BB');
				$qagmx = mysql_query("SELECT * FROM m_agama ".
										"WHERE agama = '$i_wali_agama'");
				$ragmx = mysql_fetch_assoc($qagmx);
				$agmx_kd = nosql($ragmx['kd']);
				$i_wali_agama = $agmx_kd;


				$i_wali_warga_negara = $data->val($i,'BC');
				$i_wali_pendidikan = $data->val($i,'BD');

				//pekerjaan
				$i_wali_pekerjaan = $data->val($i,'BE');
				$qpekx = mysql_query("SELECT * FROM m_pekerjaan ".
										"WHERE pekerjaan = '$i_wali_pekerjaan'");
				$rpekx = mysql_fetch_assoc($qpekx);
				$pekx_kd = nosql($rpekx['kd']);
				$i_wali_pekerjaan = $pekx_kd;

				$i_wali_penghasilan = $data->val($i,'BF');
				$i_wali_alamat = $data->val($i,'BG');
				$i_wali_telp = $data->val($i,'BH');





				$i_gemar_seni = $data->val($i,'BI');
				$i_gemar_or = $data->val($i,'BJ');
				$i_gemar_lain = $data->val($i,'BK');



				$i_bea_siswa = $data->val($i,'BL');






				//password...
				$i_pass = md5($i_nis);

				//ke mysql
				$qcc = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, ".
							"siswa_kelas.*, siswa_kelas.kd AS skkd ".
							"FROM m_siswa, siswa_kelas ".
							"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
							"AND siswa_kelas.kd_tapel = '$tapelkd' ".
							"AND siswa_kelas.kd_kelas = '$kelkd' ".
							"AND m_siswa.nis = '$i_nis'");
				$rcc = mysql_fetch_assoc($qcc);
				$tcc = mysql_num_rows($qcc);
				$cc_mskd = nosql($rcc['mskd']);
				$cc_skkd = nosql($rcc['skkd']);


				//jika ada, update
				if ($tcc != 0)
					{
					//m_siswa
					mysql_query("UPDATE m_siswa SET usernamex = '$i_nis', ".
							"passwordx = '$i_pass', ".
							"nisn = '$i_nisn', ".
							"nama = '$i_nama', ".
							"panggilan = '$i_panggilan', ".
							"tmp_lahir = '$i_tmp_lahir', ".
							"tgl_lahir = '$i_tgl_lahir', ".
							"kd_kelamin = '$i_kelamin', ".
							"kd_agama = '$i_agama', ".
							"warga_negara = '$i_warga_negara', ".
							"anak_ke = '$i_anak_ke', ".
							"jml_sdr_kandung = '$i_jml_sdr_kandung', ".
							"jml_sdr_tiri = '$i_jml_sdr_tiri', ".
							"jml_sdr_angkat = '$i_jml_sdr_angkat', ".
							"bhs_harian = '$i_bahasa' ".
							"WHERE nis = '$i_nis'");



					//update ke janissari
					mysql_query("UPDATE m_user SET usernamex = '$i_nis', ".
							"passwordx = '$i_pass', ".
							"nomor = '$i_nis', ".
							"nama = '$i_nama' ".
							"WHERE kd = '$cc_mskd'");


					//m_siswa_tmp_tinggal
					mysql_query("UPDATE m_siswa_tmp_tinggal SET alamat = '$i_alamat', ".
									"telp = '$i_telp', ".
									"jarak = '$i_jarak' ".
									"WHERE kd_siswa = '$cc_mskd'");


					//m_siswa_kesehatan
					mysql_query("UPDATE m_siswa_kesehatan SET gol_darah = '$i_gol_darah', ".
									"penyakit = '$i_penyakit', ".
									"kelainan = '$i_kelainan', ".
									"tinggi = '$i_tb', ".
									"berat = '$i_bb' ".
									"WHERE kd_siswa = '$cc_mskd'");

					//m_siswa_pendidikan
					mysql_query("UPDATE m_siswa_pendidikan SET lulusan = '$i_tamat_dari', ".
									"tgl_sttb = '$i_tgl_ijazah', ".
									"no_sttb = '$i_no_ijazah', ".
									"lama = '$i_lama_belajar', ".
									"WHERE kd_siswa = '$cc_mskd'");

					//m_siswa_diterima
					mysql_query("UPDATE m_siswa_diterima SET kelas = '$i_diterima_kelas', ".
									"tgl = '$i_tgl_diterima' ".
									"WHERE kd_siswa = '$cc_mskd'");

					//m_siswa_ayah
					mysql_query("UPDATE m_siswa_ayah SET nama = '$i_ayah_nama', ".
									"tmp_lahir = '$i_ayah_tmp_lahir', ".
									"tgl_lahir = '$i_ayah_tgl_lahir', ".
									"kd_agama = '$i_ayah_agama', ".
									"warga_negara = '$i_ayah_warga_negara', ".
									"pendidikan = '$i_ayah_pendidikan', ".
									"kd_pekerjaan = '$i_ayah_pekerjaan', ".
									"penghasilan = '$i_ayah_penghasilan', ".
									"alamat = '$i_ayah_alamat', ".
									"telp = '$i_ayah_telp', ".
									"hidup = '$i_ayah_hidup' ".
									"WHERE kd_siswa = '$cc_mskd'");


					//m_siswa_ibu
					mysql_query("UPDATE m_siswa_ibu SET nama = '$i_ibu_nama', ".
									"tmp_lahir = '$i_ibu_tmp_lahir', ".
									"tgl_lahir = '$i_ibu_tgl_lahir', ".
									"kd_agama = '$i_ibu_agama', ".
									"warga_negara = '$i_ibu_warga_negara', ".
									"pendidikan = '$i_ibu_pendidikan', ".
									"kd_pekerjaan = '$i_ibu_pekerjaan', ".
									"penghasilan = '$i_ibu_penghasilan', ".
									"alamat = '$i_ibu_alamat', ".
									"telp = '$i_ibu_telp', ".
									"hidup = '$i_ibu_hidup' ".
									"WHERE kd_siswa = '$cc_mskd'");

					//m_siswa_wali
					mysql_query("UPDATE m_siswa_wali SET nama = '$i_wali_nama', ".
									"tmp_lahir = '$i_wali_tmp_lahir', ".
									"tgl_lahir = '$i_wali_tgl_lahir', ".
									"kd_agama = '$i_wali_agama', ".
									"warga_negara = '$i_wali_warga_negara', ".
									"pendidikan = '$i_wali_pendidikan', ".
									"kd_pekerjaan = '$i_wali_pekerjaan', ".
									"penghasilan = '$i_wali_penghasilan', ".
									"alamat = '$i_wali_alamat', ".
									"telp = '$i_wali_telp' ".
									"WHERE kd_siswa = '$cc_mskd'");

					//m_siswa_hobi
					mysql_query("UPDATE m_siswa_wali SET kesenian = '$i_gemar_seni', ".
									"olah_raga = '$i_gemar_or', ".
									"lain_lain = '$i_gemar_lain' ".
									"WHERE kd_siswa = '$cc_mskd'");

					//m_siswa_perkembangan
					mysql_query("UPDATE m_siswa_perkembangan SET bea_siswa = '$i_bea_siswa' ".
									"WHERE kd_siswa = '$cc_mskd'");
					}

				//jika blm ada, insert
				else
					{
					//m_siswa
					mysql_query("INSERT INTO m_siswa(kd, usernamex, passwordx, nis, nisn, nama, panggilan, ".
							"tmp_lahir, tgl_lahir, kd_kelamin, kd_agama, warga_negara, ".
							"anak_ke, jml_sdr_kandung, jml_sdr_tiri, jml_sdr_angkat, bhs_harian) VALUES ".
							"('$i_xyz', '$i_nis', '$i_pass', '$i_nis', '$i_nisn', '$i_nama', '$i_panggilan', ".
							"'$i_tmp_lahir', '$i_tgl_lahir', '$i_kelamin', '$i_agama', '$i_warga_negara', ".
							"'$i_anak_ke', '$i_jml_sdr_kandung', '$i_jml_sdr_tiri', '$i_jml_sdr_angkat', '$i_bahasa')");


					//masukkan ke janissari
					mysql_query("INSERT INTO m_user(kd, usernamex, passwordx, nomor, nama, tipe, postdate) VALUES ".
							"('$i_xyz', '$i_nis', '$i_pass', '$i_nis', '$i_nama', 'SISWA', '$today')");


					//siswa_kelas
					mysql_query("INSERT INTO siswa_kelas(kd, kd_tapel, kd_kelas, kd_siswa) VALUES ".
									"('$i_xyz', '$tapelkd', '$kelkd', '$i_xyz')");

					//m_siswa_tmp_tinggal
					mysql_query("INSERT INTO m_siswa_tmp_tinggal(kd, kd_siswa, alamat, telp, jarak) VALUES ".
									"('$i_xyz', '$i_xyz', '$i_alamat', '$i_telp', '$i_jarak')");

					//m_siswa_kesehatan
					mysql_query("INSERT INTO m_siswa_kesehatan(kd, kd_siswa, gol_darah, penyakit, kelainan, tinggi, berat) VALUES ".
									"('$i_xyz', '$i_xyz', '$i_gol_darah', '$i_penyakit', '$i_kelainan', '$i_tb', '$i_bb')");

					//m_siswa_pendidikan
					mysql_query("INSERT INTO m_siswa_pendidikan(kd, kd_siswa, lulusan, tgl_sttb, no_sttb, lama) VALUES ".
									"('$i_xyz', '$i_xyz', '$i_tamat_dari', '$i_tgl_ijazah', '$i_no_ijazah', '$i_lama_belajar')");

					//m_siswa_diterima
					mysql_query("INSERT INTO m_siswa_diterima(kd, kd_siswa, kelas, tgl) VALUES ".
									"('$i_xyz', '$i_xyz', '$i_diterima_kelas', '$i_tgl_diterima')");

					//m_siswa_ayah
					mysql_query("INSERT INTO m_siswa_ayah(kd, kd_siswa, nama, tmp_lahir, tgl_lahir, kd_agama, ".
									"warga_negara, pendidikan, kd_pekerjaan, penghasilan, alamat, telp, hidup) VALUES ".
									"('$i_xyz', '$i_xyz', '$i_ayah_nama', '$i_ayah_tmp_lahir', '$i_ayah_tgl_lahir', ".
									"'$i_ayah_agama', '$i_ayah_warga_negara', '$i_ayah_pendidikan', '$i_ayah_pekerjaan', ".
									"'$i_ayah_penghasilan', '$i_ayah_alamat', '$i_ayah_telp', '$i_ayah_hidup')");

					//m_siswa_ibu
					mysql_query("INSERT INTO m_siswa_ibu(kd, kd_siswa, nama, tmp_lahir, tgl_lahir, kd_agama, ".
									"warga_negara, pendidikan, kd_pekerjaan, penghasilan, alamat, telp, hidup) VALUES ".
									"('$i_xyz', '$i_xyz', '$i_ibu_nama', '$i_ibu_tmp_lahir', '$i_ibu_tgl_lahir', ".
									"'$i_ibu_agama', '$i_ibu_warga_negara', '$i_ibu_pendidikan', '$i_ibu_pekerjaan', ".
									"'$i_ibu_penghasilan', '$i_ibu_alamat', '$i_ibu_telp', '$i_ibu_hidup')");

					//m_siswa_wali
					mysql_query("INSERT INTO m_siswa_wali(kd, kd_siswa, nama, tmp_lahir, tgl_lahir, kd_agama, ".
									"warga_negara, pendidikan, kd_pekerjaan, penghasilan, alamat, telp) VALUES ".
									"('$i_xyz', '$i_xyz', '$i_wali_nama', '$i_wali_tmp_lahir', '$i_wali_tgl_lahir', ".
									"'$i_wali_agama', '$i_wali_warga_negara', '$i_wali_pendidikan', '$i_wali_pekerjaan', ".
									"'$i_wali_penghasilan', '$i_wali_alamat', '$i_wali_telp')");

					//m_siswa_hobi
					mysql_query("INSERT INTO m_siswa_hobi(kd, kd_siswa, kesenian, olah_raga, lain_lain) VALUES ".
									"('$i_xyz', '$i_xyz', '$i_gemar_seni', '$i_gemar_or', '$i_gemar_lain')");

					//m_siswa_prestasi
					mysql_query("INSERT INTO m_siswa_perkembangan(kd, kd_siswa, bea_siswa) VALUES ".
									"('$i_xyz', '$i_xyz', '$i_bea_siswa')");
					}
				}


			//hapus file, jika telah import
			$path1 = "../../filebox/excel/$filex_namex";
			chmod($path1,0777);
			unlink ($path1);

			//null-kan
			xclose($koneksi);

			//re-direct
			$ke = "siswa.php?tapelkd=$tapelkd&kelkd=$kelkd";
			xloc($ke);
			exit();
			}
		else
			{
			//null-kan
			xclose($koneksi);

			//salah
			$pesan = "Bukan File .xls . Harap Diperhatikan...!!";
			$ke = "siswa.php?tapelkd=$tapelkd&kelkd=$kelkd&s=import";
			pekem($pesan,$ke);
			exit();
			}
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi *START
ob_start();

//menu
require("../../inc/menu/admkesw.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();





//isi *START
ob_start();


//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
xheadline($judul);


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" enctype="multipart/form-data" action="'.$filenya.'">
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
</table>';


$filex_namex = $_REQUEST['filex_namex'];

//nilai
$path1 = "../../filebox/excel/$filex_namex";

//file-nya...
$uploadfile = $path1;


echo '<p>
Nama File Yang di-Import : <strong>'.$filex_namex.'</strong>
<br>
<input name="filex_namex" type="hidden" value="'.$filex_namex.'">
<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
<input name="btnBTL" type="submit" value="<< BATAL">
<input name="btnIMx" type="submit" value="IMPORT Sekarang>>">
</p>
</form>
<br>
<br>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi
$isi = ob_get_contents();
ob_end_clean();


require("../../inc/niltpl.php");


//diskonek
xclose($koneksi);
exit();
?>