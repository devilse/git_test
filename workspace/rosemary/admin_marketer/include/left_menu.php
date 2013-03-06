<table width="210" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td align="center">
			<table width="192" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td align="center">
						<table width="181" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">

<?php
			

				if($current_menu_code != NULL && !empty($current_menu_code)) {		
					foreach ($sitemap[substr($current_menu_code, 0, 2)] as $groupkey => $groupval) {			
						if(is_array($groupval)) {
?>
							<tr bgcolor="#EFEFEF">
								<td>
									<div align="center">
										<b><?php echo $groupval[0]; ?> </b>
									</div>
								</td>
							</tr>
							<tr>
								<td bgcolor="#FFFFFF" align="left">
							
<?php																				
							foreach ($groupval as $menukey => $menuval) {
								if(is_array($menuval)) {
									if($current_menu_code == $menukey) {
										// 선택된 메뉴일 경우
										echo "&nbsp;- <a href=\"$menuval[2]\"><strong><font color=red>$menuval[1]</font></strong></a><br />";
									} else {
										if($menuval[2] == "#") {
											echo "&nbsp;- <font color=\"gray\">$menuval[1]</font><br />";
										} else {
											echo "&nbsp;- <a href=\"$menuval[2]\">$menuval[1]</a><br />";
										}
									}
								}					
							}			
						}			
					} 
				}							
?>
								</td>
							</tr>							
						</table>

					</td>
				</tr>

			</table>
		</td>
	</tr>
</table>