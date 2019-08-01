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
   
    <script src="https://unpkg.com/topojson-client@3"></script>

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
    <div> <?php echo Form::checkbox("bencana_banjir","","1",["target"=>"kelas[]"],"Kelas Bencana"); ?>
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
    <div> <?php echo Form::checkbox("area_banjir","","1",["target" => "area[]"],"Jenis Area Bencana"); ?>
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



    <li>
    <div> 
    <?php echo Form::checkbox("data_bangunan","","",["target" => "bangunan[]"],"Data Bangunan <span class='jml'></span>"); ?>
            <a data-parent="#menu" data-toggle="collapse" class="accordion-toggle">
                 
            </a>
        </div>
    </li>

    

    
    </ul>
</div>
</form>
<div id="map" style="height: 400px"></div>



    <script src="<?php echo FUrl;?>?app=geomap&api=bencana&type=<?php echo app_param('view'); ?>"></script>

    <script src="<?php echo FUrl;?>?app=geomap&api=bangunan&type=<?php echo app_param('view'); ?>"></script>

    

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


        L.GeoJSON.extend({
                addData: function(jsonData) 
                {    
                    if (jsonData.type === "Topology") 
                    {
                        for (key in jsonData.objects) 
                        {
                            geojson = topojson.feature(	jsonData, 
                                            jsonData.objects[key]);
                            L.GeoJSON.prototype.addData.call(this, geojson);
                        }
                    }    
                    else 
                    {
                        L.GeoJSON.prototype.addData.call(this, jsonData);
                    }
                }  
            });

        
        m1 = m2 = false;
        $(function () {
            formMap();
            $("#mapForm input[type='checkbox']").change(function () {
                formMap();
            });
        });

        function formMap() {
            ff = $("#mapForm").serializeArray();
            if(m1) m1.remove();
            if(m2) m2.remove();
            
            m1 = loadMap(ff);
            m1.addTo(map);   

            m2 = loadMap2(ff);
            m2.addTo(map);
                     
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
        
        //Load Peta Bencana
        function loadMap(ff) {
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
            $(".jml").html("(" + data_bangunan_<?php echo app_param('view'); ?>.features.length + ")"  );
        
            return L.geoJson(data_bencana_<?php echo app_param('view'); ?>, {
                style: function (feature) {
                    ini = {};

                    if (feature.properties.KelasMulti == "Sedang") {
                        ini = {                    
                            color: '#fbc531',
                            fillOpacity: 0.5,
                            dashArray: '2',
                        }
                    } else if (feature.properties.KelasMulti == "Tinggi") {
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
                    const kecamatanCon = f['kecamatan'].includes(feature.properties.KEC);
                    const kelasCon = f['kelas'].includes(feature.properties.KelasMulti);
                    return (kelasCon && kecamatanCon);
                },
                onEachFeature: onEachFeature
            });
        }
   
        
        //Load Bangunan
        function loadMap2(ff) {
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
            return L.geoJson(data_bangunan_<?php echo app_param('view'); ?>, {
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
                            color: '#3498db',
                            fillOpacity: 0.5,
                            dashArray: '2',
                        }
                    }
                    return ini;
                },
                filter: (feature) =>  {   
                    const kecamatanCon = f['kecamatan'].includes(feature.properties.KECAMATAN);
                    const bangunan = f['data_bangunan'];

                    return (kecamatanCon && bangunan);
                },
                onEachFeature: onEachFeature2
            });
        }

        i = 0;

        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
        }

		function onEachFeature(feature, layer) {
            var popupContent = "<table> " 
            + "<tr><td>Kecamatan </td><td>: "+ feature.properties.KEC + "</td></tr>"
            + "<tr><td>Kelas Bencana </td><td>: "+ feature.properties.KelasMulti + "</td></tr>"


			if (feature.properties && feature.properties.popupContent) {
				popupContent += feature.properties.popupContent;
            }
            
            layer.bindPopup(popupContent);
            layer.on({
                click: zoomToFeature
            });

              
			
        }

        
		function onEachFeature2(feature, layer) {
            var popupContent = "<table> " 
            + "<tr><td>Kelurahan </td><td>: "+ feature.properties.KELURAHAN + "</td></tr>"
            + "<tr><td>Kecamatan </td><td>: "+ feature.properties.KECAMATAN + "</td></tr>"


			if (feature.properties && feature.properties.popupContent) {
				popupContent += feature.properties.popupContent;
            }
            
            layer.bindPopup(popupContent);
            layer.on({
                click: zoomToFeature
            });

              
			
        }
        //console.log(kelas);
	</script>



