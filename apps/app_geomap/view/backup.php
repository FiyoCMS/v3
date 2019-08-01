<?php 
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2019 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	
**/

   
defined('_FINDEX_') or die('Access Denied');
?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"
   integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
   crossorigin=""/>

    <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"
   integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
   crossorigin=""></script>

<script src='https://api.mapbox.com/mapbox-gl-js/v0.54.0/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v0.54.0/mapbox-gl.css' rel='stylesheet' />

<form id="mapForm">
<div id="mapLegend">
    <h3>INFORMASI</h3>
    <ul id="menu" class="collapse top affix content  menu-collapse">

    <li>     
        <div> <?php echo Form::checkbox("kec","","1",["target"=>"kecamatan[]"],"Kecamatan"); ?>
            <a data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#nav-1">
        
                    <span class="pull-right">
                    <i class="icon-angle-left"></i>
                    <i class="icon-angle-down"></i>
                    </span>
            </a>
        </div>
        <?php    
            $qr = DB::table(FDBPrefix."zona_kecamatan")->where("kota = 1")->orderBy("nama_kecamatan")->get();
            if(isset($qr[0])) :
        ?>
        <ul class="sub-menu collapse" id="nav-1" style="height: auto;">
            <?php foreach($qr as $kec) : ?>
            <li><a><?php echo Form::checkbox("kecamatan[]",$kec['nama_kecamatan'],"",[],$kec['nama_kecamatan']); ?></a></li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </li>
    
    <li>
    <div> <?php echo Form::checkbox("bencana_banjir","","1",["target"=>"kelas[]"],"Kelas Banjir"); ?>
            <a data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#nav-2">
                    <span class="pull-right">
                    <i class="icon-angle-left"></i>
                    <i class="icon-angle-down"></i>
                    </span>
            </a>
        </div>
        <?php    
            $qr = DB::table(FDBPrefix."bencana_banjir")->select("kelas")->where("kota = 1")->groupBy("kelas")->get();
            if(isset($qr[0])) :
        ?>
        <ul class="sub-menu collapse" id="nav-2" style="height: auto;">
            <?php foreach($qr as $bjr) : ?>
            <li><a><?php echo Form::checkbox("kelas[]",$bjr['kelas'],"",[],$bjr['kelas']); ?></a></li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </li>

    <li>
    <div> <?php echo Form::checkbox("area_banjir","","1",["target" => "area[]"],"Jenis Area Banjir"); ?>
            <a data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#nav-3">
                    <span class="pull-right">
                    <i class="icon-angle-left"></i>
                    <i class="icon-angle-down"></i>
                    </span>
            </a>
        </div>
        <?php    
            $qr = DB::table(FDBPrefix."bencana_banjir")->select("area")->where("kota = 1")->groupBy("area")->get();
            if(isset($qr[0])) :
        ?>
        <ul class="sub-menu collapse" id="nav-3" style="height: auto;">
            <?php foreach($qr as $bjr) : ?>
            <li><a><?php echo Form::checkbox("area[]",$bjr['area'],"",[],$bjr['area']); ?></a></li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </li>


    
    </ul>
</div>
</form>
<div id="map" style="height: 400px"></div>



    <script src="<?php echo FUrl;?>?app=geomap&api=geojson"></script>
	<script>
		var map = L.map('map').setView([ -6.9877, 110.434310726000081], 13);
		L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
			maxZoom: 18,
			attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
				'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
				'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
			id: 'mapbox.streets'
        }).addTo(map);
        
        function zoomToFeature(e) {
            map.fitBounds(e.target.getBounds());
        }
        function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
        }

        
        ini = false;
        $(function () {
            formMap();
            $("#mapForm input[type='checkbox']").change(function () {
                formMap();
            });
        });

        function formMap() {
            ff = $("#mapForm").serializeArray();
            if(ini) ini.remove();
            ini = loadMap('Sedang',ff);
            ini.addTo(map);
        }

        function getGeoJSON(file) {      
            var json = null;
            $.ajax({
                'async': true,
                'global': false,
                'url': "?app=geomap&api=geojson",
                'dataType': "json",
                'success': function (data) {
                        json = data;
                }
             });
            return json;
        }
        
        function loadMap(filter, ff) {
            f = x = filtemp =[];
            tar = '';
            fi = 0;
            if(ff) {
                ff.forEach(function(d) {
                    if(d['name'].includes("[]") ) {
                       
                    if(tar != d['name']) {
                        arname = d['name'].replace("[]", "");
                        tar = d['name'];
                        f[arname] = [];
                    }
                    f[arname].push(d['value']);
                    }
                    else {
                        f[d['name']] = d['value'];
                    }
                    fi++;
                });
            }

            //console.log(f);
        
            return L.geoJson(data_banjir, {
                    style: function (feature) {
                    ini = {};

                        if (feature.properties.kelas == "Sedang") {
                            ini = {                    
                                color: '#fbc531',
                                fillOpacity: 0.5,
                                dashArray: '2',
                            }
                        } else if (feature.properties.kelas == "Tinggi") {
                            ini = {                    
                                color: '#e17055',
                                fillOpacity: 0.5,
                                dashArray: '2',
                            }
                        } else {
                            ini = {                        
                                color: '#4cd137',
                                fillOpacity: 0.5,
                                dashArray: '2',
                            }
                        }
                        return ini;
                    },
                    filter: (feature) =>  {
                        console.log(f['kelas']);
                        const kecamatanCon = f['kecamatan'].includes(feature.properties.kecamatan);
                        const kelasCon = f['kelas'].includes(feature.properties.kelas);
                        const Area = f['area'].includes(feature.properties.area);
                        return (kelasCon && Area && kecamatanCon);
                    },
                    onEachFeature: onEachFeature
                });
        }
   

        i = 0;
		function onEachFeature(feature, layer) {
            var popupContent = "<table> " 
            + "<tr><td>Lokasi </td><td>: "+ feature.properties.lokasi + "</td></tr>"
            + "<tr><td>Kecamatan </td><td>: "+ feature.properties.kecamatan + "</td></tr>"
            + "<tr><td>Kelas Banjir </td><td>: "+ feature.properties.kelas + "</td></tr>"
            + "<tr><td>Jenis Area </td><td>: "+ feature.properties.area + " asas</td></tr>";


			if (feature.properties && feature.properties.popupContent) {
				popupContent += feature.properties.popupContent;
				popupContent += " asdasdsd";
            }
            
            layer.bindPopup(popupContent);
            layer.on({
                click: zoomToFeature
            });

            $("#mapForm input[type='checkbox']").change(function () {
               // layer.filter(feature, layer);

              
                i++;
            });
              
			
        }
        //console.log(kelas);
	</script>



