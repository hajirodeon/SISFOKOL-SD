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






require("../../../inc/js/wz_jsgraphics.js");
require("../../../inc/js/pie.js");
?>
<!-- graph code begins here
<script type="text/javascript" src="../../../inc/js/wz_jsgraphics.js"></script>
<script type="text/javascript" src="../../../inc/js/pie.js">

<!-- Pie Graph script-By Balamurugan S http://www.sbmkpm.com/
<!-- Script featured/ available at Dynamic Drive code: http://www.dynamicdrive.com

</script>
//-->



<div id="pieCanvas" style="overflow: auto; position:relative;height:350px;width:380px;"></div>


<script type="text/javascript">
var p = new pie();
p.add("Jan",100);
p.add("Feb",200);
p.add("Mar",150);
p.add("Apr",120);
p.add("May",315);
p.add("Jun",415);
p.add("Jul",315);
p.render("pieCanvas", "Pie Graph")

</script>
<!-- graph code ends here-->
