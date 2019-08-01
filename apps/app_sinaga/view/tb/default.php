<div class="main">
    <div class="app-header">
        <h2>Tugas Belajar</h2>
    </div>
    
    <div class="tbib">
        <div class="app-sub-header">
            <a class="btn btn-default panel" href="<?php echo make_permalink("?app=".app_param('app')); ?>"> 
           <i class="icon-arrow-left"></i> Kembali
            </a> 
        </div>

        <div class="list-menu">
            <a class="panel" href="<?php echo make_permalink("?app=".app_param('app')."&view=".app_param('view')."&type=pemberian"); ?>"> 
                    <div class="label-big" style="">
                        <div class="img">
                            <i class="icon-file-text"></i>
                        </div>
                        <h2>Pemberian</h2>
                        <p>
                            Keterangan tentang menu ini
                        <p>
                    </div>
            </a> 
            
            <a class="panel" href="<?php echo make_permalink("?app=".app_param('app')."&view=".app_param('view')."&type=monitoring"); ?>"> 
                    <div class="label-big" style="">
                        <div class="img">
                            <i class="icon-desktop"></i>
                        </div>
                        <h2>Monitoring</h2>
                        <p>
                            Keterangan tentang menu ini
                        <p>
                    </div>
            </a> 
        
        
            <a class="panel" href="<?php echo make_permalink("?app=".app_param('app')."&view=".app_param('view')."&type=perpanjangan"); ?>"> 
                <div class="label-big" style="">
                        <div class="img">
                            <i class="icon-legal"></i>
                        </div>
                    <h2>Perpanjangan</h2>
                    <p>
                        Keterangan tentang menu ini
                    <p>
                </div>
            </a> 
    </div> 
    </div> 
</div> 
