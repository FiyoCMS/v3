<?php

echo Form::open(['url' => '', 'method' => 'post']);  
?>

<div class="main">
    <div class="app-header">
        <h2>Login Sinaga</h2>
    </div>
    
    <div class="tbib">
		
        <div class="form-full">	
			<table class="" style="width:100%"><tr>
				<tr>
					<td style="width: 30%">Username</td>
					<td style="width: 70%">	
						<?php
							echo Form::text(
								'username', 
								'', 
								["class" => "form-control ",  "size" => "50" , "style"=>"width: 70%", "placeholder" => ""]
							);
						?> 
					</td>	
				</tr>
				<tr>
					<td style="width: 30%">Password</td>
					<td style="width: 70%">	
						<?php
							echo Form::password(
								'password', 
								'', 
								["class" => "form-control ",  "size" => "50" , "style"=>"width: 70%", "autocomplete" => "off"]
							);
						?> 
					</td>	
				</tr>
				<tr>
					<td style="width: 30%"></td>
					<td style="width: 70%"><br><br>
						<button class='btn btn-success ' name="login" value="true">Login</button>
					</td>	
				</tr>
				
			</table>
		</div>
	</div>
</div>

<?php
    Form::close();
?>